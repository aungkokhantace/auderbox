<?php
use Illuminate\Database\Seeder;

class Default_BrandownerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('brand_owners')->truncate();
        $objs = array(
            ['id'=>1,'name'=>'Coca Cola','sku_prefix'=>'COCA-COLA','logo'=>'/images/brandowner_images/coca-cola-logo-260x260.png','phone'=>'0911111111','email'=>'cocacola@gmail.com','address'=>'Yangon','contact_name'=>'U Mg Mg','contact_phone'=>'0911111111','contact_email'=>'mgmg@gmail.com','country_id'=>'117','address_state_id'=>'MMR013','address_district_id'=>'MMR013D004','address_township_id'=>'MMR013039','address_town_id'=>'MMR013039701','address_ward_id'=>'MMR013039701517','remark'=>'Coca Cola Remark','status'=>'1'],

        );
        DB::table('brand_owners')->insert($objs);
    }
}
