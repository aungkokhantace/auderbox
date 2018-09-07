<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpandLogoColumnLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_owners', function (Blueprint $table) {
            $table->string('name',255)->change();
            $table->string('logo',255)->change();
            $table->string('email',255)->change();
            $table->string('contact_name',255)->change();
            $table->string('contact_email',255)->change();
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
            //
        });
    }
}
