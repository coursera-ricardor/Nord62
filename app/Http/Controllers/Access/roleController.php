<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// @todo: Add the Spatie Package
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class roleController extends Controller
{

    /**
     * Creates a new Roles controller instance.
     * Authentication can be done via routes/web.php
     */
    
    public function __construct()
    {
        // $this->middleware('auth',['except' => ['index','show']]);
        $this->middleware('auth');

    }
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Master Model - Main Table
        $master_model = 'roles';

        $roles = Role::orderby('id', 'desc')->get();
        return view('access.roles.index',compact('roles','master_model'));       
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    public function show(Role $role)
    {
        // @todo: Get Permissions records
        $permissions = $role->permissions()->get();

        return view('access.roles.show', compact('role','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    public function edit(Role $role)
    {
        $master_model = 'roles';

        $permissionsToSelect = Permission::orderBy('name')->pluck('name','id');

        $permissionsAssigned = $role->permissions()->orderBy('name')->get()->pluck('name','id');

        return view('access.roles.edit',compact('role','master_model','permissionsAssigned','permissionsToSelect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    public function update(Request $request, Role $role)
    {
        // Fields Validation
        $request->validate([
            'name' => 'required',
            // 'guard' => 'required',
            'description' => 'required',
        ]);
        // dd($request->input());

        $role->update($request->except('permissionsAvailable','permissionsAssigned','qpermit'));
        //
        // Sync the Permissions
        //
        $this->syncRoles($role, $request->input('permissionsAssigned'));

        return redirect()->route('roles.index')->with('success', __('Role updated successfully') );
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

    /*
     * Additional Test Methods
    */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit2(Role $role)
    {       
        $master_model = 'roles';

        // dd($role->permissions->contains(3));
        // List of permissions assigned (Possible rollback)
        $permissionsAssigned = $role->permissions()->orderBy('name')->get();

        // List of all Permissions
        // $permissions = Permission::get(['id','name']);
        // Or
        $permissionsToSelect = Permission::pluck('name','id');

        // dd($permissionsToSelect->toArray());
        // dd(print_r($permissionsToSelect));

        return view('access.roles.edit2',compact('role','master_model','permissionsAssigned','permissionsToSelect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update2Permission(Request $request, Role $role)
    {
        // Fields Validation
        $request->validate([
            'name' => 'required',
            // 'guard' => 'required',
            'description' => 'required',
        ]);
        // dd('ok');
        // dd($role->id);
        // dd($role->permissions->pluck('name','name'));
        // dd($request->all());
        // dd($request->input('permissionsSelected'));


        /**
         *
         * Updates the Master information of the record
         *
        */
        // $role->update($request->all()); // Detail records in the request cause an exception
        $role->update($request->except('permissionsSelected'));

        //
        // Updates the Detail Table (Synchronizing)
        //
        // dd($request->input('permissionsSelected'));
        // $role->permissions()->sync($request->input('permissionsSelected'));
        $this->syncRoles($role, $request->input('permissionsSelected'));

        return redirect()->route('roles.index')->with('success', __('Role updated successfully') );

    }

    /**
     * Sync up the list of permissions assigned to the Role
     *
     * @param  Role  $role
     * @param  array  $permissionsToUpdate
     */
    private function syncRoles(Role $roleToSync, array $permissionsToUpdate = null)
    {
        $roleToSync->permissions()->sync($permissionsToUpdate);
    }


    /**
     * Save a new role.
     *
     * @param  Rolerequest  $request
     * @return mixed
     */
    private function createRole(Request $request)
    {
        // Creates the role
        $role = Role::create($request->except('permissionsSelected'));

        // Obtrain the Permissions ID to add
        // $permissionIds = $request->input('permissionsSelected');
        // Create the Detail
        // $role->permissions()->attach($permissionIds);
        // $role->permissions()->sync($request->input('permissionIds'));
        if ( !empty($request->input('permissionsSelected'))) {        
            $this->syncRoles($role, $request->input('permissionsSelected'));
        }

        return $role;
    }


}
