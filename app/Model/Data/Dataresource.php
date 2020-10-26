<?php

namespace App\Model\Data;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use StarfolkSoftware\Analytics\Traits\{HasViews, HasVisits};
use Illuminate\Support\Str;

class Dataresource extends Model
{
  use SoftDeletes, HasViews, HasVisits;

  protected $guarded = [];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  protected $appends = ['read_time'];

  public function dataset(): BelongsTo {
    return $this->belongsTo(\App\Model\Data\Dataset::class, 'dataset_id');
  }

  public function user(): BelongsTo {
    return $this->belongsTo(\App\Model\Auth\User::class);
  }

  public function format(): BelongsTo {
    return $this->belongsTo(\App\Model\Data\Dataformat::class, 'dataformat_id');
  }

  /**
   * Get the human-friendly estimated reading time of a post.
   *
   * @return string
   */
  public function getReadTimeAttribute(): string
  {
    // Only count words in our estimation
    $words = str_word_count(strip_tags($this->description));

    // Divide by the average number of words per minute
    $minutes = ceil($words / 250);

    return sprintf('%d %s %s', $minutes, Str::plural(__('app.min'), $minutes), __('app.read'));
  }

  /**
   * Get the 10 most popular reading times rounded to the nearest 30 minutes.
   *
   * @return array
   */
  public function getPopularReadingTimesAttribute(): array
  {
    // Get the views associated with the post
    $data = $this->views;

    // Filter the view data to only include hours:minutes
    $collection = collect();
    $data->each(function ($item, $key) use ($collection) {
        $collection->push($item->created_at->minute(0)->format('H:i'));
    });

    // Count the unique values and assign to their respective keys
    $filtered = array_count_values($collection->toArray());

    $popular_reading_times = collect();
    foreach ($filtered as $key => $value) {
        // Use each given time to create a 60 min range
        $start_time = Carbon::createFromTimeString($key);
        $end_time = $start_time->copy()->addMinutes(60);

        // Find the percentage based on the value
        $percentage = number_format($value / $data->count() * 100, 2);

        // Get a human-readable hour range and floating percentage
        $popular_reading_times->put(
            sprintf('%s - %s', $start_time->format('g:i A'), $end_time->format('g:i A')),
            $percentage
        );
    }

    // Cast the collection to an array
    $array = $popular_reading_times->toArray();

    // Only return the top 5 reading times and percentages
    $sliced = array_slice($array, 0, 5, true);

    // Sort the array in a descending order
    arsort($sliced);

    return $sliced;
  }

  /**
   * Get the top referring websites for a post.
   *
   * @return array
   */
  public function getTopReferersAttribute(): array
  {
    // Get the views associated with the post
    $data = $this->views;

    // Filter the view data to only include referrers
    $collection = collect();
    $data->each(function ($item, $key) use ($collection) {
        if (empty(parse_url($item->referer)['host'])) {
            $collection->push(__('app.other'));
        } else {
            $collection->push(parse_url($item->referer)['host']);
        }
    });

    // Count the unique values and assign to their respective keys
    $array = array_count_values($collection->toArray());

    // Only return the top N referrers with their view count
    $sliced = array_slice($array, 0, 10, true);

    // Sort the array in a descending order
    arsort($sliced);

    return $sliced;
  }

  public function topics(): BelongsToMany {
    return $this->belongsToMany(Datatopic::class);
  }

  public function resources(): HasMany {
    return $this->hasMany(Dataresource::class);
  }

  public function license(): BelongsTo {
    return $this->belongsTo(Datalicense::class, 'datalicense_id');
  }
}
