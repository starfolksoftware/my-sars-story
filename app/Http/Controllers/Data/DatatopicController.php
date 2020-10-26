<?php

namespace App\Http\Controllers\Data;

use App\Model\Data\Datatopic;
use Illuminate\Http\JsonResponse;
use DB;

class DatatopicController extends \App\Http\Controllers\Controller
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
      $datatopics = Datatopic::all();
    } else {
      $datatopics = Datatopic::orderBy('name')
        ->paginate();
    }
    return response()->json(
      $datatopics, 200
    );
  }

  /**
   * Get a single datatopic or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   */
  public function show($id = null): JsonResponse
  {
    if (Datatopic::all()->pluck('id')->contains($id) || $this->isNewDatatopic($id)) {
      if ($this->isNewDatatopic($id)) {
        return response()->json([
          'id' => NULL,
        ], 200);
      } else {
        $datatopic = Datatopic::find($id);

        if ($datatopic) {
          return response()->json($datatopic, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a datatopic.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $datatopic = Datatopic::find($id);
    } else {
      if ($datatopic = Datatopic::onlyTrashed()->where('id', $id)->first()) {
        $datatopic->restore();
      } else {
        $datatopic = new Datatopic(['id' => request('id')]);
      }
    }

    $datatopic->fill($data);
    $datatopic->save();

    return response()->json($datatopic->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $datatopic = Datatopic::find($id);

    if ($datatopic) {
      $datatopic->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new datatopic.
   *
   * @param string $id
   * @return bool
   */
  private function isNewDatatopic(string $id): bool
  {
    return $id === 'create';
  }
}
