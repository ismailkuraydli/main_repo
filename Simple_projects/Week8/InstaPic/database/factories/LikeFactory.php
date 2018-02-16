<?php

use Faker\Generator as Faker;

use InstaPic\User;
use InstaPic\Post;
use InstaPic\Like;

$factory->define(Like::class, function (Faker $faker) {
    $userId = $faker->randomElement(User::pluck('id')->toArray());
    $postId = $faker->randomElement(Post::pluck('id')->toArray());
    $like = new Like;
    $like->likePost($userId,$postId);
    return [];
});
