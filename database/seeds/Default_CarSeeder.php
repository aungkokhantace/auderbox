<?php
use Illuminate\Database\Seeder;

class Default_CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('cars')->truncate();
        $objs = array(
            ['id'=>1,'car_no_plate'=>'7N/7878','car_type_id'=>'1','car_driver_id'=>'1','name'=>'Car 1','description'=>'','remark'=>'','status'=>'1'],

        );
        DB::table('cars')->insert($objs);
    }
}
