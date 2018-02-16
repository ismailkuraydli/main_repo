<?php

use Illuminate\Database\Seeder;

use InstaPic\Comment;
class CommentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Comment::class, 70)->make();
    }
}
