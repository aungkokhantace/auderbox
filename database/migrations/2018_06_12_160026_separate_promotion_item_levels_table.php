<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeparatePromotionItemLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_item_levels', function (Blueprint $table) {
            $table->dropColumn('promo_product_id');
            $table->dropColumn('promo_qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_item_levels', function (Blueprint $table) {
            //
        });
    }
}
