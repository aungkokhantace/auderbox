<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPromotionItemLevelsTableTypeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_item_levels', function (Blueprint $table) {
          $table->renameColumn('promo_type', 'promo_purchase_type');
          $table->integer('promo_present_type')->after('promo_type');
        });

        Schema::table('promotion_item_levels_log', function (Blueprint $table) {
          $table->renameColumn('promo_type', 'promo_purchase_type');
          $table->integer('promo_present_type')->after('promo_type');
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
          $table->dropColumn('promo_present_type');
        });

        Schema::table('promotion_item_levels_log', function (Blueprint $table) {
          $table->dropColumn('promo_present_type');
        });
    }
}
