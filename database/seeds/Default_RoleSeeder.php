<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 2:17 PM
 */
use Illuminate\Database\Seeder;
class Default_RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_roles')->delete();

        $roles = array(
          ['id'=>1, 'name'=>'SUPER-ADMIN FIRST LOGIN', 'description'=>'Super admin first login role'],
          ['id'=>2, 'name'=>'SUPER-ADMIN', 'description'=>'Super admin role'],
          ['id'=>3, 'name'=>'SYSTEM ADMIN', 'description'=>'System admin role'],
          ['id'=>4, 'name'=>'OFFICE STAFF', 'description'=>'Office staff role'],
          ['id'=>5, 'name'=>'RETAILER', 'description'=>'Retailer role'],
          ['id'=>6, 'name'=>'SURVEYOR', 'description'=>'Surveyor role'],
        );

        DB::table('core_roles')->insert($roles);
    }
}
