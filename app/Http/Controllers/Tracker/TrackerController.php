<?php

namespace App\Http\Controllers\Tracker;

use App\Models\Tracker\Tracker;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackerController extends \App\Http\Controllers\Controller
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
      $trackers = Tracker::all();
    } else {
      $trackers = Tracker::orderBy('name')
        ->paginate();
    }
    return response()->json(
      $trackers, 200
    );
  }

  /**
   * Get a single tracker or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Tracker::all()->pluck('id')->contains($id) || $this->isNewTracker($id)) {
      if ($this->isNewTracker($id)) {
        return response()->json(Tracker::make([
          'id' => NULL,
        ]), 200);
      } else {
        $tracker = Tracker::find($id);

        return response()->json($tracker, 200);
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a tracker.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
      'description' => request('description'),
      'fields' => request('fields'),
      'has_location' => request('has_location'),
      'has_user_reporting' => request('has_user_reporting'),
      'has_bot' => request('has_bot'),
      'bot_name' => request('bot_name'),
      'user_id' => $this->isNewTracker(request('id')) ? request()->user()->id : request('user_id')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required',
      'fields' => 'required',
      'has_location' => 'required',
      'has_user_reporting' => 'required',
      'has_bot' => 'required',
      'user_id' => 'required'
    ], $messages)->validate();

    $tracker = $id !== 'create' ? Tracker::find($id) : new Tracker(['id' => request('id')]);

    $tracker->fill($data);
    $tracker->save();

    return response()->json($tracker->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $tracker = Tracker::find($id);

    if ($tracker) {
      $tracker->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new tracker.
   *
   * @param string $id
   * @return bool
   */
  private function isNewTracker($id): bool
  {
    return $id === 'create' || $id === NULL;
  }
}
