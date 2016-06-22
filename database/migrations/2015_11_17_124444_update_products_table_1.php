<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductsTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function($table){
            $table->renameColumn('subcategory_id', 'category_id');
            $table->string('meta_title');
            $table->longText('meta_description');
            $table->integer('wholesale_price');
            $table->integer('wholesale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
