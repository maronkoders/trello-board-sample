<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => "Brian Thomas",
            'email' => "bthighforce@gmail.com",
            "password" => Hash::make('bthighforce@gmail.com'),
        ]);
    }
}
