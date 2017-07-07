<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Voter::class, function (Faker\Generator $faker) {
    return [
        'SID' => $faker->unique()->dni,
        'SMS_phone' => '',
        'SMS_verified' => 0,
        'SMS_time' => null,
        'ballot_cast' => 0,
        'ballot_time' => null,
        'signature' => '',
        'in_person' => null,
        'by_user' => null,
        'ip_address' => '',
        'user_agent' => ''
    ];
});
