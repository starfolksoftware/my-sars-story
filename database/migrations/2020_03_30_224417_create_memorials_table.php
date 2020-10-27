<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemorialsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('memorials', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->string('profession');
      $table->integer('age');
      $table->uuid('post_id');
      $table->string('avatar')->nullable();
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
    Schema::dropIfExists('memorials');
  }
}
