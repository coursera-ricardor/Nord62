<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
			Generic Permissions Definition
			Multiple sets of permissions.
			
				Web access rights
				System functionality rights 
		*/
		/*
			Web functionality
			Assigned to the User
				Each User has a Profile
		*/
		// Permission::create(['guard_name' => 'web', 'name' => 'system_manage']);
		Permission::create(['name' => 'system_manage']);
		Permission::create(['name' => 'users_manage']);
		Permission::create(['name' => 'browse']);
		
		/*
			System functionality (Multi-guard maybe will be discontinued)
			Assigned to the Profile
		*/
		// Permission::create(['guard_name' => 'users', 'name' => 'catalogs_admin']);
		Permission::create(['name' => 'catalogs_admin']);
		Permission::create(['name' => 'catalogs_browse']);
		Permission::create(['name' => 'catalogs_create']);
		Permission::create(['name' => 'catalogs_edit']);
		
		Permission::create(['name' => 'Countrycodes_admin']);
		Permission::create(['name' => 'Countrycodes_browse']);
		Permission::create(['name' => 'Countrycodes_create']);
		Permission::create(['name' => 'Countrycodes_edit']);
		
		Permission::create(['name' => 'Language_codes_admin']);
		Permission::create(['name' => 'Language_codes_browse']);
		Permission::create(['name' => 'Language_codes_create']);
		Permission::create(['name' => 'Language_codes_edit']);
    }
}
