<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use DB;
use Str;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 25; $i < 120; $i++) {
            $groupRole = rand(0, 1) ? 'editor' : 'reviewer';
            $is_active = rand(0, 1) ? '0' : '1';
            DB::table('mst_users')->insert([
                'name' => 'User ' . ($i + 1),
                'email' => 'user' . ($i + 1) . '@example.com',
                'verify_email' => '',
                'is_active' => $is_active,
                'is_delete' => 0,
                'group_role' => $groupRole,
                'last_login_at' => now(),
                'last_login_ip' => '192.168.1.1',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
