<?php

use Illuminate\Database\Seeder;

use InstaPic\Directmessage;
class DirectmessageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Directmessage::class,40)->create();
    }
}
