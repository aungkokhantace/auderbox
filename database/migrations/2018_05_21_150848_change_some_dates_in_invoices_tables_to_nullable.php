<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSomeDatesInInvoicesTablesToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
          $table->integer('confirm_by')->nullable()->change();
          $table->dateTime('confirm_date')->nullable()->change();
          $table->integer('cancel_by')->nullable()->change();
          $table->dateTime('cancel_date')->nullable()->change();
        });

        Schema::table('invoice_detail', function (Blueprint $table) {
          $table->integer('confirm_by')->nullable()->change();
          $table->dateTime('confirm_date')->nullable()->change();
          $table->integer('cancel_by')->nullable()->change();
          $table->dateTime('cancel_date')->nullable()->change();
          $table->text('remark')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            //
        });

        Schema::table('invoice_detail', function (Blueprint $table) {
          //
        });
    }
}
