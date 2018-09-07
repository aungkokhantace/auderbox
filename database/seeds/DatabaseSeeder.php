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
        //core seeders
         $this->call(Default_ConfigSeeder::class);
         $this->call(Default_RoleSeeder::class);
         $this->call(Default_UserSeeder::class);
         $this->call(Default_PermissionSeeder::class);
         $this->call(Default_RolePermissionSeeder::class);
         $this->call(Default_Syncs_TablesSeeder::class);
         $this->call(Default_CountriesSeeder::class);
         $this->call(Default_StateSeeder::class);
         $this->call(Default_TownshipSeeder::class);
         $this->call(Default_AddressStatesSeeder::class);
         $this->call(Default_AddressDistrictsSeeder::class);
         $this->call(Default_AddressTownshipsSeeder::class);
         $this->call(Default_AddressTownsSeeder::class);
         $this->call(Default_AddressWardsSeeder::class);
         $this->call(Default_AddressVillagetractsSeeder::class);
         $this->call(Default_AddressVillagesSeeder::class);
         //core seeders

         //setup data seeders
         $this->call(Default_BrandownerSeeder::class);
         $this->call(Default_BrandownerDeliveryBlackoutDaySeeder::class);
         $this->call(Default_RetailerSeeder::class);
         $this->call(Default_RetailShopTypeSeeder::class);
         $this->call(Default_RetailShopSeeder::class);
         $this->call(Default_CarTypeSeeder::class);
         $this->call(Default_CarDriverSeeder::class);
         $this->call(Default_CarSeeder::class);
         $this->call(Default_DeliveryRouteSeeder::class);
         $this->call(Default_DeliveryRouteDetailSeeder::class);
         $this->call(Default_DeliveryRouteDaySeeder::class);
         $this->call(Default_ProductVolumeTypeSeeder::class);
         $this->call(Default_ProductContainerTypeSeeder::class);
         $this->call(Default_ProductUomTypeSeeder::class);
         $this->call(Default_ProductCategorySeeder::class);
         $this->call(Default_ProductLineSeeder::class);
         $this->call(Default_ProductGroupSeeder::class);
         $this->call(Default_ProductSeeder::class);
         $this->call(Default_ProductPriceSeeder::class);
         //setup data seeders


    }
}
