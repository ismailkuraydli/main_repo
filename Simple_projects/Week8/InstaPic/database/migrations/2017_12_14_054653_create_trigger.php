<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    // /**
    //  * Run the migrations.
    //  *
    //  * @return void
    //  */
    // public function up()
    // {
    //     DB::unprepared('
    //     CREATE TRIGGER after_insert_inc_follow AFTER INSERT ON `follows` FOR EACH ROW
    //         BEGIN
    //             UPDATE INTO role_user (`role_id`, `user_id`, `created_at`, `updated_at`) 
    //             VALUES (3, NEW.id, now(), null);
    //         END
    //     ');
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     DB::unprepared('DROP TRIGGER `tr_User_Default_Member_Role`');
    // }

    // CREATE TRIGGER 'database_name'.'after_insert_enrollment' AFTER INSERT ON 'ENROLLMENT' 
    // FOR EACH ROW
    // BEGIN
    // UPDATE class SET NO_OF_STUDENTS = NO_OF_STUDENTS +1 where CLASS_NO = NEW.CLASS_NO;
    // END
}
