<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLongPromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('long_promocodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_id')->nullable();
            $table->integer('used_per_month')->nullable();
            $table->dateTime('end_subscription')->nullable();
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
        Schema::drop('long_promocodes');
    }
}
