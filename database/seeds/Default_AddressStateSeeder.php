<?php
use Illuminate\Database\Seeder;

class Default_AddressStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('address_states')->delete();
        $objs = array(
            ['id'=>'MMR001','country_id'=>'117','name_eng'=>'Kachin','name_mm'=>'ကချင်ပြည်နယ်','remark'=>'','created_by' =>'1','updated_by' =>'1','created_at' =>'2018-05-11 11:30:35','updated_at' =>'2018-05-11 11:30:35'],
        );
        DB::table('address_states')->insert($objs);
    }
}
