<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Seeders
         $this->call(Default_ConfigSeeder::class);
         $this->call(Default_RoleSeeder::class);
         $this->call(Default_UserSeeder::class);
         $this->call(Default_PermissionSeeder::class);
         $this->call(Default_RolePermissionSeeder::class);
         $this->call(Default_Syncs_TablesSeeder::class);
         $this->call(Default_CountriesSeeder::class);
         $this->call(Default_StateSeeder::class);
         $this->call(Default_TownshipSeeder::class);
         $this->call(Default_AddressStateSeeder::class);
         $this->call(Default_AddressDistrictSeeder::class);
         $this->call(Default_AddressTownshipSeeder::class);
         $this->call(Default_AddressTownSeeder::class);
         $this->call(Default_AddressWardSeeder::class);
    }
}
