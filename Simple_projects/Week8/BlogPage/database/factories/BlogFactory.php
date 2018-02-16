<?php
use OpenBook\Blog;
use Faker\Generator as Faker;

$factory->define(OpenBook\Blog::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(),
        'description' => $faker->paragraph(3),
    ];
});
