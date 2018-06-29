<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOneTimeAlertAndDoNotShowAgainFlagColumnsToInvoiceSessionShowNoti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_session_show_noti', function (Blueprint $table) {
          $table->tinyInteger('one_time_alerted')->after('promotion_item_level_id')->default(1);
          $table->tinyInteger('do_not_show_again_ticked')->after('one_time_alerted')->default(0);
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
            $table->dropColumn('one_time_alerted');
            $table->dropColumn('do_not_show_again_ticked');
        });
    }
}
