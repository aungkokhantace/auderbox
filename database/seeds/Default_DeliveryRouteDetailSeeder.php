<?php
use Illuminate\Database\Seeder;

class Default_DeliveryRouteDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('delivery_route_detail')->truncate();
        $objs = array(
            ['id'=>1,'delivery_route_id'=>'1','retailshop_id'=>'1','remark'=>'','status'=>'1'],

        );
        DB::table('delivery_route_detail')->insert($objs);
    }
}
