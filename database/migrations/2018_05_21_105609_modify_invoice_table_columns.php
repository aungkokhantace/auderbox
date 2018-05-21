<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyInvoiceTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
          $table->string('id')->change();
          $table->dropColumn('invoice_no');
        });

        Schema::table('invoice_detail', function (Blueprint $table) {
          $table->string('id')->change();
          $table->string('invoice_id')->change();
          $table->integer('uom_id')->after('product_group_id');
          $table->text('remark')->after('payable_amt');
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

        });

        Schema::table('invoice_detail', function (Blueprint $table) {
          $table->dropColumn('uom_id');
          $table->dropColumn('remark');
        });
    }
}
