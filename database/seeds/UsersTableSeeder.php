<?php

use Illuminate\Database\Seeder;

use App\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
			System Administrator
		*/
		$user = User::create([
            'username' => 'Admin',
            'name' => 'System Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
			'status' => 'P', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
        ]);

        /*
			User Example
		*/
		$user = User::create([
            'username' => 'User',
            'name' => 'System User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
			'status' => 'A',
        ]);

    }
}
