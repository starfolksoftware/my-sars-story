<?php

namespace App\Http\Controllers\Location;

use App\Model\Location\{State,LocalGovernment};
use Illuminate\Http\Request;

class StateController extends \App\Http\Controllers\Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (request()->has('localGovernment')) {
      $localGovernment  = LocalGovernment::findOrFail(request('localGovernment'));
      $state = $localGovernment->state()->paginate();
      return response()->json($state);
    }

    if (request()->has('all') && request('all') == 1) {
      $states = State::all();
      return response()->json($states);
    }

    $states = State::with('localGovernments')->orderBy('name', 'ASC')->paginate();

    return response()->json($states);
  }
}
