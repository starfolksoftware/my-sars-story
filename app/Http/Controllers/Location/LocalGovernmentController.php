<?php

namespace App\Http\Controllers\Location;

use App\Models\Location\{LocalGovernment,State};
use Illuminate\Http\Request;

class LocalGovernmentController extends \App\Http\Controllers\Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (request()->has('state') && request('state') != 'all') {
      $state  = State::findOrFail(request('state'));
      $localGovernments = $state->localGovernments()->paginate(50);
      return response()->json($localGovernments);
    }

    if (request()->has('all') && request('all') == 1) {
      $localGovernments = LocalGovernment::all();
      return response()->json($localGovernments);
    }

    $localGovernments = LocalGovernment::orderBy('name', 'ASC')->paginate();

    return response()->json($localGovernments);
  }
}
