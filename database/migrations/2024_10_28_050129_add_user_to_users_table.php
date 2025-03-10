<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AddUserToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Insert a new user with username 'shinji', encrypted password, and is_admin set to 1
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally remove the user if you need to roll back the migration
        DB::table('users')->where('username', 'shinji')->delete();
    }
}
