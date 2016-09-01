<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParseFieldToAvCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('av_categories', function (Blueprint $table) {
            $table->boolean('parse')->default(true)->after('diff');

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
            $table->dropColumn('parse');
        });
    }
}
