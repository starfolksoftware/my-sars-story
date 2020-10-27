<?php

namespace App\Http\Controllers\Blog;

use App\Models\Auth\User;
use StarfolkSoftware\Analytics\Events\Viewed;
use App\Models\Blog\Post;
use App\Models\Auth\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use App\Http\Controllers\Controller;

class BlogPostController extends Controller
{
    /**
     * The user associated with a post.
     *
     * @var User
     */
    protected $user;

    /**
     * The metadata associated with a user.
     *
     * @var UserMeta
     */
    protected $userMeta;

    /**
     * Specify if related posts should be returned.
     *
     * @var bool
     */
    protected $showRelated = true;

    /**
     * The posts with a similar taxonomy.
     *
     * @var array
     */
    protected $relatedPosts = [];

    /**
     * Get all the posts, tags, and topics.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $limit = NULL)
    {
        $posts = Post::published()
                     ->withUserMeta()
                     ->with(['user'])
                     ->orderByDesc('published_at')
                     ->get();

        if ($limit) {
          $posts = Post::all()->take(5);
        }

        $posts->each->append('read_time');

        return response()->json([
            'posts' => $posts,
        ]);
    }

    /**
     * Show a given post.
     *
     * @param Request $request
     * @param string $identifier
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $identifier, string $slug = null)
    {
        $posts = Post::published()->withUserMeta()->get();
        $post = $posts->firstWhere('slug', $slug);

        $metaData = UserMeta::forCurrentUser()->first();
        $emailHash = Auth::check() ? md5(trim(Str::lower(request()->user()->email))) : '';

        if ($this->isPublished($post)) {
          $this->user = User::where('id', $identifier)->first();

          if ($this->user) {
            $this->userMeta = UserMeta::where('user_id', $this->user->id)->first();
          }

          $post->append('read_time');

          event(new Viewed($post));

          return response()->json([
            'post' => $post,
            'user' => $post->user,
            'username' => optional($this->userMeta)->username,
            'avatar' => optional($metaData)->avatar && ! empty(optional($metaData)->avatar) ? $metaData->avatar : "https://secure.gravatar.com/avatar/{$emailHash}?s=500",
            'meta' => $post->meta,
            'related' => $this->showRelated ? $this->getRelatedViaTaxonomy($post, $posts) : [],
          ]);
        } else {
          return response()->json(null, 404);
        }
    }

    /**
     * Filter posts from a given pool to find similarity. Similarity is defined
     * as simply sharing a basic taxonomy: in this case, a "tag" or "topic".
     *
     * @param $post
     * @param $posts
     * @return array
     */
    private function getRelatedViaTaxonomy($post, $posts): array
    {
        if ($post->tags || $post->topic) {
            $this->relatedPosts = collect($posts)->filter(function ($item, $key) use ($post) {
                $matchedTag = array_intersect(
                    $item->tags->pluck('slug')->toArray(), $post->tags->pluck('slug')->toArray()
                );

                $matchedTopic = array_intersect(
                    $item->topic->pluck('slug')->toArray(), $post->topic->pluck('slug')->toArray()
                );

                return $item->id != $post->id && ($matchedTag || $matchedTopic);
            })->toArray();
        }

        return array_values($this->relatedPosts);
    }

    /**
     * Return true if the post is published.
     *
     * @param $post
     * @return bool
     */
    private function isPublished($post): bool
    {
        return $post && $post->published;
    }
}
