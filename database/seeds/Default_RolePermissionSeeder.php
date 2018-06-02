<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 2:19 PM
 */

use Illuminate\Database\Seeder;
use App\Backend\CorePermissionRole\CorePermissionRole;

class Default_RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('core_permission_role')->delete();
        CorePermissionRole::query()->truncate();

        $roles = array(
          //start super-admin (role_id = 2) permissions
            // Roles
            ['role_id'=>2, 'permission_id'=>1],
            ['role_id'=>2, 'permission_id'=>2],
            ['role_id'=>2, 'permission_id'=>3],
            ['role_id'=>2, 'permission_id'=>4],
            ['role_id'=>2, 'permission_id'=>5],
            ['role_id'=>2, 'permission_id'=>6],
            ['role_id'=>2, 'permission_id'=>7],
            ['role_id'=>2, 'permission_id'=>8],

            // Users
            ['role_id'=>2, 'permission_id'=>10],
            ['role_id'=>2, 'permission_id'=>11],
            ['role_id'=>2, 'permission_id'=>12],
            ['role_id'=>2, 'permission_id'=>13],
            ['role_id'=>2, 'permission_id'=>14],
            ['role_id'=>2, 'permission_id'=>15],
            ['role_id'=>2, 'permission_id'=>16],
            ['role_id'=>2, 'permission_id'=>17],
            ['role_id'=>2, 'permission_id'=>18],

            // Permissions
            ['role_id'=>2, 'permission_id'=>20],
            ['role_id'=>2, 'permission_id'=>21],
            ['role_id'=>2, 'permission_id'=>22],
            ['role_id'=>2, 'permission_id'=>23],
            ['role_id'=>2, 'permission_id'=>24],
            ['role_id'=>2, 'permission_id'=>25],

            // Config
            ['role_id'=>2, 'permission_id'=>30],

            // Activity Log
            ['role_id'=>2, 'permission_id'=>35],

            // API formats
            ['role_id'=>2, 'permission_id'=>36],

            // Country
            ['role_id'=>2, 'permission_id'=>40],
            ['role_id'=>2, 'permission_id'=>41],
            ['role_id'=>2, 'permission_id'=>42],
            ['role_id'=>2, 'permission_id'=>43],
            ['role_id'=>2, 'permission_id'=>44],
            ['role_id'=>2, 'permission_id'=>45],

            // City
            ['role_id'=>2, 'permission_id'=>50],
            ['role_id'=>2, 'permission_id'=>51],
            ['role_id'=>2, 'permission_id'=>52],
            ['role_id'=>2, 'permission_id'=>53],
            ['role_id'=>2, 'permission_id'=>54],
            ['role_id'=>2, 'permission_id'=>55],

            // Township
            ['role_id'=>2, 'permission_id'=>60],
            ['role_id'=>2, 'permission_id'=>61],
            ['role_id'=>2, 'permission_id'=>62],
            ['role_id'=>2, 'permission_id'=>63],
            ['role_id'=>2, 'permission_id'=>64],
            ['role_id'=>2, 'permission_id'=>65],

            // Invoice Report
            ['role_id'=>2, 'permission_id'=>70],
            ['role_id'=>2, 'permission_id'=>71],
            ['role_id'=>2, 'permission_id'=>72],
            ['role_id'=>2, 'permission_id'=>73],
            ['role_id'=>2, 'permission_id'=>74],
            ['role_id'=>2, 'permission_id'=>75],
            ['role_id'=>2, 'permission_id'=>76],
            ['role_id'=>2, 'permission_id'=>77],
            ['role_id'=>2, 'permission_id'=>78],
          //end super-admin permissions

          //start system-admin (role_id = 3) permissions
            // Roles
            ['role_id'=>3, 'permission_id'=>1],
            ['role_id'=>3, 'permission_id'=>2],
            ['role_id'=>3, 'permission_id'=>3],
            ['role_id'=>3, 'permission_id'=>4],
            ['role_id'=>3, 'permission_id'=>5],
            ['role_id'=>3, 'permission_id'=>6],
            ['role_id'=>3, 'permission_id'=>7],
            ['role_id'=>3, 'permission_id'=>8],

            // Users
            ['role_id'=>3, 'permission_id'=>10],
            ['role_id'=>3, 'permission_id'=>11],
            ['role_id'=>3, 'permission_id'=>12],
            ['role_id'=>3, 'permission_id'=>13],
            ['role_id'=>3, 'permission_id'=>14],
            ['role_id'=>3, 'permission_id'=>15],
            ['role_id'=>3, 'permission_id'=>16],
            ['role_id'=>3, 'permission_id'=>17],
            ['role_id'=>3, 'permission_id'=>18],

            // Permissions
            ['role_id'=>3, 'permission_id'=>20],
            ['role_id'=>3, 'permission_id'=>21],
            ['role_id'=>3, 'permission_id'=>22],
            ['role_id'=>3, 'permission_id'=>23],
            ['role_id'=>3, 'permission_id'=>24],
            ['role_id'=>3, 'permission_id'=>25],

            // Config
            ['role_id'=>3, 'permission_id'=>30],

            // Activity Log
            ['role_id'=>3, 'permission_id'=>35],

            // Country
            ['role_id'=>3, 'permission_id'=>40],
            ['role_id'=>3, 'permission_id'=>41],
            ['role_id'=>3, 'permission_id'=>42],
            ['role_id'=>3, 'permission_id'=>43],
            ['role_id'=>3, 'permission_id'=>44],
            ['role_id'=>3, 'permission_id'=>45],

            // City
            ['role_id'=>3, 'permission_id'=>50],
            ['role_id'=>3, 'permission_id'=>51],
            ['role_id'=>3, 'permission_id'=>52],
            ['role_id'=>3, 'permission_id'=>53],
            ['role_id'=>3, 'permission_id'=>54],
            ['role_id'=>3, 'permission_id'=>55],

            // Township
            ['role_id'=>3, 'permission_id'=>60],
            ['role_id'=>3, 'permission_id'=>61],
            ['role_id'=>3, 'permission_id'=>62],
            ['role_id'=>3, 'permission_id'=>63],
            ['role_id'=>3, 'permission_id'=>64],
            ['role_id'=>3, 'permission_id'=>65],

            // Invoice Report
            ['role_id'=>3, 'permission_id'=>70],
            ['role_id'=>3, 'permission_id'=>71],
            ['role_id'=>3, 'permission_id'=>72],
            ['role_id'=>3, 'permission_id'=>73],
            ['role_id'=>3, 'permission_id'=>74],
            ['role_id'=>3, 'permission_id'=>75],
            ['role_id'=>3, 'permission_id'=>76],
            ['role_id'=>3, 'permission_id'=>77],
            ['role_id'=>3, 'permission_id'=>78],
          //end system-admin permissions

          //start office-staff (role_id = 4) permissions
          //end office-staff permissions

          //start retailer (role_id = 5) permissions
          //end retailer permissions
        );

        DB::table('core_permission_role')->insert($roles);
    }
}
