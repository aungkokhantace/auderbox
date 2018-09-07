<?php
use Illuminate\Database\Seeder;

class Default_CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('car_type')->truncate();
        $objs = array(
            ['id'=>1,'name'=>'Truck','description'=>'','brand'=>'Toyota','remark'=>'','status'=>'1'],

        );
        DB::table('car_type')->insert($objs);
    }
}
