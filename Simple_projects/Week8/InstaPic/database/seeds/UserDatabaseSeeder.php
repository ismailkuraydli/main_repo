<?php

use Illuminate\Database\Seeder;

use InstaPic\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class,4)->create();
    }
}
