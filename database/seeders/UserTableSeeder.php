<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'foto' => '/img/admin.png',
                'level' => 0
            ],
            [
                'name' => 'Kasir 1',
                'email' => 'kasir1@gmail.com',
                'password' => bcrypt('12345678'),
                'foto' => '/img/kasir1.png',
                'level' => 2
            ]
        );

        array_map(function (array $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }, $users);
    }
}
