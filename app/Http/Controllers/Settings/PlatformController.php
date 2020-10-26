<?php

namespace App\Http\Controllers\Settings;

use App\Model\Settings\Platform;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;

class PlatformController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request) {
        if (!Auth::user()->hasAnyPermission(['view_platforms'])) {
            return response()->json([
                'success' => 0,
                'errors' => [
                    'server' => ['you dont have permission']
                ]
            ], 500);
        };

        if ($request->has('query')) {
            $query = $request->input('query');
            $platforms = Platform::whereRaw("MATCH(name, slug)
            AGAINST('$query' IN NATURAL LANGUAGE MODE)")->withCount('posts')->paginate();
        } else {
            $platforms = Platform::latest()->withCount('posts')->paginate();
        }

        return response()->json($platforms);
	}
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store ($id): JsonResponse {
      $data = [
        'name' => request('name'),
        'display_name' => request('display_name'),
        'description' => request('description'),
        'tag_line' => request('tag_line'),
        'physical_address' => request('physical_address'),
        'email' => request('email'),
        'phone_number' => request('phone_number'),
        'terms' => request('terms'),
        'privacy_policy' => request('privacy_policy'),
        'twitter_url' => request('twitter_url'),
        'facebook_url' => request('facebook_url'),
        'instagram_url' => request('instagram_url'),
        'linkedin_url' => request('linkedin_url')
      ];

      validator($data, [
        'name' => 'required',
      ])->validate();

      if ($this->isNewPlatform($id)) {
        if ($platform = Platform::onlyTrashed()->where('slug', $data['slug'])->first()) {
          $platform->restore();
        } else {
          $platform = new Platform();
        }
      } else {
        $platform = Platform::findOrFail($id);
      }
  
      $platform->fill($data);
  
      if($platform->save()) {
        return response()->json($platform->refresh(), 201);
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
     * @param  \App\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function show ($id = null) {
        if (Platform::all()->pluck('id')->contains($id) || $this->isNewPlatform($id)) {
            if ($this->isNewPlatform($id)) {
                $id = DB::select("SHOW TABLE STATUS LIKE 'platforms'");
                return response()->json([
                    'id' => $id[0]->Auto_increment,
                ], 200);
            } else {
                $platform = Platform::find($id);

                if ($platform) {
                    return response()->json($platform, 200);
                } else {
                    return response()->json(null, 301);
                }
            }
        }
	}
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $platform = Platform::findOrFail($id);
        
        if($platform && $platform->delete()) {
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
     * Return true if we're creating a new platform.
     *
     * @param string $id
     * @return bool
     */
    private function isNewPlatform(string $id): bool
    {
        return $id === 'create';
    }
}
