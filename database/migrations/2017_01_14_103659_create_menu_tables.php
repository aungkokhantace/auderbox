<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category');
            $table->tinyInteger('active');

            //Common to all table ----------------------------------------------
            $table->string('created_by',100)->nullable();
            $table->string('updated_by',100)->nullable();
            $table->string('deleted_by',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('menu_detail', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id');
            $table->string('page_url');
            $table->integer('menu_order');
            $table->string('status');
            $table->string('menu_group');
            $table->integer('menu_group_order');
            $table->string('name');
            $table->integer('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menu_detail');
        Schema::drop('menu');
    }
}
