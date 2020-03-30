<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersApiTokenTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // This query will update ALL the users with the same Token
        // $updateApiUsers = DB::table('users')->whereNull('api_token')->update(array('api_token' => Str::random(60)));
        $updateApiUsers = User::whereNull('api_token')->get();

        foreach($updateApiUsers as $updateApiUser) {
            $updateApiUser->api_token = Str::random(60);
            $updateApiUser->save();
        }
    }

}


