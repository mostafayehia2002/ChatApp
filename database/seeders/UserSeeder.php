<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=[
            [
                'name'=>'mostafa',
                'email'=>'mostafa@gmail.com',
                'password'=>Hash::make('12345678'),
            ],  [
                'name'=>'mohamed',
                'email'=>'mohamed@gmail.com',
                'password'=>Hash::make('12345678'),
            ],[
            'name'=>'ahmed',
            'email'=>'ahmed@gmail.com',
            'password'=>Hash::make('12345678'),
        ],[
            'name'=>'ali',
            'email'=>'ali@gmail.com',
            'password'=>Hash::make('12345678'),
        ],[
            'name'=>'khaled',
            'email'=>'khaled@gmail.com',
            'password'=>Hash::make('12345678'),
        ]
        ];

        foreach ($users as $user) {
            User::create($user);
    }

    }
}
