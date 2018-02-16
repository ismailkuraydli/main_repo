<?php

use Illuminate\Database\Seeder;

use InstaPic\Post;
class PostDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class,40)->create();
    }
}
