<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends \App\Http\Controllers\Controller
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
      $roles = Role::all()->pluck('name');
    } else {
      $roles = Role::orderBy('name')
        ->withCount('permissions')
        ->paginate();
    }
    return response()->json(
      $roles, 200
    );
  }

  /**
   * Get a single role or return an id to create one.
   *
   * @param null $id
   * @return JsonResponse
   * @throws Exception
   */
  public function show($id = null): JsonResponse
  {
    if (Role::all()->pluck('id')->contains($id) || $this->isNewRole($id)) {
      if ($this->isNewRole($id)) {
        return response()->json([
          'role' => Role::make([
            'id' => NULL
          ]),
          'permissions' => Permission::get(['id', 'name'])
        ], 200);
      } else {
        $role = Role::with('permissions:id,name')->find($id);

        return response()->json([
          'role' => $role,
          'permissions' => Permission::get(['id', 'name'])
        ], 200);
      }
    } else {
      return response()->json(null, 301);
    }
  }

  /**
   * Create or update a role.
   *
   * @param string $id
   * @return JsonResponse
   */
  public function store($id): JsonResponse
  {
    $data = [
      'id' => request('id'),
      'name' => request('name'),
    ];

    $messages = [
      'required' => __('app.validation_required'),
      'unique' => __('app.validation_unique'),
    ];

    validator($data, [
      'name' => 'required'
    ], $messages)->validate();

    $role = $id !== 'create' ? Role::find($id) : new Role(['id' => request('id')]);

    // $role->fill($data);
    // $role->save();
    $role = Role::firstOrCreate(['guard_name' => 'web', 'name' => $data['name']]);

    // admin role has everything
    if($role->name === 'Admin') {
      $role->syncPermissions(Permission::all());
    } else {
      $role->syncPermissions(request('permissions', []));
    }

    return response()->json($role->refresh(), 201);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $role = Role::find($id);

    if ($role) {
      $role->syncPermissions([]);
      $role->delete();

      return response()->json([], 204);
    }
  }

  /**
   * Return true if we're creating a new role.
   *
   * @param string $id
   * @return bool
   */
  private function isNewRole(string $id): bool
  {
    return $id === 'create';
  }
}
