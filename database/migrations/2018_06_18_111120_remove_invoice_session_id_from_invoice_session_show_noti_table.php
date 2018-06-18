<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveInvoiceSessionIdFromInvoiceSessionShowNotiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_session_show_noti', function (Blueprint $table) {
            $table->dropColumn('invoice_session_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_session_show_noti', function (Blueprint $table) {
            //
        });
    }
}
