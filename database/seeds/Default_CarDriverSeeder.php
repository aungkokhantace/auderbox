<?php
use Illuminate\Database\Seeder;

class Default_CarDriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('car_driver')->truncate();
        $objs = array(
            ['id'=>1,'name'=>'Aung Aung','description'=>'','joined_date'=>'2018-03-01','dob'=>'1990-07-16','phone'=>'779988556','address'=>'kyimyingdaing','remark'=>'','status'=>'1'],

        );
        DB::table('car_driver')->insert($objs);
    }
}
