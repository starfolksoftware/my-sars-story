<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('posts', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('slug')->unique();
      $table->string('title');
      $table->text('summary')->nullable();
      $table->text('body')->nullable();
      $table->timestamp('submitted_at')->nullable();
      $table->timestamp('approved_at')->nullable();
      $table->unsignedBigInteger('editor_id')->nullable();
      $table->dateTime('published_at')->default('2018-10-12 00:00:00');
      $table->string('featured_image')->nullable();
      $table->string('featured_image_caption')->nullable();
      $table->unsignedBigInteger('user_id')->index();
      $table->json('meta')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('tags', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('slug')->unique();
      $table->string('name');
      $table->timestamps();
      $table->softDeletes();
      $table->index('created_at');
    });

    Schema::create('posts_tags', function (Blueprint $table) {
      $table->uuid('post_id');
      $table->uuid('tag_id');
      $table->unique(['post_id', 'tag_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('posts');
    Schema::dropIfExists('tags');
    Schema::dropIfExists('posts_tags');
    Schema::dropIfExists('views');
  }
}
