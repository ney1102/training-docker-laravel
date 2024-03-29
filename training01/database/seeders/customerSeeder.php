<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Str;
class customerSeeder extends Seeder
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
											
											
            DB::table('mst_customer')->insert([
                'customer_name' => 'Customer.'. Str::random(2).' ' . ($i + 1),
                'email' => 'Customer.'. Str::random(2) . ($i + 1) . '@example.com',
                'tel_num' => $tell,
                'is_active' => $is_active,
                'address' => $adddress,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
