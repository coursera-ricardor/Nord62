@extends('search.layout')


@section('header_styles')

@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel Search Example</h2>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4"><h1>Datatables Dynamic</h1></div>
        <div class="col-md-4">
            <!-- The Trigger -->
            <div calss="form-group" align="center">
                <button type="button" name="fill_datatable" id="fill_datatable_cs" class="btn btn-info">Load DataTable Ajax Call
                </button>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>

    <!-- dataTable Dynamic Server - Client Side -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="table_data_dynamic" class="table table-bordered table-hover">
		            <thead>
			            <tr>
				            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Login') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th width="280px">{{ __('Action') }}</th>
			            </tr>
		            </thead>
                </table>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4"><h1>Datatables Dynamic</h1></div>
        <div class="col-md-4">
            <!-- The Trigger -->
            <div calss="form-group" align="center">
                <button type="button" name="fill_datatable_ajax" id="fill_datatable_ajax" class="btn btn-info">Load DataTable Ajax Call V2
                </button>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>

    <!-- dataTable Dynamic Server - Client Side -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" id="table_data_dynamic_v2">
                <!-- Dynamic Datable Here -->
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4"><h1>Datatables from Controller</h1></div>
        <div class="col-md-4">
            <!-- The Trigger -->
            <div calss="form-group" align="center">
                <button type="button" name="fill_datatable_ctrl" id="fill_datatable_ctrl" class="btn btn-info">Activate Datatable functionality
                </button>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>

   	<table id="tableindex" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Login') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Status') }}</th>
                <th width="280px">{{ __('Action') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr data-entry-id="{{ $user->id }}">
					<td></td>
					<td>
						{{ $user->name }}
					</td>
					<td>
                        {{ $user->username }}
					</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ $user->status }}</td>
						
                    <!-- Actions -->
					<td>
                        <!--
    			        <a href="{{ route($formAction, ['model' => 'modelo' ,'keyid' => $user->id]) }}" id="keyids" class="btn btn-xs btn-info">
                            <i class="fas fa-search"></i> {{ __('Select') }} {{ route( $formAction, ['model' => 'modelo' ,'keyid' => $user->id]) }}
                        </a>
                        -->

                        <!--
                        -->
                        <form method="post" action="{{ route( $formAction, ['model' => $master_model ,'keyid' => $user->id]) }}">
                            {{ csrf_field() }}

                            @foreach($formData as $datakey => $data)
                                <input type="hidden" name="{{ $datakey }}" value="{{ $data }}">
                            @endforeach

                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-search"></i>
                                {{ __('Select') }}
                            </button>
                        </form>
					</td>

				</tr>
			@endforeach
			
		</tbody>
	</table>


</div>
@endsection

@section('javascripts')

    <script>

        /*
         * Datatables Configuration
         *  Ajax Call - Client Side Configuration
         *      Render the Table after Success
         *      Each case is different, based on the Server Response.
        */
        $.ajax({
                url: "{{ route('search.lookup_cs') }}",
                headers: {
                    'CSRFToken' : '{{ csrf_token() }}'
                },
                success: function (response) {
                    var tableHeaders = '';
                    $.each(response[0], function (field_id, val) {
                        if (field_id != 'id') {
                            tableHeaders += "<th>" + field_id + "</th>";
                        }
                    });

                    console.log(tableHeaders);

                    var columns = [];
                    $.each(response[0], function (key, value) {
                        var obj = { data: key, name: key };
                        columns.push(obj);
                    });
                    // columns = response;
                    console.log(columns);

                    //
                    // Datatable construction
                    //
                    $('#table_data_dynamic_v2').empty();
                    $('#table_data_dynamic_v2').append(
                        '<table id="dyn_v2_display" class="table table-bordered table-hover">' +
                        '<thead><tr>' +
				            '<th style="text-align:center;">' +
                            '<input type="checkbox" id="select-all" /></th>' +
                            tableHeaders + '</tr></thead>' +
                        '</table>'
                    );

                    $('#dyn_v2_display').dataTable({data: response, columns: columns});

                },
                function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                    $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                    console.log('jqXHR:');
                    console.log(jqXHR);
                    console.log('textStatus:');
                    console.log(textStatus);
                    console.log('errorThrown:');
                    console.log(errorThrown);
                },
            });
