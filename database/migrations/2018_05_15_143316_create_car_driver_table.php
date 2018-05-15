<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_driver', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',45);
            $table->text('description')->nullable();
            $table->date('joined_date');
            $table->date('dob');
            $table->string('phone',45);
            $table->text('address');
            $table->tinyInteger('status')->default(1);
            $table->text('remark')->nullable();

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
        Schema::drop('car_driver');
    }
}
