<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatasetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('datasets', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('title')->nullable();
        $table->text('description')->nullable();
        $table->unsignedInteger('datalicense_id')->nullable();
        $table->timestamp('submitted_at')->nullable();
        $table->timestamp('approved_at')->nullable();
        $table->unsignedBigInteger('approved_by')->nullable();
        $table->timestamp('published_at')->nullable();
        $table->unsignedInteger('user_id');
        $table->json('meta')->nullable();
        $table->softDeletes();
        $table->timestamps();

        $table->engine = 'InnoDB';
      });

      DB::statement(
        'ALTER TABLE datasets ADD FULLTEXT search(
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
      Schema::dropIfExists('datasets');
    }
}
