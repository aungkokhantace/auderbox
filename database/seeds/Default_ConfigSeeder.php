<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 2:18 PM
 */
use Illuminate\Database\Seeder;

class Default_ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_configs')->delete();

        $roles = array(
            ['code'=>'SETTING_COMPANY_NAME', 'type'=>'SETTING', 'value'=>'AcePlus Backend','description'=>'Company Name'],
            ['code'=>'SETTING_LOGO', 'type'=>'SETTING', 'value'=>'/images/logo.jpg','description'=>'Company Logo'],
            ['code'=>'SETTING_SITE_ACTIVATION_KEY', 'type'=>'SETTING', 'value'=>'1234567','description'=>'Site Activation Key'],
            ['code'=>'INVOICE_ID_PREFIX', 'type'=>'SETTING', 'value'=>'INV','description'=>'Default Prefix Id'],

        );

        DB::table('core_configs')->insert($roles);
    }
}
