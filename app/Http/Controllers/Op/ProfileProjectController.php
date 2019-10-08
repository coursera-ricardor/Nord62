<?php

namespace App\Http\Controllers\Op;

use App\ProjectProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ProfileProject;


class profileProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Master Model - Main Table
        $master_model = 'users';

        // $profileprojects = Auth()->user()->????->get();
        $profileprojects = ProfileProject::orderby('project_id')->get();
        $profilePermissions = [];

        return view('op.profileproject.index',compact('profileprojects','master_model','profilePermissions'));        
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
     * @param  \App\ProjectProfile  $projectProfile
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectProfile $projectProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectProfile  $projectProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectProfile $projectProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProjectProfile  $projectProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectProfile $projectProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjectProfile  $projectProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectProfile $projectProfile)
    {
        //
    }
}
