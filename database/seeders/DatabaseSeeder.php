<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (app()->isLocal()) {
            $this->call([
                UserSeeder::class,
                RoleSeeder::class
            ]);
        } else {
            // 创建 admin 用户
            User::create([
                'username' => 'admin',
                'password' => 'admin_888'
            ]);
        }
    }
}
