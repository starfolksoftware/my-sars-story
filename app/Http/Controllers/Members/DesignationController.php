<?php

namespace App\Http\Controllers\Members;

use App\Model\Members\Designation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DesignationController extends \App\Http\Controllers\Controller
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
      $designations = Designation::all();
    } else {
      $designations = Designation::orderBy('title')
        ->paginate();
    }
    return response()->json(
      $designations, 200
    );
  }

  /**
   * Get a single designation or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Designation::all()->pluck('id')->contains($id) || $this->isNewDesignation($id)) {
      if ($this->isNewDesignation($id)) {
        return response()->json([
          'id' => NULL,
        ], 200);
      } else {
        $designation = Designation::find($id);

        return response()->json($designation, 200);
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a designation.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'title' => request('title')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'title' => 'required'
    ], $messages)->validate();

    $designation = $id !== 'create' ? Designation::find($id) : new Designation(['id' => request('id')]);

    $designation->fill($data);
    $designation->save();

    return response()->json($designation->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $designation = Designation::find($id);

    if ($designation) {
      $designation->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new designation.
   *
   * @param string $id
   * @return bool
   */
  private function isNewDesignation(string $id): bool
  {
    return $id === 'create';
  }
}
