<?php
use Illuminate\Database\Seeder;

class Default_ProductVolumeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('product_volume_type')->truncate();
        $objs = array(
            ['id'=>1,'name'=>'330 ml','remark'=>'','status'=>'1'],

        );
        DB::table('product_volume_type')->insert($objs);
    }
}
