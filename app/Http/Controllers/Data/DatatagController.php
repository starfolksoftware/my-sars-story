<?php

namespace App\Http\Controllers\Data;

use App\Model\Data\Datatag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use DB;

class DatatagController extends \App\Http\Controllers\Controller
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
      $datatags = Datatag::all();
    } else {
      $datatags = Datatag::orderBy('name')
        ->paginate();
    }
    return response()->json(
      $datatags, 200
    );
  }

  /**
   * Get a single datatag or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   */
  public function show($id = null): JsonResponse
  {
    if (Datatag::all()->pluck('id')->contains($id) || $this->isNewDatatag($id)) {
      if ($this->isNewDatatag($id)) {
        return response()->json([
          'id' => NULL,
        ], 200);
      } else {
        $datatag = Datatag::find($id);

        if ($datatag) {
          return response()->json($datatag, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a datatag.
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
      $datatag = Datatag::find($id);
    } else {
      if ($datatag = Datatag::onlyTrashed()->where('id', $id)->first()) {
        $datatag->restore();
      } else {
        $datatag = new Datatag(['id' => request('id')]);
      }
    }

    $datatag->fill($data);
    $datatag->save();

    return response()->json($datatag->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $datatag = Datatag::find($id);

    if ($datatag) {
      $datatag->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new datatag.
   *
   * @param string $id
   * @return bool
   */
  private function isNewDatatag(string $id): bool
  {
    return $id === 'create';
  }
}
