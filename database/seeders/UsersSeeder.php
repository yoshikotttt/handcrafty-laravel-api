<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ユーザーを3人作成
        $users = [
            [
                'name' => 'neko',
                'email' => 'neko@gmail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'hachi',
                'email' => 'hachi@gmail.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'usagi',
                'email' => 'usagi@gmail.com',
                'password' => Hash::make('12345678'),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
