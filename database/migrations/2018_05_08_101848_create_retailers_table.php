<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name_eng',45);
            $table->string('name_mm',45);
            $table->string('nrc',45);
            $table->date('dob');
            $table->string('phone',45);
            $table->string('email',45);
            $table->text('address');
            $table->text('photo');
            $table->text('nrc_front_photo');
            $table->text('nrc_back_photo');
            $table->integer('address_state_id');
            $table->integer('address_district_id');
            $table->integer('address_township_id');
            $table->integer('address_town_id');
            $table->integer('address_ward_id');
            $table->text('remark');
            $table->tinyInteger('status')->default(1);

            //Common to all table ----------------------------------------------
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
        Schema::drop('retailers');
    }
}
