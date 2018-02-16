<?php

use Faker\Generator as Faker;
use InstaPic\Comment;
use InstaPic\User;
use InstaPic\Post;
$factory->define(Comment::class, function (Faker $faker) {
    $content = $faker->sentence;
    $userId = $faker->randomElement(User::pluck('id')->toArray());
    $postId = $faker->randomElement(Post::pluck('id')->toArray());
    $comment = new Comment;
    $comment->addComment($userId,$postId, $content);
    return [];
});
