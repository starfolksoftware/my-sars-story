<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermsAndPrivacyPoliciesToPlatformTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('platforms', function (Blueprint $table) {
      $table->text('terms')->nullable()->after('phone_number');
      $table->text('privacy_policy')->nullable()->after('terms');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('platforms', function (Blueprint $table) {
      $table->dropColumn('terms');
      $table->dropColumn('privacy_policy');
    });
  }
}
