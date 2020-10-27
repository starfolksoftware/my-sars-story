<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Model\Blog\Post;
use Illuminate\Http\Request;

use App\Model\Util\CurrentTenant;

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
        'title' => 'Starfolk Software Tech. Ltd. - A Software Company',
        'summary' => 'We dont gather requirements; We dig for them. We build products around customer experience. We like to work with users at every stage of development. We believe it is the best way to gain insight into how the system will really be used.',
        'summaryFromBody' => 'We dont gather requirements; We dig for them. We build products around customer experience. We like to work with users at every stage of development. We believe it is the best way to gain insight into how the system will really be used.',
        'image' => '/images/feel_the_quality.jpg',
        'url' => url()->current()
      );

      if ($determinant == 'contact') {
        $meta = array(
          'title' => 'Contact - Starfolk Software Tech. Ltd.',
          'summary' => 'We\'d love to discuss your ideas and problems. Let\'s build the future together!',
          'summaryFromBody' => 'We\'d love to discuss your ideas and problems. Let\'s build the future together!',
          'image' => '/images/feel_the_quality.jpg',
          'url' => url()->current()
        );
      } else if ($determinant == 'portfolio') {
        $meta = array(
          'title' => 'Portfolio - Starfolk Software Tech. Ltd.',
          'summary' => 'We understand you just don\'t want a product that works. You want a solution that reminds you of the beauty of life. Design is at the heart of everything we do! We setup workshops to make sure we capture the brand of our clients\' businesses.',
          'summaryFromBody' => 'We understand you just don\'t want a product that works. You want a solution that reminds you of the beauty of life. Design is at the heart of everything we do! We setup workshops to make sure we capture the brand of our clients\' businesses.',
          'image' => '/images/feel_the_quality.jpg',
          'url' => url()->current()
        );
      } else if ($determinant == 'blog') {
        $meta = array(
          'title' => 'Blog - Starfolk Software Tech. Ltd.',
          'summary' => 'How we work. What we\'ve learnt. What we are doing different',
          'summaryFromBody' => 'How we work. What we\'ve learnt. What we are doing different',
          'image' => '/images/feel_the_quality.jpg',
          'url' => url()->current()
        );
      } else if ($determinant == 'services') {
        $meta = array(
          'title' => 'Services - Starfolk Software Tech. Ltd.',
          'summary' => 'We dont gather requirements; We dig for them. We build products around customer experience. We like to work with users at every stage of development. We believe it is the best way to gain insight into how the system will really be used.',
          'summaryFromBody' => 'We dont gather requirements; We dig for them. We build products around customer experience. We like to work with users at every stage of development. We believe it is the best way to gain insight into how the system will really be used.',
          'image' => '/images/feel_the_quality.jpg',
          'url' => url()->current()
        );
      } else if ($determinant == 'team') {
        $meta = array(
          'title' => 'Team - Starfolk Software Tech. Ltd.',
          'summary' => 'We believe that to produce a great product, we have to start from the customer experience. To be the company that accomplishes just that, it takes an eclectic group experienced, driven and passionate about it. Get to know the people at Starfolk!',
          'summaryFromBody' => 'We believe that to produce a great product, we have to start from the customer experience. To be the company that accomplishes just that, it takes an eclectic group experienced, driven and passionate about it. Get to know the people at Starfolk!',
          'image' => '/images/feel_the_quality.jpg',
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
