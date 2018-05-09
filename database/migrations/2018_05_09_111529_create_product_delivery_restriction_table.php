<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDeliveryRestrictionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_delivery_restriction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('state_id');
            $table->integer('township_id');
            $table->tinyInteger('status')->default(1);

            //Common to all tables ----------------------------------------------
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
        Schema::drop('product_delivery_restriction');
    }
}
