<?php
use Illuminate\Database\Seeder;

class Default_ProductLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('product_lines')->truncate();
        $objs = array(
            ['id'=>1,'brand_owner_id'=>'1','name'=>'Coca-Cola','image'=>'/images/productline_images/coca-cola-logo-260x260.png','description'=>'','remark'=>'','status'=>'1']

        );
        DB::table('product_lines')->insert($objs);
    }
}
