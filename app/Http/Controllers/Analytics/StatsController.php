<?php

namespace App\Http\Controllers\Analytics;

use App\Models\Blog\Post;
use App\Traits\Trends;
use App\Models\Analytics\View;
use App\Models\Analytics\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class StatsController extends \App\Http\Controllers\Controller
{
  use Trends;

  /**
   * Number of days to compile a stat range.
   *
   * @const int
   */
  private const DAYS_PRIOR = 30;

  /**
   * Get all the stats.
   *
   * @return JsonResponse
   */
  public function index(): JsonResponse
  {
    $model = app(request('className'));
    $published = $model
      ->latest()
      ->get();

    $views = View::select('created_at')
      ->where('viewable_type', get_class(new $model()))
      ->whereIn('viewable_id', $published->pluck('id'))
      ->whereBetween('created_at', [
          today()->subDays(self::DAYS_PRIOR)->startOfDay()->toDateTimeString(),
          today()->endOfDay()->toDateTimeString(),
      ])->get();

    $visits = Visit::select('created_at')
      ->where('visitable_type', get_class(new $model()))
      ->whereIn('visitable_id', $published->pluck('id'))
      ->whereBetween('created_at', [
        today()->subDays(self::DAYS_PRIOR)->startOfDay()->toDateTimeString(),
        today()->endOfDay()->toDateTimeString(),
      ])->get();

    return response()->json([
      'view_count' => $views->count(),
      'view_trend' => json_encode($this->getDataPoints($views, self::DAYS_PRIOR)),
      'visit_count' => $visits->count(),
      'visit_trend' => json_encode($this->getDataPoints($visits, self::DAYS_PRIOR)),
      'published_count' => $published->count(),
    ]);
  }

  /**
   * Get stats for a single post.
   *
   * @param string $className
   * @param string $id
   * @return JsonResponse
   */
  public function show(string $id): JsonResponse
  {
    $model = app(request('className'));
    $model = $model::find($id);

    if ($model) {
      $views = $model->views;
      $previousMonthlyViews = $views->whereBetween('created_at', [
        today()->subMonth()->startOfMonth()->startOfDay()->toDateTimeString(),
        today()->subMonth()->endOfMonth()->endOfDay()->toDateTimeString(),
      ]);
      $currentMonthlyViews = $views->whereBetween('created_at', [
        today()->startOfMonth()->startOfDay()->toDateTimeString(),
        today()->endOfMonth()->endOfDay()->toDateTimeString(),
      ]);
      $lastThirtyDays = $views->whereBetween('created_at', [
        today()->subDays(self::DAYS_PRIOR)->startOfDay()->toDateTimeString(),
        today()->endOfDay()->toDateTimeString(),
      ]);

      $visits = $model->visits;
      $previousMonthlyVisits = $visits->whereBetween('created_at', [
        today()->subMonth()->startOfMonth()->startOfDay()->toDateTimeString(),
        today()->subMonth()->endOfMonth()->endOfDay()->toDateTimeString(),
      ]);
      $currentMonthlyVisits = $visits->whereBetween('created_at', [
        today()->startOfMonth()->startOfDay()->toDateTimeString(),
        today()->endOfMonth()->endOfDay()->toDateTimeString(),
      ]);

      return response()->json([
        'model' => $model,
        'read_time' => $model->read_time ?? NULL,
        'popular_reading_times' => $model->popular_reading_times ?? NULL,
        'traffic' => $model->top_referers ?? NULL,
        'view_count' => $currentMonthlyViews->count(),
        'view_trend' => json_encode($this->getDataPoints($lastThirtyDays, self::DAYS_PRIOR)),
        'view_month_over_month' => $this->compareMonthToMonth($currentMonthlyViews, $previousMonthlyViews),
        'view_count_lifetime' => $views->count(),
        'visit_count' => $currentMonthlyVisits->count(),
        'visit_trend' => json_encode($this->getDataPoints($visits, self::DAYS_PRIOR)),
        'visit_month_over_month' => $this->compareMonthToMonth($currentMonthlyVisits, $previousMonthlyVisits),
      ]);
    } else {
      return response()->json(null, 301);
    }
  }
}
