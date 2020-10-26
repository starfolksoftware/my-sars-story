<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeaturedImageToTrackerItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tracker_items', function (Blueprint $table) {
      $table->string('featured_image')->nullable()->after('confirmed');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('tracker_items', function (Blueprint $table) {
      $table->dropColumn('featured_image');
    });
  }
}
