<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Blog\Post;
use Illuminate\Http\Request;

use App\Models\Util\CurrentTenant;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return the SPA with global variables.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request, $identifier = NULL, $slug = NULL)
    {
      $path = url()->current();
      $pathArray = \explode('/', $path);
      $determinant = $pathArray[count($pathArray) - 1];

      $meta = array(
        'title' => env('APP_NAME', '#MySarsStory').'Now is the time to demand bold, radical, systemic changes for Nigeria\'s betterment, and our own good.',
        'summary' => 'Now is the time to demand bold, radical, systemic changes for Nigeria\'s betterment, and our own good.',
        'summaryFromBody' => 'Now is the time to demand bold, radical, systemic changes for Nigeria\'s betterment, and our own good.',
        'image' => env('APP_URL').'/images/protests/protest_9.jpg',
        'url' => url()->current()
      );

      if ($determinant == 'contact') {
        $meta = array(
          'title' => 'Contact - '.env('APP_NAME', '#MySarsStory'),
          'summary' => 'Fill up the form and get a response within 24 hour!',
          'summaryFromBody' => 'Fill up the form and get a response within 24 hour!',
          'image' => env('APP_URL').'/images/protests/protest_9.jpg',
          'url' => url()->current()
        );
      } else if ($determinant == 'resources') {
        $meta = array(
          'title' => 'Resources - '.env('APP_NAME', '#MySarsStory'),
          'summary' => 'Knowledge is power. Educate yourself about the movement. Download and share.',
          'summaryFromBody' => 'Knowledge is power. Educate yourself about the movement. Download and share.',
          'image' => env('APP_URL').'/images/protests/protest_9.jpg',
          'url' => url()->current()
        );
      } else if ($determinant == 'blog') {
        $meta = array(
          'title' => 'Blog - '.env('APP_NAME', '#MySarsStory'),
          'summary' => 'Get the latest news and developments around the movement',
          'summaryFromBody' => 'Get the latest news and developments around the movement',
          'image' => env('APP_URL').'/images/protests/protest_9.jpg',
          'url' => url()->current()
        );
      } else if ($determinant == 'memorial') {
        $meta = array(
          'title' => 'Memorial - '.env('APP_NAME', '#MySarsStory'),
          'summary' => 'Those We\'ve Lost. The #EndSARS protest has taken a death toll. We are putting names and faces to the numbers.',
          'summaryFromBody' => 'Those We\'ve Lost. The #EndSARS protest has taken a death toll. We are putting names and faces to the numbers.',
          'image' => env('APP_URL').'/images/protests/protest_9.jpg',
          'url' => url()->current()
        );
      }

      if ($slug) {
        $post = Post::where('slug', $slug)->with('user')->first();
        $meta['title'] = $post->title ?? '';
        $meta['summary'] = $post->summary ?? '';
        $body = $post->body ?? '';
        $meta['summaryFromBody'] = substr(strip_tags($body), 200);
        $meta['image'] = $post->featured_image ?? '';
        $meta['author'] = $post->user->name ?? '';
        $meta['url'] = url()->current();
      }

      $currentTenant = new CurrentTenant();
      
      return view('layout', [
        'currentTenant' => $currentTenant->getState(),
        'meta' => $meta
      ]);
    }
}
