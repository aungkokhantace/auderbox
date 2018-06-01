<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 2:18 PM
 */
use Illuminate\Database\Seeder;
class Default_PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_permission_role')->delete();
        DB::table('core_permissions')->delete();

        $permissions = array(
          // Roles
          ['id'=>1,'module'=>'Role','name'=>'Listing','description'=>'Role Listing','url'=>'backend/role'],
          ['id'=>2,'module'=>'Role','name'=>'New','description'=>'Role New','url'=>'backend/role/create'],
          ['id'=>3,'module'=>'Role','name'=>'Store','description'=>'Role Store','url'=>'backend/role/store'],
          ['id'=>4,'module'=>'Role','name'=>'Edit','description'=>'Role Edit','url'=>'backend/role/edit'],
          ['id'=>5,'module'=>'Role','name'=>'Update','description'=>'Role Update','url'=>'backend/role/update'],
          ['id'=>6,'module'=>'Role','name'=>'Destroy','description'=>'Role Destroy','url'=>'backend/role/destroy'],
          ['id'=>7,'module'=>'Role','name'=>'Permission_View','description'=>'Role Permission View','url'=>'backend/rolePermission'],
          ['id'=>8,'module'=>'Role','name'=>'Permission_Assign','description'=>'Role Permission Assign','url'=>'backend/rolePermissionAssign'],

          // Users
          ['id'=>10,'module'=>'User','name'=>'Listing','description'=>'User Listing','url'=>'backend/user'],
          ['id'=>11,'module'=>'User','name'=>'New','description'=>'User New','url'=>'backend/user/create'],
          ['id'=>12,'module'=>'User','name'=>'Store','description'=>'User Store','url'=>'backend/user/store'],
          ['id'=>13,'module'=>'User','name'=>'Edit','description'=>'User Edit','url'=>'backend/user/edit'],
          ['id'=>14,'module'=>'User','name'=>'Update','description'=>'User Update','url'=>'backend/user/update'],
          ['id'=>15,'module'=>'User','name'=>'Destroy','description'=>'User Destroy','url'=>'backend/user/destroy'],
          ['id'=>16,'module'=>'User','name'=>'Auth','description'=>'Getting Auth User','url'=>'backend/userAuth'],
          ['id'=>17,'module'=>'User','name'=>'Profile','description'=>'User Profile','url'=>'backend/user/profile'],
          ['id'=>18,'module'=>'User','name'=>'Activate/Deactivate','description'=>'User Activate/Deactivate','url'=>'backend/user/status'],

          // Permissions
          ['id'=>20,'module'=>'Permission','name'=>'Listing','description'=>'Permission Listing','url'=>'backend/permission'],
          ['id'=>21,'module'=>'Permission','name'=>'New','description'=>'Permission New','url'=>'backend/permission/create'],
          ['id'=>22,'module'=>'Permission','name'=>'Store','description'=>'Permission Store','url'=>'backend/permission/store'],
          ['id'=>23,'module'=>'Permission','name'=>'Edit','description'=>'Permission Edit','url'=>'backend/permission/edit'],
          ['id'=>24,'module'=>'Permission','name'=>'Update','description'=>'Permission Update','url'=>'backend/permission/update'],
          ['id'=>25,'module'=>'Permission','name'=>'Destroy','description'=>'Permission Destroy','url'=>'backend/permission/destroy'],

          // Configs
          ['id'=>30,'module'=>'Config','name'=>'View','description'=>'Editing','url'=>'backend/config'],

          //Activity Log
          ['id'=>35,'module'=>'Activity_Log','name'=>'Activity Log','description'=>'Activity Log','url'=>'backend/activities'],

          //API format list
          ['id'=>36,'module'=>'API_Formats','name'=>'API_Formats','description'=>'API_Formats','url'=>'backend/api_formats'],

          //Country
          ['id'=>40,'module'=>'Country','name'=>'Listing','description'=>'Country Listing','url'=>'backend/country'],
          ['id'=>41,'module'=>'Country','name'=>'New','description'=>'Country New','url'=>'backend/country/create'],
          ['id'=>42,'module'=>'Country','name'=>'Store','description'=>'Country Store','url'=>'backend/country/store'],
          ['id'=>43,'module'=>'Country','name'=>'Edit','description'=>'Country Edit','url'=>'backend/country/edit'],
          ['id'=>44,'module'=>'Country','name'=>'Update','description'=>'Country Update','url'=>'backend/country/update'],
          ['id'=>45,'module'=>'Country','name'=>'Destroy','description'=>'Country Destroy','url'=>'backend/country/destroy'],

          //City
          ['id'=>50,'module'=>'City','name'=>'Listing','description'=>'City Listing','url'=>'backend/city'],
          ['id'=>51,'module'=>'City','name'=>'New','description'=>'City New','url'=>'backend/city/create'],
          ['id'=>52,'module'=>'City','name'=>'Store','description'=>'City Store','url'=>'backend/city/store'],
          ['id'=>53,'module'=>'City','name'=>'Edit','description'=>'City Edit','url'=>'backend/city/edit'],
          ['id'=>54,'module'=>'City','name'=>'Update','description'=>'City Update','url'=>'backend/city/update'],
          ['id'=>55,'module'=>'City','name'=>'Destroy','description'=>'City Destroy','url'=>'backend/city/destroy'],

          //Township
          ['id'=>60,'module'=>'Township','name'=>'Listing','description'=>'Township Listing','url'=>'backend/township'],
          ['id'=>61,'module'=>'Township','name'=>'New','description'=>'Township New','url'=>'backend/township/create'],
          ['id'=>62,'module'=>'Township','name'=>'Store','description'=>'Township Store','url'=>'backend/township/store'],
          ['id'=>63,'module'=>'Township','name'=>'Edit','description'=>'Township Edit','url'=>'backend/township/edit'],
          ['id'=>64,'module'=>'Township','name'=>'Update','description'=>'Township Update','url'=>'backend/township/update'],
          ['id'=>65,'module'=>'Township','name'=>'Destroy','description'=>'Township Destroy','url'=>'backend/township/destroy'],

          //Reports
          //Invoice Report
          ['id'=>70,'module'=>'Invoice Report','name'=>'List','description'=>'Invoice Report List','url'=>'backend/invoice_report'],
          ['id'=>71,'module'=>'Invoice Report','name'=>'Search','description'=>'Invoice Report Search','url'=>'backend/invoice_report/search'],
          ['id'=>72,'module'=>'Invoice Report','name'=>'Detail','description'=>'Invoice Detail Report','url'=>'backend/invoice_report/detail'],
          ['id'=>73,'module'=>'Invoice Report','name'=>'Deliver Invoice','description'=>'Deliver Invoice','url'=>'backend/invoice_report/deliver_invoice'],
          ['id'=>74,'module'=>'Invoice Report','name'=>'Cancel Invoice','description'=>'Cancel Invoice','url'=>'backend/invoice_report/cancel_invoice'],
          ['id'=>75,'module'=>'Invoice Report','name'=>'Partial Deliver Invoice','description'=>'Partial Deliver Invoice','url'=>'backend/invoice_report/partial_deliver_invoice'],
          ['id'=>76,'module'=>'Invoice Report','name'=>'Partial Cancel Invoice','description'=>'Partial Cancel Invoice','url'=>'backend/invoice_report/partial_cancel_invoice'],

        );

        DB::table('core_permissions')->insert($permissions);
    }
}
