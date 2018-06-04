<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDataLengthOfInvoiceDetailAmtColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_detail', function (Blueprint $table) {
            $table->decimal('net_amt',10,2)->change();
            $table->decimal('discount_amt',10,2)->change();
            $table->decimal('net_amt_w_disc',10,2)->change();
            $table->decimal('tax_amt',10,2)->change();
            $table->decimal('payable_amt',10,2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_detail', function (Blueprint $table) {
            //
        });
    }
}
