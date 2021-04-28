<?php

use Illuminate\Database\Seeder;

class VisitorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Visitor::class, 1)->create()->each(function ($user) {
            $user->answers()->saveMany(factory(App\Answer::class, 8)->make());
        });
    }
}
