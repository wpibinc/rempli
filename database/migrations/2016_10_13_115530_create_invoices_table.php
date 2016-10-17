<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('subscription_id')->nullable();
            $table->string('title');
            $table->decimal('price',10,2);
            $table->boolean('is_paid')->default(0);
            $table->dateTime('last_pay_day')->nullable();
            $table->integer('extra_deliveries')->nullable();
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
        Schema::drop('invoices');
    }
}
