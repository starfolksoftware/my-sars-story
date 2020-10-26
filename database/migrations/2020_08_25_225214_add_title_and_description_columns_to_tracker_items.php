<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleAndDescriptionColumnsToTrackerItems extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tracker_items', function (Blueprint $table) {
      $table->string('title')->after('tracker_id');
      $table->text('description')->after('title');
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
      $table->dropColumn('title');
      $table->dropColumn('description');
    });
  }
}
