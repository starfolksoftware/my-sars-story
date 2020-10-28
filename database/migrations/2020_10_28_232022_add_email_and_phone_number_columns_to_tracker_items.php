<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailAndPhoneNumberColumnsToTrackerItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracker_items', function (Blueprint $table) {
            $table->string('email')->after('confirmed')->nullable();
            $table->string('phone_number')->after('email')->nullable();
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
            $table->dropColumn('email');
            $table->dropColumn('phone_number');
        });
    }
}
