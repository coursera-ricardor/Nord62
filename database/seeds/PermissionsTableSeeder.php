<?php

use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Permission;

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
        $Table = 'permissions';
        $Records = [];

		/*
			Web functionality
			Assigned to the User
				Each User has a Profile
		*/
		// Permission::create(['guard_name' => 'web', 'name' => 'system_manage']);
		// Permission::create(['name' => 'system_manage']);
        $Records[] = ['name' => 'users_manage', 'description' => 'Manage Users']; 
		$Records[] = ['name' => 'browse','guard_name' => 'web'];
		
		/*
			System functionality (Multi-guard maybe will be discontinued)
			Assigned to the Profile
		*/
		// Permission::create(['guard_name' => 'users', 'name' => 'catalogs_admin']);
		$Records[] = ['name' => 'catalogs_admin'];
		$Records[] = ['name' => 'catalogs_browse'];
		$Records[] = ['name' => 'catalogs_create'];
		$Records[] = ['name' => 'catalogs_edit'];
		
		$Records[] = ['name' => 'Countrycodes_admin'];
		$Records[] = ['name' => 'Countrycodes_browse'];
		$Records[] = ['name' => 'Countrycodes_create'];
		$Records[] = ['name' => 'Countrycodes_edit'];
		
		$Records[] = ['name' => 'Language_codes_admin'];
		$Records[] = ['name' => 'Language_codes_browse'];
		$Records[] = ['name' => 'Language_codes_create'];
		$Records[] = ['name' => 'Language_codes_edit'];

        // Create the records
        //  Note: If the record exists or it is a problem with the creation, the seeder won't fail.
        //      In debug mode uncomment the error message echo
        $this->createRecordClass(Spatie\Permission\Models\Permission::class, $Records);

    }

    /**
     * Record Creation using an array with the information.
     * The information could be uploaded from other sources
     *
     * @param  class  $dbModel
     * @param  array  $dbRecords
    */
    private function createRecordClass( $dbModel, $dbRecords) {
        foreach ($dbRecords as $dbRecord) {
            try {
                $dbModel::create($dbRecord);
            }
            // @todo: Include the QueryException to allow to continue the excecution
            catch ( \Illuminate\Database\QueryException $ex) {
                // echo $ex->getMessage();
            }
            catch ( Spatie\Permission\Exceptions\PermissionAlreadyExists $ex) {
                // echo $ex->getMessage();
                
            }
        }
    
    }

}
