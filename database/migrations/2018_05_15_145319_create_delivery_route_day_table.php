<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryRouteDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_route_day', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_route_id');
            $table->tinyinteger('monday');
            $table->tinyinteger('tuesday');
            $table->tinyinteger('wednesday');
            $table->tinyinteger('thursday');
            $table->tinyinteger('friday');
            $table->tinyinteger('saturday');
            $table->tinyinteger('sunday');
            $table->tinyinteger('status')->default(1);

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
        Schema::drop('delivery_route_day');
    }
}
