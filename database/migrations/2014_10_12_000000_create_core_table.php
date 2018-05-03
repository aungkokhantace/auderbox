<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('core_settings', function(Blueprint $table) {
            $table->string('code');
            $table->string('type');
            $table->integer('value');
            $table->text('description');

            //Common to all table ----------------------------------------------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(array('code','type'));

        });

        Schema::create('core_syncs_tables', function(Blueprint $table) {
            $table->increments('id');
            $table->string('table_name');
            $table->integer('version');
            $table->integer('active')->default(1);

            //Common to all table ----------------------------------------------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('core_roles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();

            //Common to all table ----------------------------------------------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });


        Schema::create('core_users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('user_name', 255);
            $table->string('staff_id')->unique();
            $table->string('password', 64);
            $table->string('email')->unique();
            $table->string('description')->nullable();
            $table->string('display_name')->nullable();
            $table->string('display_image')->nullable()->default('/assets/images/generals/image_user_dp_default.png');
            $table->unsignedInteger('role_id');
            $table->text('about_me');
            $table->text('address');

            $table->string('country',2)->default('');
            $table->string('language',10)->default('en');
            $table->integer('status')->default(1);;
            $table->dateTime('last_activity')->nullable();
            $table->rememberToken();

            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')
                ->references('id')->on('core_roles')
                ->onDelete('restrict');
        });

        Schema::create('core_permissions',function(Blueprint $table){
            $table->increments('id');
            $table->string('module')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('position')->nullable();
            $table->string('url')->nullable();

            //Common to all table ----------------------------------------------
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('core_permission_role',function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');
            $table->tinyInteger('position')->default(1);

            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(array('role_id','permission_id'));
            $table->foreign('role_id')
                ->references('id')->on('core_roles')
                ->onDelete('restrict');
            $table->foreign('permission_id')
                ->references('id')->on('core_permissions')
                ->onDelete('restrict');
        });

        Schema::create('core_configs',function(Blueprint $table){
            $table->string('code',50);
            $table->string('type',50);
            $table->string('value',255)->nullable();
            $table->string('description',255)->nullable();

            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary(array('code','type'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('core_permission_role');
        Schema::drop('core_permissions');
        Schema::drop('core_users');
        Schema::drop('core_roles');
        Schema::drop('core_configs');
        Schema::drop('core_syncs_tables');
        Schema::drop('core_settings');
    }
}
