<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no',45);
            $table->integer('status');
            $table->dateTime('order_date');
            $table->dateTime('delivery_date');
            $table->dateTime('payment_date');
            $table->integer('retailer_id');
            $table->integer('brand_owner_id');
            $table->integer('retailshop_id');
            $table->decimal('tax_rate',10,2);
            $table->decimal('total_net_amt',10,2);
            $table->decimal('total_discount_amt',10,2);
            $table->decimal('total_net_amt_w_disc',10,2);
            $table->decimal('total_tax_amt',10,2);
            $table->decimal('total_payable_amt',10,2);
            $table->text('remark')->nullable();
            $table->integer('confirm_by');
            $table->dateTime('confirm_date');
            $table->integer('cancel_by');
            $table->dateTime('cancel_date');

            //common to all tables...
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('invoice_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id');
            $table->integer('product_id');
            $table->integer('product_group_id');
            $table->integer('status');
            $table->string('uom',45);
            $table->integer('quantity');
            $table->decimal('unit_price',10,2);
            $table->decimal('net_amt');
            $table->decimal('discount_amt');
            $table->decimal('net_amt_w_disc');
            $table->decimal('tax_amt');
            $table->decimal('payable_amt');
            $table->integer('confirm_by');
            $table->dateTime('confirm_date');
            $table->integer('cancel_by');
            $table->dateTime('cancel_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoice_detail');
        Schema::drop('invoices');
    }
}
