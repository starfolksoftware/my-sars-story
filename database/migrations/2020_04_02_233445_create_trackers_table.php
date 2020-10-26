<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('trackers', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name')->unique();
      $table->json('fields');
      $table->boolean('has_location');
      $table->boolean('has_user_reporting');
      $table->boolean('has_bot');
      $table->string('bot_name')->nullable();
      $table->unsignedBigInteger('user_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('trackers');
  }
}
