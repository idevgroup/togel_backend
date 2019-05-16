<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('category');
            $table->char('product_slug',100);
            $table->char('meta_key',200);
            $table->char('meta_desc',250);
            $table->char('product_image',255);
            $table->char('product_name',50);
            $table->char('product_title',50)->nullable();
            $table->char('product_alt',50)->nullable();
            $table->char('product_link',255);
            $table->integer('product_order')->unsigned();
            $table->text('product_description')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
            $table->integer('status')->unsigned();
            $table->timestamp('trashed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
