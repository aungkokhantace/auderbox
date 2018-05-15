<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryIdToTablesWithAddressForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('brand_owners', function (Blueprint $table) {
          $table->integer('country_id')->after('contact_email');
      });

      Schema::table('product_delivery_restriction', function (Blueprint $table) {
          $table->integer('country_id')->after('product_group_id');
      });

      Schema::table('product_price', function (Blueprint $table) {
          $table->integer('country_id')->after('product_id');
      });

      Schema::table('retailers', function (Blueprint $table) {
          $table->integer('country_id')->after('nrc_back_photo');
      });

      Schema::table('retailshops', function (Blueprint $table) {
          $table->integer('country_id')->after('retailer_id');
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
          $table->dropColumn('country_id');
      });

      Schema::table('product_delivery_restriction', function (Blueprint $table) {
          $table->dropColumn('country_id');
      });

      Schema::table('product_price', function (Blueprint $table) {
          $table->dropColumn('country_id');
      });

      Schema::table('retailers', function (Blueprint $table) {
          $table->dropColumn('country_id');
      });

      Schema::table('retailshops', function (Blueprint $table) {
          $table->dropColumn('country_id');
      });
    }
}
