<?php
use Illuminate\Database\Seeder;

class Default_AddressWardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('address_wards')->delete();
        $objs = array(
            ['id'=>'MMR017024701501','country_id'=>'117','address_state_id'=>'MMR017','address_district_id'=>'MMR017D006','address_township_id'=>'MMR017024','address_town_id'=>'MMR017024701','name_eng'=>'No (1) Ward','name_mm'=>'အမှတ် (၁) ရပ်ကွက်','remark'=>'','created_by' =>'1','updated_by' =>'1','created_at' =>'2018-05-11 11:30:35','updated_at' =>'2018-05-11 11:30:35'],
        );
        DB::table('address_wards')->insert($objs);
    }
}
