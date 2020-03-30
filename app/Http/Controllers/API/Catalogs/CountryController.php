<?php

namespace App\Http\Controllers\API\Catalogs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Country;
// Prepares the Json Response
use App\Http\Resources\Country as CountryResource;

class CountryController extends Controller
{

    /**
     * Authentication Gard
     *  If not defined in the Route::
     */
    // public function __construct()
    // {
    //    $this->middleware('auth:api');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $countries = Country::paginate(5);
        $countries = Country::all();

        return CountryResource::collection($countries);
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
    public function show($id)
    {
        $country = Country::findOrFail($id);

        return response()->json(new CountryResource($country));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
