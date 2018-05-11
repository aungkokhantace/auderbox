<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_towns', function (Blueprint $table) {
            $table->string('id');
            $table->string('address_state_id');
            $table->string('address_district_id');
            $table->string('address_township_id');
            $table->string('name_eng',45);
            $table->string('name_mm',45);
            $table->string('myainfo_sd_id',45);
            $table->text('remark');

            //common to all tables...
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('address_towns');
    }
}
