<?php

namespace App\Http\Controllers\Blog;

use App\Model\Blog\Post;
use App\Model\Blog\Tag;
use App\Model\Blog\Topic;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use StarfolkSoftware\Analytics\Events\Viewed;
use Illuminate\Database\Eloquent\Model;

class PostController extends \App\Http\Controllers\Controller
{
  /**
   * Get all the posts.
   *
   * @return JsonResponse
   */
  public function index(): JsonResponse
  {
    $isAdminOrEditor = request()->user()->hasAnyRole(['Admin', 'Editor']);

    $publishedCount = $isAdminOrEditor ? 
      Post::published()->count() : Post::forCurrentUser()->published()->count();
    $draftCount = Post::forCurrentUser()->draft()->count();
    $approvedCount = Post::forCurrentUser()->approved()->count();
    $submittedCount = $isAdminOrEditor ? 
      Post::submitted()->count() : Post::forCurrentUser()->submitted()->count();
    
    $results = [
      'posts' => [],
      'draftCount' => $draftCount,
      'publishedCount' => $publishedCount,
      'submittedCount' => $submittedCount,
      'approvedCount' => $approvedCount,
    ];

    if (request()->query('postType') == 'draft') {
      $results['posts'] = Post::forCurrentUser()->draft()->latest()->withCount('views')->with('user')->with('editor')->paginate();
    } else if (request()->query('postType') == 'forApproval') {
      $results['posts'] = $isAdminOrEditor ? 
        Post::submitted()->latest()->withCount('views')->with('user')->with('editor')->paginate() :
        Post::forCurrentUser()->submitted()->latest()->withCount('views')->with('user')->with('editor')->paginate();
    } else if (request()->query('postType') == 'approved') {
      $results['posts'] = $isAdminOrEditor ? 
        Post::approved()->latest()->withCount('views')->with('user')->with('editor')->paginate() :
        Post::forCurrentUser()->approved()->latest()->withCount('views')->with('user')->with('editor')->paginate();
    } else {
      $results['posts'] = $isAdminOrEditor ? 
        Post::published()->latest()->withCount('views')->with('user')->with('editor')->paginate() : 
        Post::forCurrentUser()->published()->latest()->withCount('views')->with('user')->with('editor')->paginate();
    }

    return response()->json($results, 200);
  }

  /**
   * Get a single post or return a UUID to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    $isAdminOrEditor = request()->user()->hasAnyRole(['Admin', 'Editor']);

    $containsId = $isAdminOrEditor ?
      Post::pluck('id')->contains($id) : Post::forCurrentUser()->pluck('id')->contains($id);

    if ($containsId || $this->isNewPost($id)) {
      if (!$isAdminOrEditor) {
        $tags = Tag::forCurrentUser()->get(['name', 'slug']);
        $topics = Topic::forCurrentUser()->get(['name', 'slug']);
      } else {
        $tags = Tag::get(['name', 'slug']);
        $topics = Topic::get(['name', 'slug']);
      }

      if ($this->isNewPost($id)) {
        $uuid = Uuid::uuid4();

        return response()->json([
          'post' => Post::make([
            'id' => $uuid->toString(),
            'slug' => "post-{$uuid->toString()}",
            'user_id' => request()->user()->id,
          ]),
          'tags' => $tags,
          'topics' => $topics
        ]);
      } else {
        $post = $isAdminOrEditor ? 
          Post::with('tags:name,slug', 'topic:name,slug')->find($id) :
          Post::forCurrentUser()->with('tags:name,slug', 'topic:name,slug')->find($id);
        
        event(new Viewed($post));

        return response()->json([
          'post' => $post,
          'tags' => $tags,
          'topics' => $topics
        ]);
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a post.
   *
   * @param string $id
   * @return JsonResponse
   * @throws Exception
   */
  public function store(string $id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'slug' => request('slug'),
      'title' => request('title', 'Title'),
      'summary' => request('summary', null),
      'body' => request('body', null),
      'submitted_at' => request('submitted_at', null),
      'approved_at' => request('approved_at', null),
      'editor_id' => request('editor_id') === 'approved' ? request()->user()->id : request('editor_id'),
      'published_at' => request('published_at', null),
      'featured_image' => request('featured_image', null),
      'featured_image_caption' => request('featured_image_caption', null),
      'user_id' => $this->isNewPost(request('id')) ? request()->user()->id : request('user_id'),
      'meta' => [
        'description' => request('meta.description', null),
        'title' => request('meta.title', null),
        'canonical_link' => request('meta.canonical_link', null),
      ],
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'user_id' => 'required',
      'slug' => [
        'required',
        'alpha_dash',
        // Rule::unique('posts')->where(function ($query) use ($data) {
        //     return $query->where('slug', $data['slug'])->where('user_id', $data['user_id']);
        // })->ignore($id),
      ],
    ], $messages)->validate();

    $post = $id !== 'create' ? Post::find($id) : new Post(['id' => request('id')]);

    $post->fill($data);
    $post->meta = $data['meta'];
    $post->save();

    $post->topic()->sync(
      $this->syncTopic(request('topic'))
    );

    $post->tags()->sync(
      $this->syncTags(request('tags'))
    );

    return response()->json($post->refresh());
  }

  /**
   * Delete a post.
   *
   * @param string $id
   * @return mixed
   */
  public function destroy(string $id)
  {
    $post = Post::find($id);

    if ($post) {
      $post->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new post.
   *
   * @param string $id
   * @return bool
   */
  private function isNewPost(string $id): bool
  {
    return $id === 'create';
  }

  /**
   * Attach or create a given topic.
   *
   * @param $incomingTopic
   * @return array
   * @throws Exception
   */
  private function syncTopic($incomingTopic): array
  {
    if ($incomingTopic) {
      $topic = Topic::where('slug', $incomingTopic['slug'])->first();

      if (! $topic) {
        $topic = Topic::create([
          'id' => $id = Uuid::uuid4(),
          'name' => $incomingTopic['name'],
          'slug' => $incomingTopic['slug'],
          'user_id' => request()->user()->id,
        ]);
      }

      return collect((string) $topic->id)->toArray();
    } else {
      return [];
    }
  }

  /**
   * Attach or create tags given an incoming array.
   *
   * @param array $incomingTags
   * @return array
   */
  private function syncTags(array $incomingTags): array
  {
    if ($incomingTags) {
      $tags = Tag::forCurrentUser()->get(['id', 'name', 'slug']);

      return collect($incomingTags)->map(function ($incomingTag) use ($tags) {
        $tag = $tags->where('slug', $incomingTag['slug'])->first();

        if (! $tag) {
          $tag = Tag::create([
            'id' => $id = Uuid::uuid4(),
            'name' => $incomingTag['name'],
            'slug' => $incomingTag['slug'],
            'user_id' => request()->user()->id,
          ]);
        }

        return (string) $tag->id;
      })->toArray();
    } else {
      return [];
    }
  }
}
