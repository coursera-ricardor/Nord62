@extends('search.layout')


@section('header_styles')
  <!-- DataTables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel Search Example</h2>
                 <br>{{ $formAction }}
                 <br>*{{ Session::get('formReturn') }}*
                 <br>{{ $formData['fieldToSearch'] }}

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
                <button type="button" name="fill_datatable" id="fill_datatable" class="btn btn-info">Load DataTable
                </button>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>

    <!-- dataTable Dynamic Server - Client Side -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="table_data_dynamic" class="table table-bordered table-striped">
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
        <div class="col-md-4"><h1>Datatables Client Side</h1></div>
        <div class="col-md-4">
            <div class="form-group">
                <select name="filter_gender_cs" id="filter_gender_cs" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male Gender</option>
                </select>
            </div>
            <div class="form-group">
                <select name="filter_country_cs" id="filter_country_cs" class="form-control" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->name }}">{{ $user->name }}
                        </option>
                    @endforeach                    
                </select>
            </div>

            <!-- The Trigger -->
            <div calss="form-group" align="center">
                <button type="button" name="filter_cs" id="filter_cs" class="btn btn-info">Filter
                </button>
                <button type="button" name="reset_cs" id="reset_cs" class="btn btn-default">Reset
                </button>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <!-- dataTable Client Side -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="customer_data_cs" class="table table-bordered table-striped">
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
        <div class="col-md-4"><h1>Datatables Server Side</h1></div>
        <div class="col-md-4">
            <div class="form-group">
                <select name="filter_gender_ss" id="filter_gender_ss" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Female">Female</option>
                    <option value="Male">Male Gender</option>
                </select>
            </div>
            <div class="form-group">
                <select name="filter_country_ss" id="filter_country_ss" class="form-control" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->name }}">{{ $user->name }}
                        </option>
                    @endforeach                    
                </select>
            </div>

            <!-- The Trigger -->
            <div calss="form-group" align="center">
                <button type="button" name="filter_ss" id="filter_ss" class="btn btn-info">Filter
                </button>
                <button type="button" name="reset_ss" id="reset_ss" class="btn btn-default">Reset
                </button>
            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>

    <!-- dataTable Server Side -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="customer_data_ss" class="table table-bordered table-striped">
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



    <h1>Datatables from Controller</h1>
   	<table id="tableindex" class="table table-bordered table-hover {{ count($users) > 0 ? 'dataTable' : '' }}">
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
        $(document).ready(function(){
        });

        /*
            * DataTables - Dynamic - Server Side - Client Side -
            * Loading Data from Ajax Call.
            *  Transformation required in the Response Section.
            *
        */
        function fill_datatable(tag_id = '',ajax_url = '', model = '')
        {
            $(tag_id).DataTable({
                lengthMenu: [ [2, 5, 10, 25, 50, 100], [2, 5, 10, 25, 50, 100]] ,
                processing: true,
                type: 'POST',
                ajax:{
                    url:ajax_url,
                    headers: {
                        'CSRFToken' : '{{ csrf_token() }}'
                    },
                    data:{model},
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
                        render: function (data, type, row) {
                            return data.toUpperCase();
                        },
                    },
                    {
                        data:'email',
                        name:'email'
                    },
                    {
                        data:'status',
                        name:'status'
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
            });
        }

        $('#fill_datatable').click(function(){
            $('#table_data_dynamic').DataTable().destroy();
            fill_datatable('#table_data_dynamic',"{{ route('search.lookup_cs') }}",'profiles');
            
        });

        /*
         * On Click test function
         *
        */
        function myFunction(elmnt,clr) {
            elmnt.style.color = clr;
        }

        /*
            * DataTables - Server Side -
            * Loading Data from Ajax Call.
            *  Transformation required in the Response Section.
            *
        */
        $(function(){
            fill_datatable_ss();
        });

        function fill_datatable_ss(filter_one = '', filter_two = '')
        {
            var table = $('#customer_data_ss').DataTable({
                pageLength: 2,
                lengthMenu: [ [2, 5, 10, 25, 50, 100], [2, 5, 10, 25, 50, 100]] ,
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('search.lookup_ss') }}",
                    headers: {
                        'CSRFToken' : '{{ csrf_token() }}'
                    },
                    data:{filter_field1:filter_one, filter_field2:filter_two},
                    dataSrc: 'data'
                },
                columns: [
                    { 'data':'id', 'name':'Identifier' },
                    { 'data':'name' },
                    { 'data':'username', 'name':'username' },
                    { 'data':'email' },
                    { 'data':'status' },
                ]
            });

        };

        $('#filter_ss').click(function(){
            var filter_gender = $('#filter_gender_ss').val();
            var filter_country = $('#filter_country_ss').val();

            if(filter_gender != '' && filter_country != ''){
                $('#customer_data_ss').DataTable().destroy();
                fill_datatable_ss(filter_gender,filter_country);
            } else {
                alert('Select Both filter option');            
            }

        });

        $('#reset_ss').click(function(){
            $('#filter_gender_ss').val('');
            $('#filter_country_ss').val('');
            $('#customer_data_ss').DataTable().destroy();
            fill_datatable_ss();            
        });

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
        $('#tableindex').DataTable();
    </script>

	
@endsection
