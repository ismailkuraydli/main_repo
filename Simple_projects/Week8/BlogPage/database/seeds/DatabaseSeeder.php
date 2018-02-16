<?php

use Illuminate\Database\Seeder;
use OpenBook\User;
use OpenBook\Blog;
use OpenBook\Blogpost;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        $faker = Faker::create();

        for($i = 0; $i<50; $i++) {
            $user = \OpenBook\User::create([
                'id'=> null,
                'name'=> $faker->name,
                'email'=> $faker->unique()->safeEmail,
                'password'=> bcrypt('secret'),
            ]);
            $userId = $user->id;
            for($j = 0; $j < 5; $j++) {
                $blog = \OpenBook\Blog::create([
                    'user_id' => $userId,
                    'name' => $faker->word(),
                    'description' => $faker->paragraph(3),
                ]);
                $blogId = $blog->id;
                for($k = 0; $k<5; $k++) {
                    $post = \OpenBook\Blogpost::create([
                        'blog_id' => $blogId,
                        'title' => $faker->sentence(),
                        'body' => $faker->paragraph(10),
                        'image' => $faker->imageUrl($width = 640,$height = 480),
                        'tags' => $faker->word(),
                    ]);
                }    
            }
        }
        
    }
}
