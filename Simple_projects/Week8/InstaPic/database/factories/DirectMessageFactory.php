<?php

use Faker\Generator as Faker;

use InstaPic\User;
use InstaPic\Directmessage;

$factory->define(Directmessage::class, function (Faker $faker) {
    return [
        'content'=> $faker->sentence,
        'sender_id' => $faker->randomElement(User::pluck('id')->toArray()),
        'reciever_id' => $faker->randomElement(User::pluck('id')->toArray()),
    ];
});
