<?php
use Illuminate\Database\Seeder;

class Default_ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('product_category')->truncate();
        $objs = array(
            ['id'=>1,'name'=>'Drinks','remark'=>'Drinks','status'=>'1'],

        );
        DB::table('product_category')->insert($objs);
    }
}
