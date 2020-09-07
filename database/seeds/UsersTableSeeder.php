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
            'name' => 'Reinhard Abawag',
            'email' => 'reinabawag@gmail.com',
            'password' => Hash::make('reinadmin'),
            'remember_token' => Str::random(10),
            'api_token' => Str::random(80),
        ]);
    }
}
