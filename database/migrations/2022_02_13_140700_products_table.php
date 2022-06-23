<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('products',function (Blueprint $table){
           $table->id();
           $table->string('name');
           $table->unsignedBigInteger('categoryId');
           $table->string('imageSrc');
           $table->text('description');
           $table->unsignedDouble('price');
           $table->foreign('categoryId')->references('id')->on('categories');
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
    }
}
