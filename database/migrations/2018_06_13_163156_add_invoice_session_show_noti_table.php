<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceSessionShowNotiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_session_show_noti', function (Blueprint $table) {
          $table->string('invoice_session_id');
          $table->integer('retailer_id');
          $table->integer('retailshop_id');
          $table->integer('promotion_item_level_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoice_session_show_noti');
    }
}
