<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductContainerTypeIdToProductGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_group', function (Blueprint $table) {
            $table->integer('product_container_type_id')->after('product_volume_type_id');
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
            $table->dropColumn('product_container_type_id');
        });
    }
}
