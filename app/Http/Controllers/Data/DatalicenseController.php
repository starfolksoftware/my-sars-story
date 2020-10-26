<?php

namespace App\Http\Controllers\Data;

use App\Model\Data\Datalicense;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DatalicenseController extends \App\Http\Controllers\Controller
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
      $datalicenses = Datalicense::all();
    } else {
      $datalicenses = Datalicense::orderBy('name')
        ->paginate();
    }
    return response()->json(
      $datalicenses, 200
    );
  }

  /**
   * Get a single datalicense or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   */
  public function show($id = null): JsonResponse
  {
    if (Datalicense::all()->pluck('id')->contains($id) || $this->isNewDatalicense($id)) {
      if ($this->isNewDatalicense($id)) {
        $id = DB::select("SHOW TABLE STATUS LIKE 'datalicenses'");
        return response()->json([
          'id' => $id[0]->Auto_increment,
        ], 200);
      } else {
        $datalicense = Datalicense::find($id);

        if ($datalicense) {
          return response()->json($datalicense, 200);
        } else {
          return response()->json(null, 301);
        }
      }
    }
  }

  /**
   * Create or update a datalicense.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
      'link' => request('link')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required'
    ], $messages)->validate();

    if ($id !== 'create') {
      $datalicense = Datalicense::find($id);
    } else {
      if ($datalicense = Datalicense::onlyTrashed()->where('id', $id)->first()) {
        $datalicense->restore();
      } else {
        $datalicense = new Datalicense(['id' => request('id')]);
      }
    }

    $datalicense->fill($data);
    $datalicense->save();

    return response()->json($datalicense->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $datalicense = Datalicense::find($id);

    if ($datalicense) {
      $datalicense->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new datalicense.
   *
   * @param string $id
   * @return bool
   */
  private function isNewDatalicense(string $id): bool
  {
    return $id === 'create';
  }
}
