<?php
use Illuminate\Database\Seeder;

class Default_DeliveryRouteDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('delivery_route_day')->truncate();
        $objs = array(
            ['id'=>1,'delivery_route_id'=>'1','monday'=>'0','tuesday'=>'1','wednesday'=>'0','thursday'=>'1','friday'=>'0','saturday'=>'1','sunday'=>'0','deliver_today'=>'1','status'=>'1'],

        );
        DB::table('delivery_route_day')->insert($objs);
    }
}
