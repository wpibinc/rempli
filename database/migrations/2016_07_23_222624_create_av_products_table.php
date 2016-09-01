<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_products', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('av_category_id');
            $table->integer('category_id');
            $table->string('name');
            $table->string('link');
            $table->string('image');
            $table->decimal('price',10,2);
            $table->decimal('original_price',10,2);
            $table->string('price_style');
            $table->string('original_price_style');
            $table->integer('original_typical_weight');
            $table->boolean('available_to_order');
            $table->string('brand');
            $table->string('ctitles');
            $table->string('cvalues');
            $table->text('description');
            $table->timestamps();


           // $table->primary('id');
          //  $table->unique('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('av_products');
    }
}
