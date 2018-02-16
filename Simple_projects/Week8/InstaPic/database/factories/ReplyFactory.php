<?php

use Faker\Generator as Faker;
use InstaPic\User;
use InstaPic\Comment;
use InstaPic\Reply;
$factory->define(Reply::class, function (Faker $faker) {
    return [
        'content'=> $faker->sentence,
        'user_id' => $faker->randomElement(User::pluck('id')->toArray()),
        'comment_id' => $faker->randomElement(Comment::pluck('id')->toArray()),
    ];
});
