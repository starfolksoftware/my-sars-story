<?php

namespace App\Http\Controllers\Blog;

use App\Models\Auth\User;
use App\Models\Blog\Post;
use App\Models\Auth\UserMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class BlogUserController extends Controller
{
    /**
     * The user associated with a post.
     *
     * @var User
     */
    protected $user;

    /**
     * The metadata associated with a user.
     *
     * @var UserMeta
     */
    protected $userMeta;

    /**
     * Show a given user.
     *
     * @param Request $request
     * @param string $identifier
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $identifier)
    {
      $this->user = User::where('id', $identifier)->first();

      if ($this->user) {
        $this->userMeta = UserMeta::where('user_id', $this->user->id)->first();
      }

      $posts = Post::where('user_id', $this->user->id)
        ->published()
        ->withUserMeta()
        ->orderByDesc('published_at')
        ->get();

      $posts->each->append('read_time');

      $emailHash = Auth::check() ? md5(trim(Str::lower(request()->user()->email))) : '';

      $avatar = !empty($this->userMeta->avatar) ? $this->userMeta->avatar : "https://secure.gravatar.com/avatar/{$emailHash}?s=500";

      return response()->json([
          'user' => $this->user,
          'avatar' => $avatar,
          'summary' => optional($this->userMeta)->summary,
          'posts' => $posts,
      ]);
    }
}
