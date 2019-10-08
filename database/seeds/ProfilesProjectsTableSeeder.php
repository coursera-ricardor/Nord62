<?php

use Illuminate\Database\Seeder;

class ProfilesProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Records = [];

        /*
         * Add The records
         *
        */
        $Records[] = 
            [
                'project_id' => 1,
                'profile_id' => 1,
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
                // 'roles' => ['System Administrator'],

            ];
        $Records[] = 
            [
                'project_id' => 1,
                'profile_id' => 2,
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
                // 'roles' => ['System Administrator', 'System User'],
            ];
        $Records[] = 
            [
                'project_id' => 1,
                'profile_id' => 4,
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
                // 'roles' => ['System Administrator', 'System User','System Tester User'],
            ];
        $Records[] = 
            [
                'project_id' => 2,
                'profile_id' => 1,
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
            ];
        // Duplicated Record Test
        $Records[] = 
            [
                'project_id' => 2,
                'profile_id' => 1,
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
            ];
        $Records[] = 
            [
                'project_id' => 2,
                'profile_id' => 2,
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
            ];
        $Records[] = 
            [
                'project_id' => 3,
                'profile_id' => 1,
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
            ];

        //
        // ProjectsProfiles Creation
        //
        $this->createRecordClass(App\ProfileProject::class, $Records,['roles']);


    } // end run function

    /**
     * Record Creation using an array with the information.
     * The information could be uploaded from other sources
     * Note:
     *      This function is NOT recursive, Details of Detail records are NOT processed.
     *      i.e: user->Role->Permissions
     *      The function wil Process structure like
     *      roles->permissions
     *      user->shipAddress (Not applicable to this Seeder)
     *
     * @param  class  $dbModel
     * @param  array  $dbRecords
     * @param  array  $dbDetailRecords
    */
    private function createRecordClass( $dbModel, $dbRecords, $dbDetailRecords = []) {
        foreach ($dbRecords as $dbRecord) {
            // var_dump($dbRecord);
            echo 'Creating record: ' . "\n";

            /*
                Version Create - Find
            */
            try {

                $newRecord = $dbModel::create(collect($dbRecord)->except($dbDetailRecords)->toArray());

            } catch (Exceptions $ex) {
                echo $ex->getMessage();
                // dd(var_dump($newModel));
            }
            catch (Exception $ex) {
                echo $ex->getMessage() . "\n";
            } finally {

                // dd(var_dump($newModel));
                /*
                 * Process Detail Records set of Permissions
                 *  External relation
                */
                if (isset($newRecord)) {
                    // dd(var_dump($newRecord));
                    echo "To process: " . $newRecord->id  . "\n";

                    foreach ($dbDetailRecords as $dbDetailRecord) {
                        echo var_dump($dbDetailRecord);
                        if ( isset($dbRecord[$dbDetailRecord]) ) {
                            // var_dump($dbRecord[$dbDetailRecord]);

                            foreach ($dbRecord[$dbDetailRecord] as $dbDetail) {
                                echo "Assigning: " . $dbDetail . "\n";

                                try {
                                    //
                                    // Method defined in  Traits\HasPermissions.php in the case of Spatie/Permissions
                                    // $newRecord->givePermissionTo($dbDetail);
                                    //
                                    // $newPivotRecord->givePermissionTo('browse');
                                } catch ( Exception $ex) {
                                    echo $ex->getMessage() . "\n";
                                }

                            }

                        }                
                    }
                }
            }


        }
    } // endFunction

}
