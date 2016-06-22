<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateOrdersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('product_name');
            $table->integer('product_price');
            $table->integer('product_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders_products');
    }
}
