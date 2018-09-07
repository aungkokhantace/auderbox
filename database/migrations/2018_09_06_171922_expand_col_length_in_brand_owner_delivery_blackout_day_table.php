<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpandColLengthInBrandOwnerDeliveryBlackoutDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_owner_delivery_blackout_day', function (Blueprint $table) {
            $table->string('name',255)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_owner_delivery_blackout_day', function (Blueprint $table) {
            //
        });
    }
}
