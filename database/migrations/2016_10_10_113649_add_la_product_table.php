<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLaProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('articul');
            $table->string('name');
            $table->string('link');
            $table->integer('la_category_id');
            $table->decimal('original_price', 10, 2);
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->string('price_style');
            $table->text('description')->nullable();
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
        Schema::drop('la_products');
    }
}
