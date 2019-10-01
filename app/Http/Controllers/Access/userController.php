<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $this->middleware('auth');

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
            Spatie/permissions
            @todo: Main table associated to roles and permissions is "Profile", the @can() directive needs to be updated.

        */
        // dd(auth()->user()->name);
        // dd(auth()->user()->getAllPermissions()); // returns empty
        // dd(auth()->user()->profile->getAllPermissions()); // returns collection with permissions

        /*
            If the profile does not exists, and Exception is created.
            The profile is created only via:
                User / Edit
                User Validation and Authorization.
        */
        try {
            $profilePermissions = auth()->user()->profile->getAllPermissions()->pluck('name');        
        } catch ( Exception $ex) {
            report($ex);
        }


        // Master Model - Main Table
        $master_model = 'users';

        // $roles = Role::orderby('id', 'desc')->get();

        /*
            Record Access Control
                - Read [ All | Owner | Group | Other]

            [A]-ll records can be viewed
        */
        // $users = User::orderby('id', 'desc')->get();
        /*
            [O]-wner Only records created_by can be viewed.
            To implement this control, Auth implementation is required first, to identify the User credentials.
            The rights assignation control required an additional implementation.

                auth()->id()        // returns the id of the logged user
                auth()->user()      // returns the logged user
                auth()->check()     // checks if someone is logged in
                auth()->guest()     // checks if guest

            @todo: Spatie\Permissions does not have owner_id in the record implemented.
                add the field and the index in the migration: $table->foreign('owner_id')->references('id')->on('users');

        */
        $users = User::where('id',auth()->id())->orderby('id', 'desc')->get();


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
        // User::create($request + ['owner_id' => auth()->id()]);
        //
        // Adding to the request
        // $request['owner_id'] = auth()->id();
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
                if ($user->profile->owner_id !== auth()->id() )

            Options to solve the problem,
                - Cast the returned value when required
                - Cast the auth()->id() to STRING
                - Modify the Model using $casts[] array and cast the field to INTEGER
        */
        // dd($theProfile->id); // returns integer
        // dd($user->profile->owner_id); // returns string
        // $theProfile = $user->profile;

        // dd($user->id); // automatic conversion 
        // dd(auth()->id()); // automatic conversion

        /*
        *  Authorization
        */
        // if ($user->profile->owner_id !== auth()->id() ) {
        // dd($user->id);
        // dd($user->profile->user_id);
        // dd($user->profile->owner_id);

        if ($user->profile->owner_id !== strval(auth()->id()) ) {
            abort(403,__('Record not owned'));
        }
        // laravel helper
        // abort_if($user->profile->owner_id !== auth()->id(), 403);
        // Via Policy control, creating the logic in the Policies/UserPolicy.php with the command:
        //  php artisan make:policy ProfilePolicy –model=Profile
        // It requires to update the Providers/AuthServiceProvider.php
        // $this->authorize('view',$user->profile);
        // dd($user->profile);
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
                    'owner_id' => auth()->user()->id,
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
