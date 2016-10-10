<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('current_quantity')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->integer('price')->nullable();
            $table->string('promocode')->nullable();
            $table->string('duration')->nullable();
            $table->dateTime('start_promocode')->nullable();
            $table->dateTime('end_promocode')->nullable();
            $table->tinyInteger('auto_subscription')->nullable()->default(0);
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
        Schema::drop('subscriptions');
    }
}
