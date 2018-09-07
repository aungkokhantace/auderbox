<?php
use Illuminate\Database\Seeder;

class Default_DeliveryRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('delivery_route')->truncate();
        $objs = array(
            ['id'=>1,'route_name'=>'Route 1','route_code'=>'Route-0001','brand_owner_id'=>'1','car_id'=>'1','remark'=>'','status'=>'1'],

        );
        DB::table('delivery_route')->insert($objs);
    }
}
