<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliverTodayToDeliveryRouteDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_route_day', function (Blueprint $table) {
            $table->tinyInteger('deliver_today')->default(0)->after('sunday');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_route_day', function (Blueprint $table) {
            $table->dropColumn('deliver_today');
        });
    }
}
