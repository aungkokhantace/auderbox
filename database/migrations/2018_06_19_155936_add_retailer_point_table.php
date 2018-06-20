<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRetailerPointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retailer_point', function (Blueprint $table) {
          $table->string('id');
          $table->integer('retailer_id');
          $table->integer('retailshop_id');
          $table->integer('brand_owner_id');
          $table->string('invoice_id');
          $table->integer('used_points');
          $table->integer('available_points');
          $table->integer('total_points');
          $table->tinyInteger('with_expiration')->default(0);
          $table->date('expiry_date')->nullable();
          $table->text('remark')->nullable();
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
        Schema::drop('retailer_point');
    }
}
