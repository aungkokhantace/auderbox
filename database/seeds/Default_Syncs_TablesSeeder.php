<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 7/4/2016
 * Time: 3:03 PM
 */

use Illuminate\Database\Seeder;
class Default_Syncs_TablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_syncs_tables')->delete();

        $syncs_tables = array(
            ['id'=>1, 'table_name'=>'core_configs', 'version' =>'1'],
            ['id'=>2, 'table_name'=>'core_permissions', 'version' =>'1'],
            ['id'=>3, 'table_name'=>'core_permission_role', 'version' =>'1'],
            ['id'=>4, 'table_name'=>'core_roles', 'version' =>'1'],
            ['id'=>5, 'table_name'=>'core_users', 'version' =>'1'],
            ['id'=>6, 'table_name'=>'core_settings', 'version' =>'1'],
            ['id'=>7, 'table_name'=>'customer','version'=>'1'],
            ['id'=>8, 'table_name'=>'tablet_activation','version'=>'1']
        );

        DB::table('core_syncs_tables')->insert($syncs_tables);
    }
}