<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountFieldsToAvCategoties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('av_categories', function (Blueprint $table) {
            $table->integer('total')->nullable()->after('link');
            $table->integer('diff')->nullable()->after('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('av_categories', function (Blueprint $table) {
            $table->dropColumn('total');
            $table->dropColumn('diff');
        });
    }
}
