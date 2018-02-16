<?php

use Illuminate\Database\Seeder;

use InstaPic\Follow;
class FollowDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Follow::class,40)->make();
    }
}
