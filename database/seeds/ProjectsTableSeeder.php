<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Table = 'projects';
        $Records = [];

        /*
         * Add The records
         *
        */
        $Records[] = 
            [
                'name' => 'Course A',
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
            ];
        $Records[] = 
            [
                'name' => 'Course B',
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
            ];
        $Records[] = 
            [
                'name' => 'Course C',
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
            ];
        $Records[] = 
            [
                'name' => 'Course D',
			    'status' => 'A', // A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                'owner_id' => 1,
                'updated_id' => 1,
            ];

        //
        // Projects Creation
        //
        $this->createRecordClass(App\Project::class, $Records,['profiles']);

    }

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
            echo 'Nombre: ' . $dbRecord["name"]  . "\n";

            /*
                Version Create - Find
            */
            try {

                $newRecord = $dbModel::create(collect($dbRecord)->except($dbDetailRecords)->toArray());

            } catch (Exceptions $ex) {
                echo $ex->getMessage();
                $newRecord = $dbModel::findByName($dbRecord["name"]);
                // dd(var_dump($newModel));
            }
            catch (Exception $ex) {
                echo $ex->getMessage() . "\n";
            }

        }
    } // endFunction


}
