<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromotionPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_points', function (Blueprint $table) {
          $table->increments('id');
          $table->decimal('promo_amount',10,2);
          $table->integer('promo_point');
          $table->tinyInteger('with_expiration')->default(0);
          $table->integer('point_life_time_day_count')->nullable();
          $table->tinyInteger('status')->default(1);

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
        Schema::drop('promotion_points');
    }
}
