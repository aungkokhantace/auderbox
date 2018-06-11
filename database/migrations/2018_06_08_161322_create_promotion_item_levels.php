<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionItemLevels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_item_levels', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('promotion_item_level_group_id');
          $table->string('code');
          $table->string('name');
          $table->integer('promo_type');
          $table->date('from_date');
          $table->date('to_date');
          $table->decimal('from_amount',10,2);
          $table->decimal('to_amount',10,2);
          $table->integer('from_qty');
          $table->integer('to_qty');
          $table->integer('promo_product_id');
          $table->integer('promo_qty');
          $table->decimal('promo_percentage',10,2);
          $table->decimal('promo_amt',10,2);
          $table->tinyInteger('max_count_apply');
          $table->integer('promo_allow_max_count');
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
        Schema::drop('promotion_item_levels');
    }
}
