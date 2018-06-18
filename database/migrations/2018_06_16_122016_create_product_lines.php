<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_lines', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('brand_owner_id');
          $table->string('name',45);
          $table->string('image');
          $table->text('description')->nullable();
          $table->text('remark')->nullable();
          $table->tinyInteger('status')->default(1);

          //common to all tables...
          $table->integer('created_by')->default(1);
          $table->integer('updated_by')->default(1);
          $table->integer('deleted_by')->nullable();
          $table->timestamps();
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_lines');
    }
}
