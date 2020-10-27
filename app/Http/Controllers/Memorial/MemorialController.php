<?php

namespace App\Http\Controllers\Memorial;

use App\Models\Memorial\Memorial;
use App\Models\Blog\Post;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Models\Blog\Topic;

class MemorialController extends \App\Http\Controllers\Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(): JsonResponse
  {
    $all = request('all') ?? NULL;
    
    if ($all) {
      $memorials = Memorial::with('post')->latest()->all();
    } else {
      $memorials = Memorial::with('post')->latest()->paginate();
    }
    return response()->json(
      $memorials, 200
    );
  }

  /**
   * Get a single memorial or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Memorial::all()->pluck('id')->contains($id) || $this->isNewMemorial($id)) {
      if ($this->isNewMemorial($id)) {
        return response()->json([
          'memorial' => Memorial::make([
            'id' => NULL,
          ]),
        ], 200);
      } else {
        $memorial = Memorial::with('post')->findOrFail($id);

        return response()->json([
          'memorial' => $memorial
        ], 200);
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a memorial.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
      'profession' => request('profession'),
      'age' => request('age'),
      'post_id' => request('post_id'),
      'avatar' => request('avatar')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required',
      'profession' => 'required',
      'age' => 'required',
    ], $messages)->validate();

    if ($id === 'create') {
      $data['post_id'] = $this->createStory(
        $data['name'], 
        $data['profession'], 
        $data['age']
      );
    }

    $memorial = $id !== 'create' ? Memorial::find($id) : new Memorial(['id' => request('id')]);

    $memorial->fill($data);
    $memorial->save();

    return response()->json($memorial->refresh(), 201);
  }

  private function createStory($name, $profession, $age) {
    $name = str_replace(" ", "-", $name);
    $profession = str_replace(" ", "-", $name);

    $data = [
      'id' => Uuid::uuid4(),
      'slug' => "$name-$profession-$age-dead-memorial",
      'title' => "$name, $profession; dies at $age",
      'summary' => "",
      'body' => "the body",
      'submitted_at' => NULL,
      'approved_at' => NULL,
      'editor_id' => NULL,
      'published_at' => NULL,
      'featured_image' => NULL,
      'featured_image_caption' => "",
      'user_id' => request()->user()->id,
      'meta' => [
        'description' => "",
        'title' => "$name, $profession; dies at $age",
        'canonical_link' => NULL,
      ],
    ];

    $post = new Post(['id' => $data['id']]);

    $post->fill($data);
    $post->meta = $data['meta'];
    $post->save();

    $post->topic()->sync(
      $this->syncTopic([
        'name' => 'Memorial',
        'slug' => 'memorial',
      ])
    );

    return $post->id;
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
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $memorial = Memorial::find($id);

    if ($memorial) {
      $memorial->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new memorial.
   *
   * @param string $id
   * @return bool
   */
  private function isNewMemorial(string $id): bool
  {
    return $id === 'create';
  }
}