/*
        var tableUsers = {
            lengthMenu: [ [2, 5, 10, 25, 50, 100], [2, 5, 10, 25, 50, 100]] ,
            processing: false,
            serverSide: false,
            type: 'POST',
            ajax:{
                data:'{ {{ $master_model }} }',
                dataSrc: '',
            },
        };
*/
        /*
         * Datatables Configuration
         *  Ajax Call - Client Side Configuration
         *
        */
        var tableUsers_static = {
            lengthMenu: [ [2, 5, 10, 25, 50, 100], [2, 5, 10, 25, 50, 100]] ,
            processing: false,
            serverSide: false,
            type: 'POST',
            ajax:{
                url: "{{ route('search.lookup_cs') }}",
                headers: {
                    'CSRFToken' : '{{ csrf_token() }}'
                },
                data:'{ {{ $master_model}} }',
                dataSrc: '',
            },
            columns: [
                {
                    data:'id',
                    name:'id'
                },
                {
                    data:'name',
                    name:'name',
                },
                {
                    data:'email',
                    name:'email'
                },
                {
                    data:'status',
                    name:'status',
                    render: function (data, type, row) {
                        return data.toUpperCase();
                    },
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button type="submit" class="btn btn-info">' +
                                '<i class="fas fa-search"></i>' +
                                " {{ __('Select') }} " + row.id +
                                '</button>' ;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button class="btn btn-info" onclick="myFunction(this, ' + "'red'" + ')">' +
                                '<i class="fas fa-search"></i>' +
                                row.id +
                                '</button>' ;
                    }
                },
            ],
        };

        /*
         * Datatables render
         * parameters:
         *      tag_id - string with the Table #tag_id
         *      extraParameters - optional Datatable configuration Object 
        */
        function fill_datatable(tag_id = '',...extraParameters)
        {
            var extraParameters = extraParameters[0] || {};

            $(tag_id).DataTable(extraParameters);
        
        };

        /*
            * DataTables - Dynamic - Server Side - Client Side -
            * Loading Data from Ajax Call.
            *  Transformation required in the Response Section.
            *
        */
        function fill_datatable22(tag_id = '',...extraParameters)
        {
            var extraParameters = extraParameters || [];

            /*
             * Check if the Ajax Object Call Exists
            */
            var dtObj = extraParameters.find(arg => typeof arg == "object" ) || {};

            var ajax_Code = dtObj.ajax || {};

            var dt_Config = dtObj.config || {};
            var ajax_processing = dt_Config.processing || false;
            var ajax_serverSide = dt_Config.serverSide || false;

            var dt_Coulmns = dtObj.columns || [];

            $(tag_id).DataTable({
                lengthMenu: [ [2, 5, 10, 25, 50, 100], [2, 5, 10, 25, 50, 100]] ,
                processing: ajax_processing,
                serverSide: ajax_serverSide,
                type: 'POST',
                ajax: ajax_Code,
/*
                ajax:{
                    url:ajax_url,
                    headers: {
                        'CSRFToken' : '{{ csrf_token() }}'
                    },
                    data:{model},
                    dataSrc: '',
                },
*/
                columns: dt_Coulmns,
            });
        }

        $('#fill_datatable_cs').click(function(){

            $('#table_data_dynamic').DataTable().destroy();

            fill_datatable('#table_data_dynamic',tableUsers_static);
        });


        $('#fill_datatable_cs22').click(function(){

            $('#table_data_dynamic').DataTable().destroy();

            fill_datatable22('#table_data_dynamic',
                {
                    config: {
                        serverSide: false,
                        processing: true,
                    },
                    ajax : {
                        url: "{{ route('search.lookup_cs') }}",
                        headers: {
                            'CSRFToken' : '{{ csrf_token() }}'
                        },
                        data: '{ {{ $master_model}} }' ,
                        dataSrc: ''
                    },
                    columns: [
                        {
                            data:'id',
                            name:'id'
                        },
                        {
                            data:'name',
                            name:'name',
                        },
                        {
                            data:'email',
                            name:'email'
                        },
                        {
                            data:'status',
                            name:'status',
                            render: function (data, type, row) {
                                return data.toUpperCase();
                            },
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return '<button type="submit" class="btn btn-info">' +
                                        '<i class="fas fa-search"></i>' +
                                        " {{ __('Select') }} " + row.id +
                                        '</button>' ;
                            }
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return '<button class="btn btn-info" onclick="myFunction(this, ' + "'red'" + ')">' +
                                        '<i class="fas fa-search"></i>' +
                                        row.id +
                                        '</button>' ;
                            }
                        },
                    ],
                },
            );

        });

        /*
         * On Click test function
         *
        */
        function myFunction(elmnt,clr) {
            elmnt.style.color = clr;
        }

        /*
         * DataTables - Client Side -
         * Loading Data from Ajax Call.
         * No Transformation required in the Response Section.
         *
        */
        $(function(){
//            fill_datatable_cs();
        });


        function fill_datatable_cs(filter_gender = '', filter_country = '')
        {
            var dataTable = $('#customer_data_cs').DataTable({
                processing: true,
                lengthMenu: [ [ 5, 10, 25, 50, 100], [ 5, 10, 25, 50, 100]] ,
                ajax:{
                    url:"{{ route('search.lookup_cs') }}",
                    headers: {
                        'CSRFToken' : '{{ csrf_token() }}'
                    },
                    data:{filter_gender:filter_gender, filter_country:filter_country},
                    dataSrc: ''

                },
                columns: [
                    {
                        data:'id',
                        name:'id'
                    },
                    {
                        data:'name',
                        name:'name'
                    },
                    {
                        data:'username',
                        name:'username'
                    },
                    {
                        data:'email',
                        name:'email'
                    },
                    {
                        data:'status',
                        name:'status'
                    },
                ],

            });
        }

        $('#filter_cs').click(function(){
            var filter_gender = $('#filter_gender_cs').val();
            var filter_country = $('#filter_country_cs').val();

            if(filter_gender != '' && filter_country != ''){
                $('#customer_data_cs').DataTable().destroy();
                fill_datatable_cs(filter_gender,filter_country);
            } else {
                alert('Select Both filter option');            
            }
        });

        $('#reset_cs').click(function(){
            $('#filter_gender_cs').val('');
            $('#filter_country_cs').val('');
            var filter_one = $('#filter_gender_cs').val();
            var filter_two = $('#filter_country_cs').val();

            $('#customer_data_cs').DataTable().destroy();
            fill_datatable_cs_clear(filter_one,filter_two);
            
        });

        // Experimental Call - Call
        function fill_datatable_cs_clear(filter_1 = '', filter_2 = '')
        {
            var dataTable = $('#customer_data_cs').DataTable({
                processing: true,
                ajax:{
                    url:"{{ route('search.lookup2') }}",
                    headers: {
                        'CSRFToken' : '{{ csrf_token() }}'
                    },
                    data:{filter_gender:filter_1, filter_country:filter_1},
                    dataSrc: ''

                },
                columns: [
                    {
                        data:'id',
                        name:'id'
                    },
                    {
                        data:'name',
                        name:'name'
                    },
                    {
                        data:'username',
                        name:'username'
                    },
                    {
                        data:'email',
                        name:'email'
                    },
                    {
                        data:'status',
                        name:'status'
                    },
                ],

            });
        }


    </script>



    <script>
//        $('#tableindex').DataTable();
        $('#fill_datatable_ctrl').click(function(){

            $('#tableindex').DataTable().destroy();

            fill_datatable('#tableindex');
            // fill_datatable('#tableindex',{lengthMenu: [ [ 5, 10, 25, 50, 100], [ 5, 10, 25, 50, 100]] ,});
            // fill_datatable('#tableindex',{lengthMenu: [ [2, 5, 10, 25, 50, 100], [ 2, 5, 10, 25, 50, 100]] ,});
        });
    </script>

	
@endsection
