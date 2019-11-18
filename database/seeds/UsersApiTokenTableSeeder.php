<?php

use Illuminate\Database\Seeder;

/**
    This Seeder is validated in case multiple times is called. It validates the record and catch the exceptions.
    Note:
        Exceptions are no validated.

    Model 3 will be used as selected option for the next seeders.
*/


class UsersApiTokenTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $updateApiUsers = DB::table('users')->whereNull('api_token')->update(array('api_token' => Str::random(60)));
    }

}


