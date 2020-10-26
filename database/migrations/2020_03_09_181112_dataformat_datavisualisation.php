<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataformatDatavisualisation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('dataformat_datavisualisation', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('dataformat_id');
        $table->unsignedBigInteger('datavisualisation_id');
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
        //
    }
}
