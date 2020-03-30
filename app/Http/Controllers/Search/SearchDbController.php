<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Auth;

class SearchDbController extends Controller
{
    /*
     * Lookup Using Datatables
     *  Requires: https://datatables.net/
     *              npm i datatables
    */

    /*
     * Lookup Using Datatables with Client Side Interaction
    */
    /**
     * Display a listing of the resource.
     * API Test
     *  Using Resources - Countries -
     *
     * @return \Illuminate\Http\Response
    */
    public function countries_cs(Request $request)
    {
        // Master Model - Main Table
        // @todo: Accept and change the Ajax api call
        $master_model = 'countries';

        $api_token = '';
        if ( Auth::check() ){
            $api_token = Auth::user()->api_token;
        }
        return view('search.indexApiLookup_cs',compact('api_token'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function users_cs(Request $request)
    {
        // Master Model - Main Table
        $master_model = 'users';

        $formAction = 'search.lookupSet';

        //
        // The Initial Call of the function will be false
        // The Ajax call is made from the Form via JavaScript
        //
        if(request()->ajax()){
            return $this->lookup_cs($request);
        }

        $newValue = 'nada';
        /*
         * Storing the previous Values
         *
        */
        $formData = $request->except('_token');
        $formData['fieldToSearch'] = 'searchField';

        $users = DB::table($master_model)
                ->select('id','name','username','email','status')
                ->orderBy('name', 'ASC')
                ->get();

        return view('search.indexLookup_cs',compact('master_model','users','formAction','formData','newValue'));
        // return view('search.indexLookup_cs',compact('master_model'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $master_model = 'users';

        /*
         * Search Form Information
         *
        */
        $searchDefs['s_searchField'] = 'users';
        $searchDefs['s_city'] = 'cities';
        $searchDefs['s_service'] = 'services';

        return view('search.serviceCity',compact('master_model','searchDefs')); // search/servicecity
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function lookup2(Request $request)
    {
        // Master Model - Main Table
        $master_model = 'users';

        if(request()->ajax()){
            return $this->lookup_cs($request);
        }
/*
        // Initially will be false
            // Filter the Data
            if(!empty($request->filter_gender)){
                $data = DB::table($master_model)
                    ->select('id','name','username','email','status')
                    ->orderBy('name', 'ASC')
                    ->get();
            } else {
                $data = DB::table($master_model)
                    ->select('id','name','username','email','status')
                    ->orderBy('name', 'ASC')
                    ->get();
            }
            // unsaved model instance
            return datatables()->of($data)->make(true);
*/

        $formAction = 'search.lookupSet';
        $newValue = 'nada';
        /*
         * Storing the previous Values
         *
        */
        $formData = $request->except('_token');
        $formData['fieldToSearch'] = 'searchField';

        $users = DB::table($master_model)
                ->select('id','name','username','email','status')
                ->orderBy('name', 'ASC')
                ->get();

        return view('search.index',compact('master_model','users','formAction','formData','newValue'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * If it is an Ajax Response the route needs to be protected by a Gate.
     * In this case, is the response to fill a JQuery DataTable.
    */
    public function lookup_ss(Request $request)
    {
        $master_model = 'users';

        if(request()->ajax()){
            //
            // Information sended by Datatables.js in the Request
            //
            $rowsPerPage =  $request->length;
            $draw =         $request->draw;
            $start =        $request->start; 
            $columns =      $request->columns;  // Array with columns Information
            $searchValue =  $request->search['value'];
            $sortFields =   $request->order;    // Array with field sort instructions

            $serverResponse = ['draw' => $draw];

            // Query Build
            $query = DB::table($master_model);
            $serverResponse['recordsTotal'] = $query->count();

            // Columns Process
            $select = [];
            foreach($columns as $keyData => $column){
                $select[] = $column['data'];

                //Searchable
                if($column['searchable']){
                    if($searchValue) {
                        if($column['searchable']){
                            $query->orWhere($column['data'], 'like','%' . $searchValue . '%');
                        }
                    }                
                }
            }
            // Select
            // Note: Datatables require the number of records AFTER Filter.
            $query->select($select); // $query HAS the filter orWhere at this moment.
            $serverResponse['recordsFiltered'] = $query->count();

            // Sort Definitions
            //  One or Multiple Order By Selection
            foreach($sortFields as $sortField => $sortDir) {
                $query->orderBy($request->columns[$sortDir['column']]['data'], $sortDir['dir']);
            }

            // Rows per Call & Offset
            $query->offset($start);
            if($rowsPerPage > 0 ){
                $query->limit($rowsPerPage);
            }

            // Query execution
            $data = $query->get();

            // Server response construction
            //  required for the DataTable
            //
            // [x] $serverResponse['recordsTotal'] = DB::table($master_model)->count(); $serverResponse['recordsTotal'] = $query->count();
            // [x] $serverResponse['recordsFiltered'] = $query->count(); // After Filter orWhere Construction
            // 
            $serverResponse['data'] = $data->values();

            // Laravel formats the Response in JSON format
            return $serverResponse;

            // Note: Other option is:
            // 
            //  Requires composer require yajra/laravel-datatables-oracle:"~9.0"
            //  Package to use Ajax and Datatables in Laravel
            //  to be able to use this return cluase.
            // return Datatables::of($data)->make(true);
        }
        // No AJax Call Return 404
        return abort(404);
        // Test on error 500
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * If it is an Ajax Response the route needs to be protected by a Gate.
     * In this case, is the response to fill a JQuery DataTable.
    */
    public function lookup_cs(Request $request)
    {
        $master_model = 'users';

        /*
         * @todo: Add Access Validation
        */
        if(request()->ajax()){

            $master_model = $request->model ?: 'users';

            $query = DB::table($master_model);
            // $query->select('id','name','username','email','status');
            $data = $query->get();

            // Server response construction
            //  required for the DataTable
            //
            $serverResponse['data'] = $data->values();

            // Laravel formats the Response in JSON format
            return $serverResponse['data'];
        }
        // No AJax Call Return 404
        return abort(404);
        // Test on error 500
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function lookup(Request $request, $modelid, $mainField, $responseField = 'name')
    {

        // dd($request->service);
        // dd($request->all());
        return response()->json(['service' => 'dddd']);
        $request->merge([$mainField => $responseField]);

        return back()->withInput();
        /*
         * Perameters:
         *      - Model
         *      - Field to return
         *      - Action to Execute
         *
        */

        // $newValue = request('fieldToSearch');
        $newValue = 'junk';

        /*
            * If No search field provided return back
            *
        */
        // if( null === $newValue){
        //    return redirect()->back()->withErrors(['No search field provided']);
        // }

        // Master Model - Main Table
        $master_model = 'users';
        $master_model = $modelid;


        $users = User::orderby('id', 'desc')->get();

        $formAction = 'search.lookupSet';
        $formReturn = 'search.form';

        // Session Variables
        // $request->session()->put('master_model','users');
        $request->session()->put('formReturn', $formReturn);

        /*
         * Storing the previous Values
         *
        */
        $formData = $request->except('_token');

        return view('search.index',compact('master_model','users','formAction','formData','newValue'));

    }


    /**
        * Display a listing of the resource.
        * Paramenters
        *   $modelid    Table
        *   $keyids     id Key
        *
        * @return \Illuminate\Http\Response
        */
    public function searchLookupSet(Request $request, $modelid, $keyids)
    {
        /*
         * Search the Value to return
         *
        */
        // remove the "s_" from the field identifier
        $field2Merge = substr(array_search($modelid,$request->all()),2 );
        // dd($field2Merge);

        $service = User::find($keyids)->name;

        $request->merge([$field2Merge => $service]);
        $request->merge(['searchField' => 'hasta aqui']);
        $request->merge(['service' => 'hasta aqui']);
        $request->merge(['city' => $service]);

        // dd($request->all());
        // dd($request->input());
        // dd($request->session()->pull('formReturn'));
        // dd($request->session()->pull('master_model'));
        $returnTo = $request->session()->pull('formReturn');

        // dd($returnTo);

        return redirect()->route($returnTo)->withInput();




        return redirect()->route($returnTo);

        // return redirect()->route($returnTo)->with('service',$service);

        return redirect()->route($returnTo)->withInput();

        return redirect()->to(route('search.form'))->withInput();

        // dd($keyids);
        return redirect()->route('search.form')->withInput();

        dd($request->service);
        dd($keyids);
dd($request->input());
        $service = User::find($keyids)->name;
        $city = 'tbd';
        return view('search.result',compact('service','city'));

        dd($fieldValue->name);
        dd($request);
/*
    TRICK
if ($request->isMethod('post')) {

    if ($request->has('submit_button_form_1')) {
        // Handle form
    }
    elseif ($request->has('submit_button_form_2')) {
        // Handle form
    }
    elseif ($request->has('submit_button_form_3')) {
        // Handle form
    }
}
*/

    }

  public function process(Request $request)
  {
      $service = $request->input('service');
      $city = $request->input('city');

      /* Do something with data */

      return view('search.result', compact('service','city'));
  }

  public function search(Request $request)
  {
        $service = $request->get('service') . 'Premier Service';
        $city = $request->get('city') . 'Deuxieme Ville';
        // $value = DB::table('profiles')->where('name','like','%' . $search . '%')->paginate(5);
        return view('search.result',compact('service','city'));
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = User::select("name")->where("name","LIKE","%{$request->input('query')}%")->get();

        return response()->json($data);    

    }

}
