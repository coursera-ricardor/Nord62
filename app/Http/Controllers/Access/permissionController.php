<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// @todo: Add the Spatie Package
use Spatie\Permission\Models\Permission;


class permissionController extends Controller
{

    /**
     * @todo: Add access restriction
     *
    */
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $master_model = 'permissions';

        $permissions = Permission::orderby('id', 'desc')->get();
        return view('access.permissions.index',compact('permissions','master_model'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('access.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Fields Validation
        $request->validate([
            'name' => 'required|unique:permissions',
            'guard_name' => 'required',
            'description' => 'required',
        ]);

        Permission::create($request->all());

        return redirect()->route('permissions.index')->with('success', __('Permission created successfully') );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return view('access.permissions.show', compact('permission'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show1($id)
    {
        $permission = Permission::FindorFail($id);  // Find the Permission
        return view('access.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    public function edit(Permission $permission)
    {
        return view('access.permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    public function update(Request $request, Permission $permission)
    {
        // Fields Validation
        $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
            'description' => 'required',
        ]);
        $permission->update($request->all());

        return redirect()->route('permissions.index')->with('success', __('Permission updated successfully') );
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
}
