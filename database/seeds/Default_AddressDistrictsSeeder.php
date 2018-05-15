<?php

use Illuminate\Database\Seeder;

class Default_AddressDistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('address_districts')->delete();

      $result = array(
        [
                'id'=> 'MMR017D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Hinthada',
                'name_mm' => 'ဟင်္သာတခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR017D004',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Labutta',
                'name_mm' => 'လပွတ္တာခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR017D005',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Maubin',
                'name_mm' => 'မအူပင်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR017D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Myaungmya',
                'name_mm' => 'မြောင်းမြခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR017D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Pathein',
                'name_mm' => 'ပုသိမ်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR017D006',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Pyapon',
                'name_mm' => 'ဖျာပုံခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR007D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Bago',
                'name_mm' => 'ပဲခူးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR007D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Taungoo',
                'name_mm' => 'တောင်ငူခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR008D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Pyay',
                'name_mm' => 'ပြည်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR008D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Thayarwady',
                'name_mm' => 'သာယာဝတီခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR004D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Falam',
                'name_mm' => 'ဖလန်းခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR004D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Hakha',
                'name_mm' => 'ဟားခါးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR004D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Mindat',
                'name_mm' => 'မင်းတပ်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR001D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Bhamo',
                'name_mm' => 'ဗန်းမော်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR001D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Mohnyin',
                'name_mm' => 'မိုးညှင်းခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR001D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Myitkyina',
                'name_mm' => 'မြစ်ကြီးနားခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR001D004',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Puta-O',
                'name_mm' => 'ပူတာအိုခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR002D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Bawlake',
                'name_mm' => 'ဘောလခဲခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR002D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Loikaw',
                'name_mm' => 'လွိုင်ကော်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR003D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Hpa-An',
                'name_mm' => 'ဘားအံခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR003D004',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Hpapun',
                'name_mm' => 'ဖာပွန်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR003D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Kawkareik',
                'name_mm' => 'ကော့ကရိတ်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR003D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Myawaddy',
                'name_mm' => 'မြဝတီခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR009D005',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Gangaw',
                'name_mm' => 'ဂန့်ဂေါခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR009D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Magway',
                'name_mm' => 'မကွေးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR009D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Minbu',
                'name_mm' => 'မင်းဘူးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR009D004',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Pakokku',
                'name_mm' => 'ပခုက္ကူခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR009D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Thayet',
                'name_mm' => 'သရက်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR010D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Kyaukse',
                'name_mm' => 'ကျောက်ဆည်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR010D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Mandalay',
                'name_mm' => 'မန္တလေးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR010D007',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Meiktila',
                'name_mm' => 'မိတ္ထီလာခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR010D004',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Myingyan',
                'name_mm' => 'မြင်းခြံခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR010D005',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Nyaung-U',
                'name_mm' => 'ညောင်ဦးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR010D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Pyinoolwin',
                'name_mm' => 'ပြင်ဦးလွင်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR010D006',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Yamethin',
                'name_mm' => 'ရမည်းသင်းခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR011D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Mawlamyine',
                'name_mm' => 'မော်လမြိုင်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR011D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Thaton',
                'name_mm' => 'သထုံခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR018D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Det Khi Na',
                'name_mm' => 'ဒက္ခိဏခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR018D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Oke Ta Ra',
                'name_mm' => 'ဥတ္တရခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR012D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Kyaukpyu',
                'name_mm' => 'ကျောက်ဖြူခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR012D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Maungdaw',
                'name_mm' => 'မောင်တောခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR012D005',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Mrauk-U',
                'name_mm' => 'မြောက်ဦးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR012D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Sittwe',
                'name_mm' => 'စစ်တွေခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR012D004',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Thandwe',
                'name_mm' => 'သံတွဲခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR005D008',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Hkamti',
                'name_mm' => 'ခန္တီးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR005D005',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Kale',
                'name_mm' => 'ကလေးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR005D010',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Kanbalu',
                'name_mm' => 'ကန့်ဘလူခရိုင်',

                'remark'=>'New District formed with government notification issued on March 2015'],
[
                'id'=> 'MMR005D004',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Katha',
                'name_mm' => 'ကသာခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR005D007',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Mawlaik',
                'name_mm' => 'မော်လိုက်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR005D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Monywa',
                'name_mm' => 'မုံရွာခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR005D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Sagaing',
                'name_mm' => 'စစ်ကိုင်းခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR005D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Shwebo',
                'name_mm' => 'ရွှေဘိုခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR005D006',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Tamu',
                'name_mm' => 'တမူးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR005D009',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Yinmarbin',
                'name_mm' => 'ယင်းမာပင်ခရိုင်',

                'remark'=>'New District formed with government notification issued on June 2013'],
[
                'id'=> 'MMR016D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Kengtung',
                'name_mm' => 'ကျိုင်းတုံခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR016D333',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Mong Pawk (Wa SAD)',
                'name_mm' => 'မိုင်းပေါက်-ဝအထူးဒေသ (၂)',

                'remark'=>''],
[
                'id'=> 'MMR016D004',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Monghpyak',
                'name_mm' => 'မိုင်းဖြတ်ခရိုင်',

                'remark'=>'Deleted, GAD notification issued on Nov 2014'],
[
                'id'=> 'MMR016D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Monghsat',
                'name_mm' => 'မိုင်းဆတ်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR016D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Tachileik',
                'name_mm' => 'တာချီလိတ်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR015D006',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Hopang',
                'name_mm' => 'ဟိုပန်ခရိုင်',

                'remark'=>'New District formed with government notification issued on August 2011'],
[
                'id'=> 'MMR015D004',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Kunlong',
                'name_mm' => 'ကွမ်းလုံခရိုင်',

                'remark'=>'Deleted, GAD notification issued on Jan 2014'],
[
                'id'=> 'MMR015D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Kyaukme',
                'name_mm' => 'ကျောက်မဲခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR015D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Lashio',
                'name_mm' => 'လားရှိုးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR015D005',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Laukkaing',
                'name_mm' => 'လောက်ကိုင်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR015D221',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Laukkaing (Kokang SAZ)',
                'name_mm' => 'လောက်ကိုင်-ကိုးကန့်အထူးဒေသ (၁)',

                'remark'=>''],
[
                'id'=> 'MMR015D007',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Matman',
                'name_mm' => 'မက်မန်းခရိုင်',

                'remark'=>'New District formed with government notification issued on Jan 2013'],
[
                'id'=> 'MMR015D331',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Mong Maw (Wa SAD)',
                'name_mm' => 'မိုင်းမော-ဝအထူးဒေသ (၂)',

                'remark'=>''],
[
                'id'=> 'MMR015D008',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Mongmit',
                'name_mm' => 'မိုးမိတ်ခရိုင်',

                'remark'=>'New District formed with government notification issued on Jan 2014'],
[
                'id'=> 'MMR015D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Muse',
                'name_mm' => 'မူဆယ်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR015D332',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Wein Kawng (Wein Kao) (Wa SAD)',
                'name_mm' => 'ဝိန်းကောင်-ဝအထူးဒေသ (၂)',

                'remark'=>''],
[
                'id'=> 'MMR014D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Langkho',
                'name_mm' => 'လင်းခေးရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR014D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Loilen',
                'name_mm' => 'လွိုင်လင်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR014D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Taunggyi',
                'name_mm' => 'တောင်ကြီးခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR006D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Dawei',
                'name_mm' => 'ထားဝယ်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR006D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Kawthoung',
                'name_mm' => 'ကော့သောင်းခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR006D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Myeik',
                'name_mm' => 'မြိတ်ခရိုင်',

                'remark'=>''],
[
                'id'=> 'MMR013D002',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Yangon (East)',
                'name_mm' => 'ရန်ကုန်(အရှေ့ပိုင်း)',

                'remark'=>''],
[
                'id'=> 'MMR013D001',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Yangon (North)',
                'name_mm' => 'ရန်ကုန်(မြောက်ပိုင်း)',

                'remark'=>''],
[
                'id'=> 'MMR013D003',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Yangon (South)',
                'name_mm' => 'ရန်ကုန်(တောင်ပိုင်း)',

                'remark'=>''],
[
                'id'=> 'MMR013D004',
                'country_id'=> '117',
                'address_state_id'=>'sr_pcode',
                'name_eng' => 'Yangon (West)',
                'name_mm' => 'ရန်ကုန်(အနောက်ပိုင်း)',

                'remark'=>''],
      );

      DB::table('address_districts')->insert($result);
    }
}
