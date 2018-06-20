<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRetailerPointLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailer_point_log', function (Blueprint $table) {
          $table->string('id');
          $table->string('retailer_point_id');
          $table->dateTime('created_date');
          $table->integer('points');
          $table->integer('retailer_reward_id')->nullable();
          $table->integer('status')->default(1);

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
        Schema::drop('retailer_point_log');
    }
}
