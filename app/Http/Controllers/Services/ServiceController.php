<?php

namespace App\Http\Controllers\Services;

use App\Model\Services\Service;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends \App\Http\Controllers\Controller
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
      $services = Service::all();
    } else {
      $services = Service::orderBy('name')
        ->paginate();
    }
    return response()->json(
      $services, 200
    );
  }

  /**
   * Get a single service or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Service::all()->pluck('id')->contains($id) || $this->isNewService($id)) {
      if ($this->isNewService($id)) {
        return response()->json([
          'id' => NULL,
        ], 200);
      } else {
        $service = Service::find($id);

        return response()->json($service, 200);
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a service.
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
      'thumbnail' => request('thumbnail')
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required',
      'description' => 'required',
    ], $messages)->validate();

    $service = $id !== 'create' ? Service::find($id) : new Service(['id' => request('id')]);

    $service->fill($data);
    $service->save();

    return response()->json($service->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $service = Service::find($id);

    if ($service) {
      $service->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new service.
   *
   * @param string $id
   * @return bool
   */
  private function isNewService(string $id): bool
  {
    return $id === 'create';
  }
}
