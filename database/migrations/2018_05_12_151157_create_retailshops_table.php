<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetailshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailshops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('retailer_id');
            $table->integer('address_state_id');
            $table->integer('address_district_id');
            $table->integer('address_township_id');
            $table->integer('address_town_id');
            $table->integer('address_ward_id');
            $table->string('name_eng',45);
            $table->string('name_mm',45);
            $table->string('registration_no',45);
            $table->string('phone',45);
            $table->string('email',45);
            $table->text('address');
            $table->string('latitude',45);
            $table->string('longitude',45);
            $table->integer('retailshop_type_id');
            $table->text('remark');
            $table->tinyInteger('status');

            //common to all tables...
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
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
        Schema::drop('retailshops');
    }
}
