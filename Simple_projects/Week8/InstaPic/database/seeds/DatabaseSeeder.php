<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserDatabaseSeeder::class);
        $this->call(PostDatabaseSeeder::class);
        $this->call(FollowDatabaseSeeder::class);
        $this->call(CommentDatabaseSeeder::class);
        $this->call(LikeDatabaseSeeder::class);
        $this->call(DirectmessageDatabaseSeeder::class);
        $this->call(ReplyDatabaseSeeder::class);        
    }
}
