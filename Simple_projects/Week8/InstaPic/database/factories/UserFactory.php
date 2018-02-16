<?php

use Faker\Generator as Faker;

use InstaPic\User;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'displayname' => $faker->unique()->firstName,
        'avatar' => $faker->imageURL(640,480),
        'bio' => $faker->paragraph($nbSentences = 1),
        'cover' => $faker->imageURL(640,480),
        'website' => $faker->domainName,
        'gender' => 'Binary',
        'mobile' => $faker->unique()->randomNumber($nbDigits = 5),
        'remember_token' => str_random(10),
    ];
});
