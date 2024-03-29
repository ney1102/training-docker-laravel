<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use DB;
use Str;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 25; $i < 200; $i++) {
            $tell = rand(0, 1) ? '1234567899' : '9876543210';
            $is_active = rand(0, 1) ? 1 : 0;
            $adddress = rand(0, 1) ? '394 Ung Văn Khiêm, Phường 25, Quận Bình Thạnh, TP.HCM' : '132 Hàm Nghi, Quận 1, TP.HCM';										
											
											
            DB::table('mst_product')->insert([
                'product_name' => 'Product '. Str::random(3).' ' . ($i + 1),
                'product_image' => '',
                'product_price' => rand(0, 1000),
                'is_sales' => rand(0, 1),
                'description' =>'Product '. Str::random(40).' ' .Str::random(70) ,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
