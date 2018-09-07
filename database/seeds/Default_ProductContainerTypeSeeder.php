<?php
use Illuminate\Database\Seeder;

class Default_ProductContainerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('product_container_type')->truncate();
        $objs = array(
            ['id'=>1,'name'=>'Plastic','remark'=>'','status'=>'1'],

        );
        DB::table('product_container_type')->insert($objs);
    }
}
