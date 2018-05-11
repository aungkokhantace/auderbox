<?php
use Illuminate\Database\Seeder;

class Default_AddressDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('address_districts')->delete();
        $objs = array(
            ['id'=>'MMR017D002','country_id'=>'117','address_state_id'=>'MMR017','name_eng'=>'Hinthada','name_mm'=>'ဟင်္သာတခရိုင်','remark'=>'','created_by' =>'1','updated_by' =>'1','created_at' =>'2018-05-11 11:30:35','updated_at' =>'2018-05-11 11:30:35'],
        );
        DB::table('address_districts')->insert($objs);
    }
}
