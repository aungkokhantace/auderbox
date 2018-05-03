<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 7/4/2016
 * Time: 3:03 PM
 */

use Illuminate\Database\Seeder;
class Default_UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    DB::table('core_users')->delete();

    $roles = array(
      ['id'=>1, 'user_name'=>'administrator_ab','display_name'=>'Administrator', 'password' =>'$2y$10$aFsFMkqNMP5kx0EyCs1wuOGu/je0OvLAhKXezURMLeYg/V1IztxwG', 'email' =>'administrator_ab@aceplussolutions.com','role_id' =>'1','staff_id'=>'9999','address'=>'Building 5, Room 10, MICT Park, Hlaing Township, Yangon, Myanmar.','description'=>'This is super admin first login role'],
      //pwd for user_id = 3 => 1@#@auderbox

      ['id'=>2, 'user_name'=>'admin_aceplus','display_name'=>'Administrator', 'password' =>'$2y$10$NLS2i1NpEUuQgoLgYk0QSOxsKxk6u1PFdeYJkpCraq2rS6polwYI6', 'email' =>'waiyanaung@aceplussolutions.com','role_id' =>'2','staff_id'=>'0001','address'=>'Building 5, Room 10, MICT Park, Hlaing Township, Yangon, Myanmar','description'=>'This is super admin role'],

      ['id'=>3, 'user_name'=>'admin_auderbox','display_name'=>'Starfish Administrator', 'password' =>'$2y$10$y57lFUd93SHOmCWJ8lZYROtnWQMxK90uos31q17Lhgfmc4fzgaDO6', 'email' =>'','role_id' =>'3','staff_id'=>'0002','address'=>'','description'=>'This is admin role'],
      //pwd for user_id = 2 => 123@auderbox

    );

    DB::table('core_users')->insert($roles);
}
}
