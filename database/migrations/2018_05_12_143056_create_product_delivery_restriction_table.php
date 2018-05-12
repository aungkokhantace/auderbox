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
            $table->integer('product_group_id');
            $table->integer('address_state_id');
            $table->integer('address_district_id');
            $table->integer('address_township_id');
            $table->integer('address_town_id');
            $table->integer('address_ward_id');
            $table->tinyInteger('status');

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
        Schema::drop('product_delivery_restriction');
    }
}
