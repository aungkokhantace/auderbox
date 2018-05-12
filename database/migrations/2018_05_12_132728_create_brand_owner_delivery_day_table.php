<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandOwnerDeliveryDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_owner_delivery_day', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_owner_id');
            $table->tinyInteger('monday');
            $table->tinyInteger('tuesday');
            $table->tinyInteger('wednesday');
            $table->tinyInteger('thursday');
            $table->tinyInteger('friday');
            $table->tinyInteger('saturday');
            $table->tinyInteger('sunday');

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
        Schema::drop('brand_owner_delivery_day');
    }
}
