<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatadownloadsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('datadownloads', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->uuid('dataresource_id');
      $table->string('ip')->nullable();
      $table->string('agent')->nullable();
      $table->string('referer')->nullable();
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
    Schema::dropIfExists('datadownloads');
  }
}
