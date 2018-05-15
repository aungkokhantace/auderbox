<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryRouteDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_route_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_route_id');
            $table->integer('retailshop_id');
            $table->text('remark')->nullable();
            $table->tinyinteger('status')->default(1);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('delivery_route_detail');
    }
}
