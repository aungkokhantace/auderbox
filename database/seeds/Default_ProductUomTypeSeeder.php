<?php
use Illuminate\Database\Seeder;

class Default_ProductUomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('product_uom_type')->truncate();
        $objs = array(
            ['id'=>1,'name_eng'=>'24 cans/ case','name_mm'=>'24 cans/ case','total_quantity'=>'24','remark'=>'','status'=>'1'],

        );
        DB::table('product_uom_type')->insert($objs);
    }
}
