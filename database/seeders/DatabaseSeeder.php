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
        User::create([
            'username' => 'admin',
            'password' => 'admin_888'
        ]);

//        if (app()->isLocal()) {
//            $this->call([
//                UserSeeder::class,
//                RoleSeeder::class
//            ]);
//        }
    }
}
