<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkuPrefixToBrandOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_owners', function (Blueprint $table) {
          $table->string('sku_prefix')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_owners', function (Blueprint $table) {
          $table->dropColumn('sku_prefix');
        });
    }
}
