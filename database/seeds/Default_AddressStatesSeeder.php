<?php

use Illuminate\Database\Seeder;

class Default_AddressStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


	DB::table('address_states')->delete();

      $result = array(
         [
                'id'=> 'MMR001',
                'country_id'=> '117',
                'name_eng' => 'Kachin',
                'name_mm' => 'ကချင်ပြည်နယ်',

                'remark'=>''],
[
                'id'=> 'MMR002',
                'country_id'=> '117',
                'name_eng' => 'Kayah',
                'name_mm' => 'ကယားပြည်နယ်',

                'remark'=>''],
[
                'id'=> 'MMR003',
                'country_id'=> '117',
                'name_eng' => 'Kayin',
                'name_mm' => 'ကရင်ပြည်နယ်',

                'remark'=>''],
[
                'id'=> 'MMR004',
                'country_id'=> '117',
                'name_eng' => 'Chin',
                'name_mm' => 'ချင်းပြည်နယ်',

                'remark'=>''],
[
                'id'=> 'MMR005',
                'country_id'=> '117',
                'name_eng' => 'Sagaing',
                'name_mm' => 'စစ်ကိုင်းတိုင်းဒေသကြီး',

                'remark'=>''],
[
                'id'=> 'MMR006',
                'country_id'=> '117',
                'name_eng' => 'Tanintharyi',
                'name_mm' => 'တနင်္သာရီတိုင်းဒေသကြီး',

                'remark'=>''],
[
                'id'=> 'MMR007',
                'country_id'=> '117',
                'name_eng' => 'Bago (East)',
                'name_mm' => 'ပဲခူးတိုင်းဒေသကြီး (အရှေ့)',

                'remark'=>''],
[
                'id'=> 'MMR008',
                'country_id'=> '117',
                'name_eng' => 'Bago (West)',
                'name_mm' => 'ပဲခူးတိုင်းဒေသကြီး (အနောက်)',

                'remark'=>''],
[
                'id'=> 'MMR009',
                'country_id'=> '117',
                'name_eng' => 'Magway',
                'name_mm' => 'မကွေးတိုင်းဒေသကြီး',

                'remark'=>''],
[
                'id'=> 'MMR010',
                'country_id'=> '117',
                'name_eng' => 'Mandalay',
                'name_mm' => 'မန္တလေးတိုင်းဒေသကြီး',

                'remark'=>''],
[
                'id'=> 'MMR011',
                'country_id'=> '117',
                'name_eng' => 'Mon',
                'name_mm' => 'မွန်ပြည်နယ်',

                'remark'=>''],
[
                'id'=> 'MMR012',
                'country_id'=> '117',
                'name_eng' => 'Rakhine',
                'name_mm' => 'ရခိုင်ပြည်နယ်',

                'remark'=>''],
[
                'id'=> 'MMR013',
                'country_id'=> '117',
                'name_eng' => 'Yangon',
                'name_mm' => 'ရန်ကုန်ဒေသကြီး',

                'remark'=>''],
[
                'id'=> 'MMR014',
                'country_id'=> '117',
                'name_eng' => 'Shan (South)',
                'name_mm' => 'ရှမ်းပြည်နယ် (တောင်)',

                'remark'=>''],
[
                'id'=> 'MMR015',
                'country_id'=> '117',
                'name_eng' => 'Shan (North)',
                'name_mm' => 'ရှမ်းပြည်နယ် (မြောက်)',

                'remark'=>''],
[
                'id'=> 'MMR016',
                'country_id'=> '117',
                'name_eng' => 'Shan (East)',
                'name_mm' => 'ရှမ်းပြည်နယ် (အရှေ့)',

                'remark'=>''],
[
                'id'=> 'MMR017',
                'country_id'=> '117',
                'name_eng' => 'Ayeyarwady',
                'name_mm' => 'ဧရာဝတီတိုင်းဒေသကြီး',

                'remark'=>''],
[
                'id'=> 'MMR018',
                'country_id'=> '117',
                'name_eng' => 'Nay Pyi Taw',
                'name_mm' => 'နေပြည်တော်',

                'remark'=>''],
[
                'id'=> 'MMR111',
                'country_id'=> '117',
                'name_eng' => 'Bago',
                'name_mm' => 'ပဲခူးတိုင်းဒေသကြီး',

                'remark'=>'Just for the whole Bago Region'],
[
                'id'=> 'MMR222',
                'country_id'=> '117',
                'name_eng' => 'Shan',
                'name_mm' => 'ရှမ်းပြည်နယ်',

                'remark'=>'Just for the whole Shan State'],

      );

      DB::table('address_states')->insert($result);
    }
}
