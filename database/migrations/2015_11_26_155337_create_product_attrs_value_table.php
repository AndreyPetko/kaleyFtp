<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttrsValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attrs_value', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('attribute_id');
            $table->LongText('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_attrs_value');
    }
}
