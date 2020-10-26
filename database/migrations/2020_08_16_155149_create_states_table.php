<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('states', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->decimal('latitude', 10, 6);
      $table->decimal('longitude', 10, 6);
      $table->char('code', 2)->nullable();
      $table->softDeletes();
      $table->timestamps();

      $table->engine = 'InnoDB';
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('states');
  }
}
