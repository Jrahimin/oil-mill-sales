<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!User::first()){
            User::create([
                'name' => "admin",
                'email' => "admin@gmail.com",
                'email_verified_at' => now(),
                'mobile_no' => '01846999999',
                'type' => 1,
                'password' => bcrypt('12345'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
