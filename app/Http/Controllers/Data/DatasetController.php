<?php

namespace App\Http\Controllers\Data;

use App\Model\Data\{
  Dataset,
  Datatopic,
  Datatag,
  Datalicense,
  Dataformat,
};
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use DB;
use StarfolkSoftware\Analytics\Events\Viewed;

class DatasetController extends \App\Http\Controllers\Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(): JsonResponse
  {
    $isAdminOrDataEditor = request()->user()->hasAnyRole(['Admin', 'Data Researcher & Editor']);

    $publishedCount = $isAdminOrDataEditor ? 
      Dataset::published()->count() : Dataset::forCurrentUser()->published()->count();
    $draftCount = Dataset::forCurrentUser()->draft()->count();
    $approvedCount = Dataset::forCurrentUser()->approved()->count();
    $submittedCount = $isAdminOrDataEditor ? 
      Dataset::submitted()->count() : Dataset::forCurrentUser()->submitted()->count();

    $results = [
      'datasets' => [],
      'draftCount' => $draftCount,
      'publishedCount' => $publishedCount,
      'submittedCount' => $submittedCount,
      'approvedCount' => $approvedCount,
    ];

    if (request()->query('datasetType') == 'draft') {
      $results['datasets'] = Dataset::forCurrentUser()
        ->draft()
        ->latest()
        ->withCount('views')
        ->with('user', 'resources')
        ->with('approvedBy')
        ->paginate();
    } else if (request()->query('datasetType') == 'forApproval') {
      $results['datasets'] = $isAdminOrDataEditor ? 
        Dataset::submitted()
          ->latest()
          ->withCount('views')
          ->with('user', 'resources')
          ->with('approvedBy')
          ->paginate() :
        Dataset::forCurrentUser()
          ->submitted()
          ->latest()
          ->withCount('views')
          ->with('user', 'resources')
          ->with('approvedBy')
          ->paginate();
    } else if (request()->query('datasetType') == 'approved') {
      $results['datasets'] = $isAdminOrDataEditor ? 
        Dataset::approved()
          ->latest()
          ->withCount('views')
          ->with('user', 'resources')
          ->with('approvedBy')
          ->paginate() :
        Dataset::forCurrentUser()
          ->approved()
          ->latest()
          ->withCount('views')
          ->with('user', 'resources')
          ->with('approvedBy')
          ->paginate();
    } else {
      $results['datasets'] = $isAdminOrDataEditor ? 
        Dataset::published()
          ->latest()
          ->withCount('views')
          ->with('user', 'resources')
          ->with('approvedBy')
          ->paginate() : 
        Dataset::forCurrentUser()
          ->published()
          ->latest()
          ->withCount('views')
          ->with('user', 'resources')
          ->with('approvedBy')
          ->paginate();
    }

    return response()->json($results, 200);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function indexPublishedOnly(): JsonResponse {
    if (request()->has('filter') && request()->has('filterId')) {
      $filter = request('filter');
      $filterId = request('filterId');
      switch ($filter) {
        case 'license':
          $datasets = Datalicense::findOrFail($filterId)->datasets()->published()->latest(); 
          break;

        case 'topics':
          $datasets = Datatopic::findOrFail($filterId)->datasets()->published()->latest();
          break;

        case 'tags':
          $datasets = Datatag::findOrFail($filterId)->datasets()->published()->latest();
          break;

        default:
          $datasets = Dataset::latest();
          break;
      }
    } else {
      $datasets = Dataset::published()->latest();
    }

    if (request()->has('query')) {
      $query = request('query');
      $datasets = $datasets->whereRaw("MATCH(title,description)
        AGAINST('$query' IN NATURAL LANGUAGE MODE)")->latest();
    }

    return response()->json(
      $datasets
        ->with('user', 'resources.format')
        ->paginate(), 200
    );
  }

  /**
   * Get a single dataset or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   */
  public function show($id = null): JsonResponse
  {
    $isAdminOrDataEditor = request()->user()->hasAnyRole(['Admin', 'Data Researcher & Editor']);

    $containsId = $isAdminOrDataEditor ?
      Dataset::pluck('id')->contains($id) : Dataset::forCurrentUser()->pluck('id')->contains($id);

    if ($containsId || $this->isNewDataset($id)) {
      $topics = Datatopic::get(['id', 'name']);
      $tags = Datatag::get(['id', 'name']);
      $licenses = Datalicense::get(['id', 'name']);
      $formats = Dataformat::get(['id', 'name', 'extension']);

      if ($this->isNewDataset($id)) {
        // DB::statement('SET PERSIST information_schema_stats_expiry = 0');
        $statement = DB::select("SHOW TABLE STATUS LIKE 'datasets'");
        return response()->json([
          'dataset' => Dataset::make([
            'id' => $statement[0]->Auto_increment,
            'title' => 'Title',
            'description' => 'Enter some description for your dataset...',
            'user_id' => request()->user()->id,
          ]),
          'topics' => $topics,
          'licenses' => $licenses,
          'formats' => $formats
        ], 200);
      } else {
        $dataset = $isAdminOrDataEditor ? 
          Dataset::with(['resources', 'resources.user', 'resources.format', 'license', 'user', 'topics', 'tags'])->find($id) :
          Dataset::forCurrentUser()->with(['resources', 'resources.user', 'resources.format', 'license', 'user', 'topics', 'tags'])->find($id);

        event(new Viewed($dataset));

        return response()->json([
          'dataset' => $dataset,
          'topics' => $topics,
          'tags' => $tags,
          'licenses' => $licenses,
          'formats' => $formats
        ], 200); 
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Get a single dataset or return an id to create one.
   *
   * @param $id
   * @return JsonResponse
   */
  public function showPublishedOnly($id): JsonResponse
  {
    $containsId = Dataset::pluck('id')->contains($id);

    if ($containsId || $this->isNewDataset($id)) {
      $topics = Datatopic::get(['id', 'name']);
      $tags = Datatag::get(['id', 'name']);
      $licenses = Datalicense::get(['id', 'name']);
      $formats = Dataformat::get(['id', 'name', 'extension']);

      $dataset = Dataset::with(['resources', 'resources.user', 'resources.format', 'license', 'user', 'topics', 'tags'])->find($id);

      event(new Viewed($dataset));
      
      return response()->json([
        'dataset' => $dataset,
        'topics' => $topics,
        'tags' => $tags,
        'licenses' => $licenses,
        'formats' => $formats
      ], 200); 
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a dataset.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'title' => request('title'),
      'description' => request('description'),
      'datalicense_id' => request('datalicense_id'),
      'submitted_at' => request('submitted_at'),
      'approved_at' => request('approved_at'),
      'approved_by' => request('approved_by'),
      'published_at' => request('published_at'),
      'user_id' => $id === 'create' ? request()->user()->id : request('user_id'),
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
      'user_id' => 'required'
    ], $messages)->validate();

    $dataset = $id !== 'create' ? Dataset::find($id) : new Dataset(['id' => NULL]);

    $dataset->fill($data);
    $dataset->meta = $data['meta'];
    $dataset->save();

    $dataset->topics()->sync(
      $this->syncTopics(request('topics'))
    );

    $dataset->tags()->sync(
      $this->syncTags(request('tags'))
    );

    return response()->json($dataset->refresh());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $dataset = Dataset::find($id);

    if ($dataset) {
      $dataset->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new dataset.
   *
   * @param string $id
   * @return bool
   */
  private function isNewDataset(string $id): bool
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
  private function syncTopics($incomingTopic): array
  {
    if ($incomingTopic) {
      $topics = Datatopic::get(['id', 'name']);

      return collect($incomingTopic)->map(function ($incomingTopic) use ($topics) {
        $topic = $topics->find($incomingTopic['id']);

        if (! $topic) {
          $topic = Datatopic::create([
            'id' => NULL,
            'name' => $incomingTopic['name']
          ]);
        }

        return $topic->id;
      })->toArray();
    } else {
      return [];
    }
  }

  /**
   * Attach or create a given tag.
   *
   * @param $incomingTag
   * @return array
   * @throws Exception
   */
  private function syncTags($incomingTag): array
  {
    if ($incomingTag) {
      $tags = Datatag::get(['id', 'name']);

      return collect($incomingTag)->map(function ($incomingTag) use ($tags) {
        $tag = $tags->find($incomingTag['id']);

        if (! $tag) {
          $tag = Datatag::create([
            'id' => NULL,
            'name' => $incomingTag['name']
          ]);
        }

        return $tag->id;
      })->toArray();
    } else {
      return [];
    }
  }
}
