<?php

namespace App\Http\Controllers\Blog;

use App\Model\Blog\Post;
use App\Model\Blog\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogTopicController extends Controller
{
    /**
     * Get all the topics.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return Topic::select(['name', 'slug'])
                    ->whereHas('posts')
                    ->withCount('posts')
                    ->orderByDesc('posts_count')
                    ->take(15)
                    ->get();
    }

    /**
     * Show a given topic.
     *
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $slug)
    {
        $topic = Topic::select('name', 'slug')->where('slug', $slug)->first();

        if ($topic) {
            $posts = Post::whereHas('topic', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->published()->withUserMeta()->orderByDesc('published_at')->get();

            $posts->each->append('read_time');

            return response()->json([
                'topic' => $topic,
                'posts' => $posts,
            ]);
        } else {
            return response()->json(null, 404);
        }
    }
}
