<?php

namespace App\Http\Controllers\Data;

use App\Model\Data\Dataformat;
use Illuminate\Http\JsonResponse;

class DataformatController extends \App\Http\Controllers\Controller
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
      $dataformats = Dataformat::all();
    } else {
      $dataformats = Dataformat::orderBy('name')
        ->paginate();
    }
    return response()->json(
      $dataformats, 200
    );
  }

  /**
   * Get a single dataformat or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   */
  public function show($id = null): JsonResponse
  {
    if (Dataformat::all()->pluck('id')->contains($id) || $this->isNewDataformat($id)) {
      if ($this->isNewDataformat($id)) {
        return response()->json([
          'id' => NULL,
        ], 200);
      } else {
        $dataformat = Dataformat::find($id);

        if ($dataformat) {
          return response()->json($dataformat, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a dataformat.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
      'extension' => request('extension')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required',
      'extension' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $dataformat = Dataformat::find($id);
    } else {
      if ($dataformat = Dataformat::onlyTrashed()->where('id', $id)->first()) {
        $dataformat->restore();
      } else {
        $dataformat = new Dataformat(['id' => request('id')]);
      }
    }

    $dataformat->fill($data);
    $dataformat->save();

    return response()->json($dataformat->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $dataformat = Dataformat::find($id);

    if ($dataformat) {
      $dataformat->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new dataformat.
   *
   * @param string $id
   * @return bool
   */
  private function isNewDataformat(string $id): bool
  {
    return $id === 'create';
  }
}
