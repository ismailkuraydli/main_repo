<?php

use Illuminate\Database\Seeder;

use InstaPic\Like;
class LikeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Like::class,40)->make();
    }
}
