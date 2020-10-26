<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTopicsAddUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->string('user_id')->after('name')->default(false)->index();
            $table->dropUnique('topics_slug_unique');
            $table->unique(['slug', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropUnique('topics_slug_user_id_unique');
            $table->unique('slug');
            $table->dropColumn('user_id');
        });
    }
}
