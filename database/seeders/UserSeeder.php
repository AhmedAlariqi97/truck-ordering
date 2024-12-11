<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => 'Ahmed',
            'email' => 'ahmedalariqi97@gmail.com',
            'password' => bcrypt('A12345678!?'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $user->addRole('admin');
        $user = User::create([
            'name' => 'truck order',
            'email' => 'truckorder@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $user->addRole('client');
    }
}
