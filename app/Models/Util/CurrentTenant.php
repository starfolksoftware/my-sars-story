<?php

namespace App\Models\Util;

use RuntimeException;
use App\Models\Auth\UserMeta;
use App\Models\Settings\Platform;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Auth;
use Locale;

class CurrentTenant
{
  private $platform;

  public function __construct() {
    $this->setPlatform(Platform::findOrFail(1));
  }

  private function setPlatform($platform) {
    $this->platform = $platform;
  }

  public function getPlatform() {
    return $this->platform;
  }

  /**
   * Build a global JavaScript object for the Vue app.
   *
   * @return array
   */
  public function getState()
  {
    $metaData = UserMeta::forCurrentUser()->first();
    $emailHash = Auth::check() ? md5(trim(Str::lower(request()->user()->email))) : '';

    // dd(auth()->user());

    return [
      'platform' => $this->platform,
      'allPlatforms' => \App\Models\Settings\Platform::all(),
      'avatar' => optional($metaData)->avatar && ! empty(optional($metaData)->avatar) ? $metaData->avatar : "https://secure.gravatar.com/avatar/{$emailHash}?s=500",
      'darkMode' => optional($metaData)->dark_mode,
      'languageCodes' => self::getAvailableLanguageCodes(),
      'locale' => optional($metaData)->locale ?? config('app.locale'),
      'maxUpload' => config('custom.upload_filesize'),
      'identifier' => 'id',
      'path' => config('custom.path'),
      'timezone' => config('app.timezone'),
      'translations' => collect(['app' => trans('app', [], optional($metaData)->locale)])->toJson(),
      'unsplash' => config('custom.unsplash.access_key'),
      'user' => Auth::check() ? new UserResource(auth()->user()) : '',
      'isUserVerified' => Auth::check() ? auth()->user()->hasVerifiedEmail() : NULL,
      'roles' => \App\Models\Auth\Role::all()->pluck('name'),
      'permissions' => \App\Models\Auth\Permission::all()->pluck('name'),
      'partners' => \App\Models\Partners\Partner::all(),
      'trackers' => \App\Models\Tracker\Tracker::all(),
    ];
  }

  /**
   * Compiles the language file and rebuilds it into into a single
   * consumable JSON object that can be used in the Vue components.
   *
   * @param string
   * @return string
   */
  private static function compileLanguageFile(string $locale): string
  {
    $langDirectory = dirname(__DIR__, 1).'/resources/lang';
    $file = "{$langDirectory}/{$locale}/app.php";
    $lines = collect();
    $lines->put('app', include $file);

    return $lines->toJson();
  }

  /**
   * Return the available locales.
   *
   * @return array
   */
  private static function getAvailableLanguageCodes()
  {
    $locales = preg_grep('/^([^.])/', scandir(dirname(__DIR__, 3).'/resources/lang'));
    $translations = collect();

    foreach ($locales as $locale) {
      $translations->put($locale, Str::ucfirst(Locale::getDisplayName($locale, $locale)));
    }

    return $translations->toArray();
  }
}
