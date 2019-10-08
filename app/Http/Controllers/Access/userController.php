<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Example using Gate
use Illuminate\Support\Facades\Gate;

use App\User;
use App\Profile;

// @todo: Add the Spatie Package
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


/*
 *   Not required
 use Illuminate\Support\Facades\Auth;

  * Functionality included via $request or middleware auth         

     if (! Auth::check()) {
        dd('Login');
     } else  {
         dd(Auth::user()); // equivalent dd(auth()->user());
     }
*/

class userController extends Controller
{

    /**
     * Creates a new Users controller instance.     
     *  Requires the user to be authenticated to be able to use some functions
     *  Security Schema is controlled by Roles and Permissions.
     */
    public function __construct()
    {
        /*
         * Example allowing some functionalities without login restriction
        */
        // $this->middleware('auth',['except' => ['index','show']]);

        // Access to the Users table is restricted,
        // the user needs to login first
        // $this->middleware('auth');

        // Specific permissions required to access the options of the Controller

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*
            Policies Authorization
        */

        /*
            Spatie/permissions
            @todo: Main table associated to roles and permissions is "Profile", the @can() directive needs to be updated.

        */
        // dd(auth()->user()->name);
        // dd(auth()->user()->getAllPermissions()); // returns empty
        // dd(auth()->user()->profile->getAllPermissions()); // returns collection with permissions

        /*
            If there is not user logged in an Exception is created.
            - Authentication should be validated first, via Route middleware or at __Construct section.
            - The profile is created only via:
                User / Edit
                User Validation and Authorization.
            - After the authentication control is implemented, it should work without the if-then-else:
                $profilePermissions = auth()->user()->profile->getAllPermissions()->pluck('name');        

        */
        // if ( ! is_null(auth()->user())) {
        if ( auth()->check() && ( ! is_null(auth()->user()->profile )) ) {
            try {
                $profilePermissions = auth()->user()->profile->getAllPermissions()->pluck('name');        
            } catch ( Exception $ex) {
                echo $ex->getMessage();
            }        
        } else {
            $profilePermissions = collect([]);
        }


        // Master Model - Main Table
        $master_model = 'users';

        // $roles = Role::orderby('id', 'desc')->get();

        /*
            Record Access Control
                - Read [ All | Owner | Group | Other]

            [A]-ll records can be viewed
        */
        $users = User::orderby('id', 'desc')->get();
        /*
            [O]-wner Only records created_by can be viewed.
            To implement this control, Auth implementation is required first, to identify the User credentials.
            The rights assignation control required an additional implementation.

                auth()->id()        // returns the id of the logged user
                auth()->user()      // returns the logged user
                auth()->check()     // checks if someone is logged in
                auth()->guest()     // checks if guest

            @todo: Spatie\Permissions does not have created_by in the record implemented.
                add the field and the index in the migration: $table->foreign('created_by')->references('id')->on('users');

        */
        // $users = User::where('id',auth()->id())->orderby('id', 'desc')->get();


        return view('access.users.index',compact('users','master_model','profilePermissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // User::create($request + ['created_by' => auth()->id()]);
        //
        // Adding to the request
        // $request['created_by'] = auth()->id();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        /*
            Condition is failing due the relationship returns STRING instead of INTEGER
                if ($user->profile->created_by !== auth()->id() )

            Options to solve the problem,
                - Cast the returned value when required
                - Cast the auth()->id() as STRING or $user->profile->created_by as INTEGER
                - Modify the Model using $casts[] array and cast the field to INTEGER
        */
        // dd($theProfile->id); // returns integer
        // dd($user->profile->created_by); // returns string
        // $theProfile = $user->profile;

        // dd($user->id); // automatic conversion 
        // dd(auth()->id()); // automatic conversion

        /*
        *  Authorization
        */
        // dd($user->id);
        // dd($user->profile->user_id);
        // dd($user->profile->created_by);
        /*
         * Using Policies\ProfilePolicy.php
         *  These calls are not standard, In this case calling an authorization using other Model class.
         * 
        */
        // $this->authorize('viewAny',Profile::class); // Call to the ProfilePolicy.php even if it is not registered in Providers\AuthServiceProvider.php
        // $this->authorize('view',[Profile::class,$user->profile]); // Call to the ProfilePolicy.php even if it is not registered in Providers\AuthServiceProvider.php

        /*
         * Gate Test
         * Note: Any Authorizable model can be used in the Gate call
        */
/*
        //
        // Test sending the User RECORD as the main object
        //
        // if( Gate::forUser(auth()->user())->allows('test-gate', $user->id)) {
        if( Gate::forUser($user->profile)->allows('test-gate', $user->id)) {
            if( Gate::forUser($user->profile)->allows('test-gate', $user->profile->id)) {
                dd('ok');
            } else {
                dd('fail');
            }        
        } else {
           abort(403,'fail - not logged in OR No Profile defined');
        }

        //
        // Test sending the Auth user as the main object
        //
        if( auth()->check() && (! is_Null(auth()->user()->profile) )) {
            if( Gate::forUser(auth()->user()->profile)->allows('test-gate', $user->profile->id)) {
                dd('ok');
            } else {
                dd('fail');
            }        
        } else {
           abort(403,'fail - not logged in OR No Profile defined');
        }

*/
        /*
         * Using Policies\UserPolicy.php
         *  Basic Validation: if ($user->profile->created_by !== auth()->id() )
         * 
        */
        // dd($user->can('browse')); // Returns false
        // dd($user->profile->can('browse')); // Returns true

        // $this->authorize('view',$user); // Uses UserPolicy
        $this->authorize('view',$user->profile); // Uses ProfilePolicy

        /*
          Same validation in the controller.
          - Profile record existance validation required
        */
        if (is_null($user->profile)){
            if ( auth()->id() !== $user->id ) {
                abort(403,__('Record not owned'));
            }        
        } else {
            if ($user->profile->created_by !== strval(auth()->id()) ) {
                abort(403,__('Record not owned'));
            }        
        }
        // laravel helper
        // abort_if($user->profile->created_by !== auth()->id(), 403);
        // Via Policy control, creating the logic in the Policies/UserPolicy.php with the command:
        //  php artisan make:policy ProfilePolicy –model=Profile
        // It requires to update the Providers/AuthServiceProvider.php
        // $this->authorize('view',$user->profile);
        // dd($user->profile);

        dd('return the User View');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $master_model = 'users';


        // List of all Roles
        $rolesToSelect = Role::pluck('name','id');

        // List of all Permissions
        $permissionsToSelect = Permission::pluck('name','id');


        /*
            User -> Profile One to One relationship
            Note:
                User Status A-ctive P-rotected  B-locked R-estricted C-onfirmation Required
                IF Profile record does not exists it needs to be created.
                Provate function updateProfile
        */
        $profileInfo = $user->profile;
        if ( ! $profileInfo) {
            $profileInfo = $this->profileUpdate($user);
        }
        // List of roless assigned (Possible rollback)
        // $rolesAssigned = [];
        $rolesAssigned = $profileInfo->roles()->orderBy('name')->get();
        // dd($rolesAssigned);

        // List of permissions assigned (Possible rollback)
        // $permissionsAssigned = [];
        $permissionsAssigned = $profileInfo->permissions()->orderBy('name')->get();
        // dd($permissionsAssigned);

        return view('access.users.edit',compact('user','master_model','rolesToSelect','permissionsToSelect','rolesAssigned','permissionsAssigned','profileInfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // dd($request);
        // dd($request->name);
		// Validate a Unique Key Allowing the Update
		$this->validate(request(),[
			'name' => 'required|min:3' ,
			// 'language_code' => 'required|min:2|exists:languagecodes,languagecode' ,
			// 'country_code' => 'required|min:3|exists:countrycodes,ccn3' ,
			'email' => 'required|min:3|email',
			]);
        
        $user->update($request->all());
        $this->profileUpdate($user,['created_by' => $user->profile->created_by]);

        return back()->with('success', 'User Updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, User $user)
    {
        // dd($request);
        // dd($request->first_name);
        // dd($request->email);
        // dd($user->name);

		// Validate a Unique Key Allowing the Update
		$this->validate(request(),[
			'first_name' => 'required|min:3' ,
			'last_name' => 'required|min:3' ,
			// 'language_code' => 'required|min:2|exists:languagecodes,languagecode' ,
			// 'country_code' => 'required|min:3|exists:countrycodes,ccn3' ,
			]);
        
        $profileInfo = $user->profile;
        // dd($profileInfo);
        $profileInfo->update($request->all());

        // @todo: Update log updated_by / updated timestamp

        return back()->with('success', __('Profile Updated') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(Request $request, User $user)
    {
        // dd($request);
        // dd($user->id);

        //
        // Updates the Detail Table (Synchronizing)
        //
        // dd($request->input('rolesAssigned'));
        $profileInfo = $user->profile;
        // dd($profileInfo);
        // $profileInfo->roles()->sync($request->input('rolesAssigned'));
        $this->syncRoles($profileInfo, $request->input('rolesAssigned'));

        // @todo: Update log updated_by / updated timestamp

        return back()->with('success', __('Roles Updated') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function updatePermissions(Request $request, User $user)
    {
        // dd($request);
        // dd($user->id);

        //
        // Updates the Detail Table (Synchronizing)
        //
        $profileInfo = $user->profile;
        // dd($profileInfo);
        // dd($request->input('permissionsAssigned')); // list of the permissions to be assigned

        // $profileInfo->roles()->sync($request->input('rolesAssigned'));
        $this->syncPermissions($profileInfo, $request->input('permissionsAssigned'));

        // @todo: Update log updated_by / updated timestamp

        return back()->with('success', __('Permissions Updated') );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Create the Profile Record.
     * Note:
     *      Adjust the Model to be able to update the fields
     *
     * @param  User::class  $mainUser
     * @param  array  $updProfile
     * @return Profile::class
     *
        // Create
        $this->profileUpdate($user);
        // Update
        $this->ProfileUpdate($user,['created_by' => $user->profile->created_by]);

     */
     private function profileUpdate(User $mainUser, $updProfile = [] ) {
        // dd(array_key_exists('created_by',$updProfile));
        // dd($updProfile['created_by']);
        // dd($updProfile);
        try {
           // dd($mainUser->toArray());
           $theProfile = Profile::updateOrCreate(
                ['user_id' => $mainUser->id],
                [
                    'name' => $mainUser->name,
                    'email' => $mainUser->email,
                    'status' => $mainUser->status,
                    // User needs to be authenticated first, if not an error will occur
                    'updated_by' => auth()->user()->id,
                    // Update - Do not change if the record has a value indicated in the array $updProfile
                    'created_by' => (( empty($updProfile) || (! array_key_exists('created_by',$updProfile)) ) ? auth()->user()->id : $updProfile['created_by']),
                ]
           );

        } catch ( Exception $ex) {
            echo $ex->getMessage() . "\n";
        } catch ( \Illuminate\Database\QueryException $ex) {
            echo $ex->getMessage() . "\n";
        }
            return $theProfile;
     }

    /**
     * Sync up the list of roles assigned to the Profile
     *
     * @param  Profile  $profile
     * @param  array  $rolesToUpdate
     */
    private function syncRoles(Profile $profileToSync, array $rolesToUpdate = null)
    {
        $profileToSync->roles()->sync($rolesToUpdate);
    }

    /**
     * Sync up the list of permissions assigned to the Profile
     *
     * @param  Profile  $profile
     * @param  array  $rolesToUpdate
     */
    private function syncPermissions(Profile $profileToSync, array $permissionsToUpdate = null)
    {
        $profileToSync->permissions()->sync($permissionsToUpdate);
    }


}
