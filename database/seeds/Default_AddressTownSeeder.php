<?php
use Illuminate\Database\Seeder;

class Default_AddressTownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('address_towns')->delete();
        $objs = array(
            ['id'=>'MMR017024701','country_id'=>'117','address_state_id'=>'MMR017','address_district_id'=>'MMR017D006','address_township_id'=>'MMR017024','name_eng'=>'Bogale Town','name_mm'=>'ဘိုကလေး','remark'=>'','created_by' =>'1','updated_by' =>'1','created_at' =>'2018-05-11 11:30:35','updated_at' =>'2018-05-11 11:30:35'],
        );
        DB::table('address_towns')->insert($objs);
    }
}
