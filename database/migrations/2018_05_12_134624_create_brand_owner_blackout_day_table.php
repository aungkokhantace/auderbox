<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandOwnerBlackoutDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_owner_blackout_day', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_owner_id');
            $table->string('name',45);
            $table->date('date');
            $table->integer('type'); //1=> "public holiday", 2=>"customize"
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
        Schema::drop('brand_owner_blackout_day');
    }
}
