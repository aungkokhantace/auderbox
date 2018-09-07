<?php
use Illuminate\Database\Seeder;

class Default_ProductGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('product_group')->truncate();
        $objs = array(
            ['id'=>1,'product_category_id'=>'1','brand_owner_id'=>'1','product_line_id'=>'1','name'=>'Coca-Cola','description'=>'A product of Coca-Cola Family','remark'=>'A product of Coca-Cola Family','status'=>'1','product_volume_type_id'=>'1','product_container_type_id'=>'1']

        );
        DB::table('product_group')->insert($objs);
    }
}
