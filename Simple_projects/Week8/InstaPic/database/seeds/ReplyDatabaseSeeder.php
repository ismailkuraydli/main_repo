<?php

use Illuminate\Database\Seeder;

use InstaPic\Reply;

class ReplyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Reply::class,300)->create();    
    }
}
