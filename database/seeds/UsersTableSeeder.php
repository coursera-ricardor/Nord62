<?php

use Illuminate\Database\Seeder;

// use App\User;

/**
    This Seeder is validated in case multiple times is called. It validates the record and catch the exceptions.
    Note:
        Exceptions are no validated.

    Model 3 will be used as selected option for the next seeders.
*/
class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Table = 'users';
        $Records = [];

        /*
         * Add The records
         *
        */
        $Records[] = 
            [
                'username' => 'Admin',
                'name' => 'System Administrator',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
			    'status' => 'P', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
            ];
        $Records[] = 
            [
                'username' => 'User',
                'name' => 'System User',
                'email' => 'user@user.com',
                'password' => bcrypt('password'),
			    'status' => 'A',
            ];
        $Records[] = 
            [
                'username' => 'Guest',
                'name' => 'Guest User',
                'email' => 'guest@user.com',
                'password' => bcrypt('password'),
			    'status' => 'A',
            ];
        $Records[] = 
            [
                'username' => 'Tester',
                'name' => 'System Tester User',
                'email' => 'user@user.com',
                'password' => bcrypt('password'),
			    'status' => 'C',
            ];
        $Records[] = 
            [
                'username' => 'Master',
                'name' => 'Master System User',
                'email' => 'user@user.com',
                'password' => bcrypt('password'),
			    'status' => 'A',
            ];


        //
        // Call the function
        //
        // Option 1
        // $this->createRecord1($Table,$Records);
        //
        // Option 2
        // $this->createRecord2($Records);
        //
        // Option 3
        $this->createRecordClass(App\User::class, $Records);


        /*
            Option 0
			System Administrator
		*/
        /*
		$user = User::create([
            'username' => 'Admin',
            'name' => 'System Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
			'status' => 'P', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
        ]);
        */
        /*
            Option 0
			User Example
		*/
        /*
		$user = User::create([
            'username' => 'User',
            'name' => 'System User',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
			'status' => 'A',
        ]);
        */
    }

    // Option 1
    private function createRecord1( $dbTable, $dbRecords) {
        foreach ($dbRecords as $dbRecord) {
            try {
                DB::table($dbTable)->insert($dbRecord);  // This does not update time stamps
            }
            // @todo: Include the QueryException to allow to continue the excecution
            catch (\Illuminate\Database\QueryException $ex) {
                echo $ex->getMessage();
            }
        }
    
    }

    // Option 2
    private function createRecord2( $dbRecords) {
        foreach ($dbRecords as $dbRecord) {
            try {
                // Option 1
                // DB::table($dbTable)->insert($dbRecord);  // This does not update time stamps

                // Option 2
                App\User::create($dbRecord);
            }
            // @todo: Include the QueryException to allow to continue the excecution
            catch (\Illuminate\Database\QueryException $ex) {
                echo $ex->getMessage();
            }
        }
    
    }

    // Option 3
    private function createRecordClass( $dbModel, $dbRecords) {
        foreach ($dbRecords as $dbRecord) {
            try {
                $newRecord = $dbModel::create($dbRecord);

                /*
                 * Adding the owner_id to the record.
                 *  Note: Activate only if the fields exist in the table
                */
                /*
                $newRecord->owner_id = $newRecord->id;
                $newRecord->updated_by = $newRecord->id;
                $newRecord->save();
                */
            }
            // @todo: Include the QueryException to allow to continue the excecution
            catch (\Illuminate\Database\QueryException $ex) {
                echo $ex->getMessage();
            }
        }
    
    }


}


