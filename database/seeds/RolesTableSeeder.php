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
        // Creation of Primary Roles
		// $role = Role::create(['guard_name' => 'web', 'name' => 'administrator']);
        if ( ! Role::whereName('Administrator')->exists()) {
    		$role = Role::create(['name' => 'Administrator']);

            // Assign permissions to the Role
            $role->givePermissionTo('browse');
            $role->givePermissionTo('catalogs_browse');
            $role->givePermissionTo('catalogs_admin');
            $role->givePermissionTo('users_manage');
        }

        /*
            Example: Assigning a Role with a non existing Permission
            It is possible to implement an automatic creation of the non existent Permission
        */
        /*
        $role = Role::whereName('Administrator')->firstOrFail();
        try  {
            $role->givePermissionTo('No Existe browse');
        } catch ( Spatie\Permission\Exceptions\PermissionDoesNotExist $ex) {
            echo "Permission: "."No Existe browse "." doesn't exist" . "\n";        
        }
        try  {
            $role->givePermissionTo('browse');
        } catch ( Spatie\Permission\Exceptions\PermissionDoesNotExist $ex) {
            echo "Permission: "."browse"." doesn't exist" . "\n";        
        }
        try  {
            $role->givePermissionTo('No Existe browse 2');
        } catch ( Spatie\Permission\Exceptions\PermissionDoesNotExist $ex) {
            echo "Permission: "."No Existe browse 2"." doesn't exist" . "\n";        
        }
        */

        //
        // Creation of Secondary Roles
		// $role = Role::create(['guard_name' => 'web','name' => 'user']);
        //
        $Table = 'roles';
        $Records = [];

        //  $role = Role::create(['name' => 'user']);
        //      $role->givePermissionTo('browse');
        //      $role->givePermissionTo('catalogs_browse');
        $Records[] = [
            'name' => 'User',
            // 'guard_name' => 'web' ,
            // 'description' => 'User',
            'permissions' => ['browse', 'catalogs_browse','browsing'],
            // 'planets' => ['mercury', 'venus','earth','mars'],
        ]; 


		// $role = Role::create(['guard_name' => 'web', 'name' => 'guest']);
		// $role = Role::create(['name' => 'guest']);
        // $role->givePermissionTo('browse');
        $Records[] = [
            'name' => 'Guest',
            'guard_name' => 'web' ,
            'description' => 'Guest User',
            'permissions' => ['browse']
        ]; 
		
		/*
		 *	System Roles
		*/
        /*
		$role = Role::create(['name' => 'User Administrator']);
        $role->givePermissionTo('catalogs_admin');
        $role->givePermissionTo('users_manage');
        $role->givePermissionTo('browse');
        */
        $Records[] = [
            'name' => 'User Administrator',
            'guard_name' => 'web' ,
            'description' => 'Guest User',
            'permissions' => ['catalogs_admim', 'users_manage','browse']
        ]; 

        // Roles Creation
        // $this->createRecordClass(Spatie\Permission\Models\Role::class, $Records);
        $this->createRecordClass(Spatie\Permission\Models\Role::class, $Records,['permissions','planets']);

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

                $newModel = $dbModel::create(collect($dbRecord)->except($dbDetailRecords)->toArray());

            } catch (Spatie\Permission\Exceptions\RoleAlreadyExists $ex) {
                echo $ex->getMessage();
                $newModel = $dbModel::findByName($dbRecord["name"]);
                // dd(var_dump($newModel));
            }
            catch (Exception $ex) {
                echo $ex->getMessage() . "\n";
            } finally {
                // dd(var_dump($newModel));
                /*
                    * Process Detail Records set
                    * 
                */
                if (isset($newModel)) {
                    // dd(var_dump($newModel));
                    echo "Role a procesar: " . $newModel->name  . "\n";

                    foreach ($dbDetailRecords as $dbDetailRecord) {
                        echo var_dump($dbDetailRecord);
                        if ( isset($dbRecord[$dbDetailRecord]) ) {
                            // var_dump($dbRecord[$dbDetailRecord]);

                            foreach ($dbRecord[$dbDetailRecord] as $dbDetail) {
                                echo "Assigning: " . $dbDetail . "\n";

                                try {
                                    $newModel->givePermissionTo($dbDetail);
                                } catch ( Spatie\Permission\Exceptions\PermissionDoesNotExist $ex) {
                                    echo $ex->getMessage() . "\n";                                
                                } catch ( Exception $ex) {
                                    echo $ex->getMessage() . "\n";
                                }

                            }

                        }                
                    }
                }
            }


            /*
                Version Find - Create
                Initial Seed most probable Create-Find is more appropiate
            */
            /*
            try {
                $newModel = $dbModel::findByName($dbRecord["name"]);
            } catch (Exception $ex) {
                dd($ex->getMessage());

                $newModel = $dbModel::create(collect($dbRecord)->except($dbDetailRecords)->toArray());
            }
            */

        }
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
    private function createRecordClassInitialTest( $dbModel, $dbRecords, $dbDetailRecords = []) {
        foreach ($dbRecords as $dbRecord) {
            // var_dump($dbRecord);
            echo 'Nombre: ' . $dbRecord["name"]  . "\n";

            /*
                Version Create - Find
            */
            try {
            
                /*
                 * Using collections will allow to have access to multiple methods
                 * https://laravel.com/docs/6.0/collections
                */
                // dd(collect($dbRecord)->except(['permissions']));
                // dd(collect($dbRecord)->except($dbDetailRecords));

                // This will produce and error if the key 'permissions' (Detail records) is included 
                // $newModel = $dbModel::create($dbRecord);
                // $newModel = $dbModel::create(collect($dbRecord)->except(['permissions'])->toArray());
                $newModel = $dbModel::create(collect($dbRecord)->except($dbDetailRecords)->toArray());

                /*
                 * Process Detail Records set
                 * 
                */
                /*
                //
                // Single Detail reference Records
                //
                if ( isset($dbRecord['permissions']) ) {
                    foreach ($dbRecord['permissions'] as $dbDetail) {
                        // var_dump($dbDetail);
                        echo 'Permission: ' . $dbDetail . "\n";
                    }                
                }
                */
                //
                // Multiple Detail reference Records
                //
                // dd($dbDetailRecords);
                foreach ($dbDetailRecords as $dbDetailRecord) {
                    echo var_dump($dbDetailRecord);
                    if ( isset($dbRecord[$dbDetailRecord]) ) {
                        // var_dump($dbRecord[$dbDetailRecord]);

                        foreach ($dbRecord[$dbDetailRecord] as $dbDetail) {
                            var_dump($dbDetail);
                            // echo 'Permission: ' . $dbDetail . "\n";
                        }
                    }                
                }
            }
            catch (Exception $ex) {
                dd('stop here');
            
            }
            // @todo: Include the QueryException to allow to continue the excecution
            catch ( \Illuminate\Database\QueryException $ex) {
                echo $ex->getMessage();
            }
            catch ( Spatie\Permission\Exceptions\RoleAlreadyExists $ex) {
                echo $ex->getMessage();
                dd(var_dump($dbRecord));
            }
            finally {
                dd('After Error' . var_dump($newModel));
            
            }
        }
    
    }

}
