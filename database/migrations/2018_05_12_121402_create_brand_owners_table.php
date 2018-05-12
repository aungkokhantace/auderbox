<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_owners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',45);
            $table->string('logo',45);
            $table->string('phone',45);
            $table->string('email',45);
            $table->text('address',45);
            $table->string('contact_name',45);
            $table->string('contact_phone',45);
            $table->string('contact_email',45);
            $table->integer('address_state_id');
            $table->integer('address_district_id');
            $table->integer('address_township_id');
            $table->integer('address_town_id');
            $table->integer('address_ward_id');
            $table->text('remark')->nullable();
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
        Schema::drop('brand_owners');
    }
}
