<?php

namespace App\Http\Controllers\Tracker;

use App\Models\Tracker\TrackerItem;
use App\Models\Tracker\Tracker;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Auth;

class TrackerItemController extends \App\Http\Controllers\Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($trackerId): JsonResponse
  {
    $tracker = Tracker::find($trackerId);

    $confirmedCount = $tracker->trackedItems()->confirmed()->count();
    $notConfirmedCount = $tracker->trackedItems()->notConfirmed()->count();

    $trackerItems = $tracker->trackedItems();

    if (!auth()->guard('api')->check() || request()->query('confirmationStatus') == 'confirmed') {
      $trackerItems = $trackerItems->confirmed();
    } else if (request()->query('confirmationStatus') == 'notConfirmed') {
      $trackerItems = $trackerItems->notConfirmed();
    }

    if (request()->has('query')) {
      $query = request('query');
      $trackerItems = $trackerItems->whereRaw("MATCH(meta_virtual)
        AGAINST('$query' IN NATURAL LANGUAGE MODE)");
    }

    if (request()->has('forMap') && request('forMap') == 1) {
      $markers = $this->buildMarkers($trackerItems);
      return response()->json($markers, 200);
    }

    return response()->json([
      'trackerItems' => $trackerItems
        ->with(['user', 'tracker', 'state', 'localGovernment'])
        ->latest()
        ->paginate(),
      'confirmedCount' => $confirmedCount,
      'notConfirmedCount' => $notConfirmedCount
    ], 200);
  }

  private function buildMarkers($builder) {
    $trackers = $builder->with(['user', 'tracker', 'state', 'localGovernment'])->latest()->get();
    return collect($trackers)->map(function ($item, $key) {
      if (data_get($item, 'meta.latitude') && data_get($item, 'meta.longitude')) {
        $latitude = data_get($item, 'meta.latitude');
        $longitude = data_get($item, 'meta.longitude');
      } else {
        $latitude = $item->localGovernment->latitude;
        $longitude = $item->localGovernment->longitude;
      }

      return array(
        "id" => $item["id"],
        "position" => array(
          $latitude,
          $longitude
        ),
        "details" => $this->buildDetails($item->meta),
        "tooltip" => $item->tracker->name,
        "draggable" => FALSE,
        "visible" => TRUE
      );
    })->toArray();
  }

  private function buildDetails($meta) {
    $html = "<ul class='list-group list-group-flush'>";

    foreach ($meta as $key => $value) {
      if (collect(['undefined', 'latitude', 'longitude'])->contains($key)) {
        continue;
      }

      $value = preg_replace(
        '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
        "<a href=\"$1\" target=\"_blank\">$3</a>$4",
        $value
      );

      $html .= "<li class='list-group-item'>$key: $value</li>";
    }

    $html .= "</ul>";

    return $html;
  }

  /**
   * Get a single trackerItem or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($trackerId, $id = null): JsonResponse
  {
    if (TrackerItem::all()->pluck('id')->contains($id) || $this->isNewTrackerItem($id)) {
      if ($this->isNewTrackerItem($id)) {
        return response()->json(TrackerItem::make([
          'id' => NULL,
        ]), 200);
      } else {
        $trackerItem = TrackerItem::where('id', $id)->with('comments.commentator')->first();

        return response()->json($trackerItem, 200);
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a trackerItem.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($trackerId, $id): JsonResponse
  {
    if (request()->has('comment')) {
      $trackerItem = TrackerItem::find($id);
      $comment = $trackerItem->comment(request('comment'));
      return response()->json($comment, 201);
    }

    $data = [
      'id' => request('id'),
      'tracker_id' => request('tracker_id'),
      'title' => request('title'),
      'description' => request('description'),
      'meta' => request('meta'),
      'confirmed' => request('confirmed'),
      'email' => request('email'),
      'phone_number' => request('phone_number'),
      'featured_image' => request('featured_image'),
      'state_id' => request('state_id'),
      'local_government_id' => request('local_government_id'),
      'user_id' => Auth::check() ? request()->user()->id : NULL
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'tracker_id' => 'required',
      'title' => 'required',
      'description' => 'required',
      'meta' => 'required',
      'confirmed' => 'required',
      'state_id' => 'required',
      'local_government_id' => 'required',
    ], $messages)->validate();

    $trackerItem = $id !== 'create' ? TrackerItem::find($id) : new TrackerItem(['id' => request('id')]);

    $trackerItem->fill($data);
    $trackerItem->save();

    $trackerItem = $trackerItem->refresh();

    return response()->json($trackerItem->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($trackerId, $id)
  {
    $trackerItem = TrackerItem::find($id);

    if ($trackerItem) {
      $trackerItem->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new trackerItem.
   *
   * @param string $id
   * @return bool
   */
  private function isNewTrackerItem($id): bool
  {
    if ($id === NULL) $id = 'create';

    return $id === 'create' ;
  }
}
