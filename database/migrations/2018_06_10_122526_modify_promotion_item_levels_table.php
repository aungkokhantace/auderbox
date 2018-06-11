<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPromotionItemLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_item_levels', function (Blueprint $table) {
          $table->renameColumn('from_amount', 'purchase_amt');
          $table->renameColumn('from_qty', 'purchase_qty');
          $table->dropColumn('to_amount');
          $table->dropColumn('to_qty');
        });

        Schema::table('promotion_item_levels_log', function (Blueprint $table) {
          $table->renameColumn('from_amount', 'purchase_amt');
          $table->renameColumn('from_qty', 'purchase_qty');
          $table->dropColumn('to_amount');
          $table->dropColumn('to_qty');
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
