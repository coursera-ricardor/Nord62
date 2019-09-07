<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
			Web Roles
		*/
		// $role = Role::create(['guard_name' => 'web', 'name' => 'administrator']);
        if ( ! Role::whereName('Administrator')->exists()) {
    		Role::create(['name' => 'Administrator']);    
        }
        $role->givePermissionTo('browse');
        $role->givePermissionTo('catalogs_browse');
        $role->givePermissionTo('catalogs_admin');
        $role->givePermissionTo('users_manage');

		// $role = Role::create(['guard_name' => 'web','name' => 'user']);
		$role = Role::create(['name' => 'user']);
        $role->givePermissionTo('browse');
        $role->givePermissionTo('catalogs_browse');

		// $role = Role::create(['guard_name' => 'web', 'name' => 'guest']);
		$role = Role::create(['name' => 'guest']);
        $role->givePermissionTo('browse');
		
		/*
			System Roles
		*/
		// $role = Role::create(['guard_name' => 'users','name' => 'administrator']);
		$role = Role::create(['name' => 'User Administrator']);
        $role->givePermissionTo('catalogs_admin');
        $role->givePermissionTo('users_manage');
        $role->givePermissionTo('browse');

    }
}
