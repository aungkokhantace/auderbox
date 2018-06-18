<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductLineIdToProductGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_group', function (Blueprint $table) {
            $table->integer('product_line_id')->after('brand_owner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_group', function (Blueprint $table) {
            $table->dropColumn('product_line_id');
        });
    }
}
