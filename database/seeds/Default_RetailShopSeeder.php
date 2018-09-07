<?php
use Illuminate\Database\Seeder;

class Default_RetailShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('retailshops')->truncate();
        $objs = array(
            ['id'=>1,'retailer_id'=>'1','country_id'=>'117','address_state_id'=>'MMR013','address_district_id'=>'MMR013D004','address_township_id'=>'MMR013039','address_town_id'=>'MMR013039701','address_ward_id'=>'MMR013039701517','name_eng'=>'Pyae Sone','name_mm'=>'ျပည့္စုံ','registration_no'=>'abc-112233','phone'=>'0145678','email'=>'pyaesone@gmail.com','address'=>'No(59), Kan Lann, Hlaing, Yangon','latitude'=>'21.133103','longitude'=>'94.86955','retailshop_type_id'=>'1','remark'=>'','status'=>'1'],

        );
        DB::table('retailshops')->insert($objs);
    }
}
