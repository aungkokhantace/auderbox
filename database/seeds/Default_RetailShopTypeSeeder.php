<?php
use Illuminate\Database\Seeder;

class Default_RetailShopTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('retailshop_type')->truncate();
        $objs = array(
            ['id'=>1,'name'=>'On Premise','description'=>'On Premise Shop','remark'=>'','status'=>1],

        );
        DB::table('retailshop_type')->insert($objs);
    }
}
