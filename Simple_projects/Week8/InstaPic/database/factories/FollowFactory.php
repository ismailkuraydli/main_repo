<?php

use Faker\Generator as Faker;

use InstaPic\User;
use InstaPic\Follow;

$factory->define(Follow::class, function (Faker $faker) {
    $userId = $faker->randomElement(User::pluck('id')->toArray());
    $followedId = $faker->randomElement(User::pluck('id')->toArray());
    $follow = new Follow;
    $follow->follow($userId,$followedId);
    return[];
});
