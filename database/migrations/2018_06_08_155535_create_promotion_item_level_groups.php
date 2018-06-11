<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionItemLevelGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_item_level_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_owner_id');
            $table->string('code');
            $table->string('name');
            $table->date('from_date');
            $table->date('to_date');
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
        Schema::drop('promotion_item_level_groups');
    }
}
