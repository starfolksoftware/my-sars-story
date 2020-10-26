<?php

namespace App\Http\Controllers\Members;

use App\Model\Memorial\Memorial;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
      $memorials = Memorial::latest()->all();
    } else {
      $memorials = Memorial::latest()->paginate();
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
        $memorial = Memorial::findOrFail($id);

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
      'post_id' => request('post_id'),
      'avatar' => request('avatar')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required',
      'profession' => 'required'
    ], $messages)->validate();

    $memorial = $id !== 'create' ? Memorial::find($id) : new Memorial(['id' => request('id')]);

    $memorial->fill($data);
    $memorial->save();

    return response()->json($memorial->refresh(), 201);
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
