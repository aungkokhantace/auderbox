<?php
use Illuminate\Database\Seeder;

class Default_ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('products')->truncate();
        $objs = array(
            ['id'=>1,'product_group_id'=>'1','product_uom_type_id'=>'1','image'=>'/images/product_images/Coca Cola (250 ml) x 24.png','sku'=>'COCA-COLA-000001','remark'=>'A product of Coca-Cola Family','status'=>'1']

        );
        DB::table('products')->insert($objs);
    }
}
