<?php
use Illuminate\Database\Seeder;

class Default_RetailerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('retailers')->truncate();
        $objs = array(
            ['id'=>1,'user_id'=>'4','name_eng'=>'U Mg Mg','name_mm'=>'ဦးေမာင္ေမာင္','dob'=>'1984-05-08','nrc'=>'12/YAKANA(N)123456','phone'=>'09123456789','email'=>'umgmg@gmail.com','address'=>'No(59), Kan Lann, Hlaing, Yangon','photo'=>'/images/retailer_images/umgmg.png','nrc_front_photo'=>'/images/retailer_images/umgmg_nrc_front.png','nrc_back_photo'=>'/images/retailer_images/umgmg_nrc_back.png','country_id'=>'117','address_state_id'=>'MMR013','address_district_id'=>'MMR013D004','address_township_id'=>'MMR013039','address_town_id'=>'MMR013039701','address_ward_id'=>'MMR013039701517','remark'=>'','status'=>'1'],

        );
        DB::table('retailers')->insert($objs);
    }
}
