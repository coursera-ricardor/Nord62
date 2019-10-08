<?php

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::whereIn('status',['A','P'])->get();

        $Records = [];

        foreach ($users as $user) {
            echo 'Processing ' . $user->name . "\n";

            $Roles = [];
            switch ($user->status) {
                case "P":
                    $Roles[] = ['Administrator','User Administrator','User','Guest'];
                    break;
                case "A":
                    $Roles[] = ['User','Guest'];
                    break;
                default:
                    $Roles = ['Guest'];
            }

            $Records[] = 
                [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $user->status,
                    'owner_id' => 1,
                    'updated_id' => 1,
                    'roles' => $Roles,
                ];
        } // end foreach

        //
        // Profiles Creation
        //
        $this->createRecordClass(App\Profile::class, $Records,['roles']);

    } // end Run

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
            echo 'Creating record for: ' . $dbRecord['name'] . "\n";

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
                    echo "To process: " . $newRecord->id  . ' ' . $dbRecord['name'] . "\n";

                    foreach ($dbDetailRecords as $dbDetailRecord) {
                        echo $dbDetailRecord;
                        if ( isset($dbRecord[$dbDetailRecord]) ) {
                            // var_dump($dbRecord[$dbDetailRecord]);

                            foreach ($dbRecord[$dbDetailRecord] as $dbDetail) {
                                echo " Assigning: " . $dbDetail[0] . "\n";

                                try {
                                    //
                                    // Method defined in  Traits\HasPermissions.php in the case of Spatie/Permissions
                                    // $newRecord->givePermissionTo($dbDetail);
                                    $newRecord->assignRole($dbDetail);
                                    //
                                } catch ( Exception $ex) {
                                    echo $ex->getMessage() . "\n";
                                }

                            }

                        }                
                    }
                }
            } // end try

        } // end foreach
    } // endFunction



}
