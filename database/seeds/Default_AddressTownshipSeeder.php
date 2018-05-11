<?php
use Illuminate\Database\Seeder;

class Default_AddressTownshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('address_townships')->delete();
        $objs = array(
            ['id'=>'MMR017024','country_id'=>'117','address_state_id'=>'MMR017','address_district_id'=>'MMR017D006','name_eng'=>'Bogale','name_mm'=>'ဘိုကလေး','remark'=>'','created_by' =>'1','updated_by' =>'1','created_at' =>'2018-05-11 11:30:35','updated_at' =>'2018-05-11 11:30:35'],
        );
        DB::table('address_townships')->insert($objs);
    }
}
