<?php

namespace App\Http\Controllers\Partners;

use App\Models\Partners\Partner;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerController extends \App\Http\Controllers\Controller
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
      $partners = Partner::all();
    } else {
      $partners = Partner::orderBy('name')
        ->paginate();
    }
    return response()->json(
      $partners, 200
    );
  }

  /**
   * Get a single partner or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Partner::all()->pluck('id')->contains($id) || $this->isNewPartner($id)) {
      if ($this->isNewPartner($id)) {
        return response()->json([
          'id' => NULL,
        ], 200);
      } else {
        $partner = Partner::find($id);

        return response()->json($partner, 200);
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a partner.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
      'url' => request('url'),
      'logo' => request('logo'),
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required'
    ], $messages)->validate();

    $partner = $id !== 'create' ? Partner::find($id) : new Partner(['id' => request('id')]);

    $partner->fill($data);
    $partner->save();

    return response()->json($partner->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $partner = Partner::find($id);

    if ($partner) {
      $partner->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new partner.
   *
   * @param string $id
   * @return bool
   */
  private function isNewPartner(string $id): bool
  {
    return $id === 'create';
  }
}
