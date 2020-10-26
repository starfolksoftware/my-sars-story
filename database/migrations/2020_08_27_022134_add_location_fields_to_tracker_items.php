<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationFieldsToTrackerItems extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tracker_items', function (Blueprint $table) {
      $table->unsignedBigInteger('state_id')->after('user_id');
      $table->unsignedBigInteger('local_government_id')->after('state_id');
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
      $table->dropColumn('state_id');
      $table->dropColumn('local_government_id');
    });
  }
}
