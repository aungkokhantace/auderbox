<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_session', function (Blueprint $table) {
          $table->string('id');
          $table->integer('retailer_id');
          $table->integer('retailshop_id');
          $table->integer('brand_owner_id');
          $table->integer('product_id');
          $table->integer('quantity');
          $table->dateTime('created_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoice_session');
    }
}
