<?php

use Faker\Generator as Faker;

use InstaPic\Post;
use InstaPic\User;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'image' => $faker->imageURL(640,480),
        'caption' => $faker->sentence,
        'user_id' => $faker->randomElement(User::pluck('id')->toArray())
    ];
});
