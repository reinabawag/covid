<?php

use Illuminate\Database\Seeder;
use App\Question;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Question::create([
            'title' => 'Are you experiencing (Nakakaranas ka ba ng)',
            'question' => 'Fever (Lagnat)',
        ]);

        Question::create([
            'question' => 'Cough and/or cold (Ubo at/o sipon)',
        ]);

        Question::create([
            'question' => 'Body pains (Pananakit ng katawan)',
        ]);

        Question::create([
            'question' => 'Sore throat (Pananakit ng lalamunan/masakit lumonok)',
        ]);

        Question::create([
            'question' => 'Have you had face-to-face contact with a probable or confirmed COVID-19 case within 1 meter and for the more than 15 minutes for the past 14 days? (May nakasalamuha ka ba ng probable o kumpirmadong pasyente na may COVID-19 mula sa isang metrong distansya or mas malapit pa ng mahigit 15 minuto sa makalipas na 14 araw?)',
        ]);

        Question::create([
            'question' => 'Have you provided direct care for a patient with probable or confirmed COVID-19 case without using proper personal protective equipment for the past 14 days? (Nag-alaga ka ba ng probable o kumpirmadong pasyente na may COVID-19 ng hindi nakasuot ng tamang personal protective equipment sa nakalipas na 14 araw?)',
        ]);

        Question::create([
            'question' => 'Have you travelled outside the Philippines in the last 14 days? (Ikaw ba ay nagbyahe sa labas ng Pilipinas sa makalipas na 14 na araw?)',
        ]);

        Question::create([
            'question' => 'Have you travelled outside in the current city/municipality where you reside? (Ikaw ba ay nagbyahe sa labas ng iyong lungsod/munisipyo?) If yes, specify which city/municipality you went to (Sabihin kung saan)',
            'is_additional' => TRUE
        ]);
    }
}
