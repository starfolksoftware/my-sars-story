<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name')->nullable();
      $table->text('description')->nullable();
      $table->json('marketing')->nullable();
      $table->json('features')->nullable();
      $table->string('logo')->nullable();
      $table->string('external_link')->nullable();
      $table->timestamp('submitted_at')->nullable();
      $table->timestamp('approved_at')->nullable();
      $table->unsignedBigInteger('approved_by')->nullable();
      $table->timestamp('published_at')->nullable();
      $table->unsignedInteger('user_id');
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
    Schema::dropIfExists('products');
  }
}
