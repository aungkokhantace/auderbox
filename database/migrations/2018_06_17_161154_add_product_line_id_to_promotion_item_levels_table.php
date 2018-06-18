<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductLineIdToPromotionItemLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_item_levels', function (Blueprint $table) {
            $table->integer('product_line_id')->after('promotion_item_level_group_id');
            $table->string('promotion_image')->nullable()->after('name');
        });

        Schema::table('promotion_item_levels_log', function (Blueprint $table) {
            $table->integer('product_line_id')->after('promotion_item_level_id');
            $table->string('promotion_image')->nullable()->after('name');
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
            $table->dropColumn('product_line_id');
            $table->dropColumn('promotion_image');
        });

        Schema::table('promotion_item_levels_log', function (Blueprint $table) {
            $table->dropColumn('product_line_id');
            $table->dropColumn('promotion_image');
        });
    }
}
