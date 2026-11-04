<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Dilshod',
                'email' => 'dilshodshodiev09@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('dilshod2323'),
            ],
            [
                'name' => 'Barber Amak',
                'email' => 'barber@example.com',
                'role' => 'barber',
                'password' => Hash::make('password1'),
            ],
            [
                'name' => 'Client Alex',
                'email' => 'alex@example.com',
                'role' => 'client',
                'password' => Hash::make('password2'),
            ],
            [
                'name' => 'Client Anush',
                'email' => 'anush@example.com',
                'role' => 'client',
                'password' => Hash::make('password3'),
            ],
            [
                'name' => 'Client Ruziboy',
                'email' => 'ruziboy@example.com',
                'role' => 'client',
                'password' => Hash::make('password4'),
            ],

        ];
        foreach($users as $user){
            User::create($user);
        }
    }
}
