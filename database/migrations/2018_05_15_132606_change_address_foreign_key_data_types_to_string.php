<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAddressForeignKeyDataTypesToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('brand_owners', function (Blueprint $table) {
          $table->string('address_state_id')->change();
          $table->string('address_district_id')->change();
          $table->string('address_township_id')->change();
          $table->string('address_town_id')->change();
          $table->string('address_ward_id')->change();
      });

      Schema::table('product_delivery_restriction', function (Blueprint $table) {
          $table->string('address_state_id')->change();
          $table->string('address_district_id')->change();
          $table->string('address_township_id')->change();
          $table->string('address_town_id')->change();
          $table->string('address_ward_id')->change();
      });

      Schema::table('product_price', function (Blueprint $table) {
          $table->string('address_state_id')->change();
          $table->string('address_district_id')->change();
          $table->string('address_township_id')->change();
          $table->string('address_town_id')->change();
          $table->string('address_ward_id')->change();
      });

      Schema::table('retailers', function (Blueprint $table) {
          $table->string('address_state_id')->change();
          $table->string('address_district_id')->change();
          $table->string('address_township_id')->change();
          $table->string('address_town_id')->change();
          $table->string('address_ward_id')->change();
      });

      Schema::table('retailshops', function (Blueprint $table) {
          $table->string('address_state_id')->change();
          $table->string('address_district_id')->change();
          $table->string('address_township_id')->change();
          $table->string('address_town_id')->change();
          $table->string('address_ward_id')->change();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
