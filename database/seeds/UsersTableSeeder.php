<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@amwire.com.ph',
            'password' => Hash::make('misadmin'),
            'remember_token' => Str::random(10),
            'api_token' => Str::random(80),
        ]);

        User::create([
            'name' => 'Cori Ong',
            'email' => 'sr.ong_hrd@amwire.com.ph',
            'password' => Hash::make('hradmin'),
            'remember_token' => Str::random(10),
            'api_token' => Str::random(80),
        ]);
    }
}
