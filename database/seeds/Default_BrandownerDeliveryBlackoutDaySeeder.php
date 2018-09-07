<?php
use Illuminate\Database\Seeder;

class Default_BrandownerDeliveryBlackoutDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('brand_owner_delivery_blackout_day')->truncate();
        $objs = array(
            ['id'=>1,'brand_owner_id'=>'1','name'=>'May Day','date'=>'2018-05-01','type'=>'1','remark'=>'We are closed on May Day(public holiday)','status'=>'1'],

        );
        DB::table('brand_owner_delivery_blackout_day')->insert($objs);
    }
}
