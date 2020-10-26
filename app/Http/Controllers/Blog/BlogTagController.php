<?php

namespace App\Http\Controllers\Blog;

use App\Model\Blog\Post;
use App\Model\Blog\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogTagController extends Controller
{
    /**
     * Get all the tags.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return Tag::select(['name', 'slug'])
                   ->whereHas('posts')
                   ->withCount('posts')
                   ->orderByDesc('posts_count')
                   ->take(15)
                   ->get();
    }

    /**
     * Show a given tag.
     *
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $slug)
    {
        $tag = Tag::select('name', 'slug')->where('slug', $slug)->first();

        if ($tag) {
            $posts = Post::whereHas('tags', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->published()->withUserMeta()->orderByDesc('published_at')->get();

            $posts->each->append('read_time');

            return response()->json([
                'tag' => $tag,
                'posts' => $posts,
            ]);
        } else {
            return response()->json(null, 404);
        }
    }
}
