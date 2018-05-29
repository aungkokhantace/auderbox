<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedDatesToInvoiceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_detail', function (Blueprint $table) {
          //common to all tables...
          $table->integer('created_by')->default(1)->after('cancel_date');
          $table->integer('updated_by')->default(1)->after('created_by');
          $table->integer('deleted_by')->nullable()->after('updated_by');
          $table->timestamps();
          $table->softDeletes();
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
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');
        });
    }
}
