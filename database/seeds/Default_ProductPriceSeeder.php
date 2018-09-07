<?php
use Illuminate\Database\Seeder;

class Default_ProductPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('product_price')->truncate();
        $objs = array(
            ['id'=>1,'product_id'=>'1','country_id'=>'117','address_state_id'=>'MMR013','address_district_id'=>'MMR013D004','address_township_id'=>'MMR013039','address_town_id'=>'MMR013039701','address_ward_id'=>'MMR013039701517','price'=>'1000','status'=>'1']

        );
        DB::table('product_price')->insert($objs);
    }
}
