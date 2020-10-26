<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataresourcesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dataresources', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('title');
      $table->string('description');
      $table->string('path');
      $table->unsignedBigInteger('dataformat_id');
      $table->unsignedBigInteger('dataset_id');
      $table->boolean('downloadable')->nullable();
      $table->string('user_id');
      $table->softDeletes();
      $table->timestamps();

      $table->engine = 'InnoDB';
    });

    DB::statement(
      'ALTER TABLE dataresources ADD FULLTEXT search(
        title, 
        description
      )'
    );
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('dataresources');
  }
}
