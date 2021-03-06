<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsernameToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add the field
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('name')->nullable();
            $table->string('status',1)->default('C')->after('password'); // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
        });

        /*
         * Transfer the email as username if username is empty.
         * @todo: Username Change to be implemented.
        */
        $usersRows = DB::table('users')->whereNull('username')->get(['id','email']);

        foreach ($usersRows as $userRow) {
            DB::table('users')->where('id',$userRow->id)->update(['username' => $userRow->email]);
        }

        /*
            username Index creation
            email index drop to allow the use of the same email in several accounts
        */
        Schema::table('users', function (Blueprint $table) {
            // Change the field to not nullable
            $table->string('username')->nullable(false)->change();

            // Create the user_name index
            $table->unique('username');

            // Drop unique index on email
            $table->dropUnique('users_email_unique');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the Index
            $table->dropUnique('users_username_unique');

            // recreate the previous index
            $table->unique('email');
        });

        Schema::table('users', function (Blueprint $table) {

            // Drop Columns
            $table->dropColumn(['username','status']);
        });
    }

}
