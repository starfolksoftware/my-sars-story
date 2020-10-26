<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVirtualMetaToTrackerItems extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('tracker_items', function (Blueprint $table) {
      $table->longText('meta_virtual')->storedAs('meta');
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
      $table->dropColumn('meta_virtual');
    });
  }
}
