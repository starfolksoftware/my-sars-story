<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Auth\Role;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use App\Notifications\CustomUserAdded;

class UserController extends \App\Http\Controllers\Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index (Request $request) {
    $users = User::select("*");

    if (request()->has('role') && request('role') != 'all') {
      $users = $users->role(request('role'));
    }

    if ($request->has('query')) {
      $query = $request->input('query');
      $users = $users->whereRaw("MATCH(name, email)
        AGAINST('$query' IN NATURAL LANGUAGE MODE)");
    }

    return response()->json($users->latest()->with('roles')->paginate(), 200);
	}
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store ($id): JsonResponse {
        
        $data = [
            'id' => request('id'),
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password'),
            'password_confirmation' => request('password_confirmation'),
            'role' => request('role')
        ];

        if ($id !== 'create') {
            validator($data, [
                'name' => 'required',
                'email' => 'required',
                'role' => 'required|array'
            ])->validate();

            $user = User::findOrFail($id);
            
            if (isset($data['password']) && 
                isset($data['password_confirmation']) &&
                $data['password'] === $data['password_confirmation']) {
                $user->password = Hash::make($data['password']);
            }   
        } else {
            validator($data, [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|string|min:6',
                'role' => 'required|array'
            ])->validate();

            $user = User::where('email', $data['email'])->first();

            if ($user) {
                return response()->json([
                    'success' => 0,
                    'errors' => [
                      'email' => ['email already in use']
                    ]
                ], 500);
            }

            $user = new User();

            $user->password = Hash::make($data['password']);
        }
		
        $user->name = $data['name'];
        $user->email = $data['email'];
		
        if($user->save()) {
            // Handle the user roles
            $user->syncRoles($data['role']);

            if ($id === 'create') {
                $customUserDetails = array(
                    "name" => $user->name,
                    "email" => $user->email,
                    "plainPassword" => $data['password']
                );
                try {
                    $user->notify(new CustomUserAdded($customUserDetails));
                } catch (Exception $e) {
                    throw $e;
                }
            }

            return response()->json($user->refresh(), 201);
        } else {
            return response()->json([
                'success' => 0,
                'errors' => [
                    'server' => ['something went wrong...try again']
                ]
            ], 500);
        }
	}
	
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auth\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show ($id = null) {
        if (User::all()->pluck('id')->contains($id) || $this->isNewUser($id)) {
            if ($this->isNewUser($id)) {
                $id = DB::select("SHOW TABLE STATUS LIKE 'users'");
                return response()->json([
                    'id' => $id[0]->Auto_increment,
                ], 200);
            } else {
                $user = User::find($id);

                if (!((Auth::user()->hasAnyPermission(['view_own_users']) && 
                    $user->id === request()->user()->id) || Auth::user()->hasAnyPermission(['view_users']))) {
                    return response()->json([
                        'success' => 0,
                        'errors' => [
                            'server' => ['you dont have permission']
                        ]
                    ], 500);
                };

                if ($user) {
                    return response()->json(new UserResource($user), 200);
                } else {
                    return response()->json(null, 301);
                }
            }
        }
	}
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auth\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (request()->user()->id === $id) {
          return response()->json([
                'success' => 0,
                'errors' => [
                    'server' => ['you can not delete yourself']
                ]
          ], 500);
        }
        
        $user = User::findOrFail($id);

        $user->roles()->detach();
        
        if($user && $user->delete()) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'success' => 0,
                'errors' => [
                    'server' => ['something went wrong...try again']
                ]
            ], 500);
        }
    }
    
    /**
     * Return true if we're creating a new user.
     *
     * @param string $id
     * @return bool
     */
    private function isNewUser(string $id): bool
    {
        return $id === 'create';
    }
}
