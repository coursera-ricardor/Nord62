@extends('op.profileproject.layout')


@section('header_styles')
  <!-- DataTables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 5.8 CRUD Example</h2>
            </div>

            <!-- Authorization Requires Spatie/permissions-->
            @can('create')
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('users.create') }}"> {{ __('Create') }}</a>
                </div>
            @endcan
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

   	<table id="tableindex" class="table table-bordered table-hover {{ count( $profileprojects ) > 0 ? 'dataTable' : '' }}">
		<thead>
			<tr>
				<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                <th>{{ __('Rel Id') }}</th>
                <th>{{ __('Project') }}</th>
                <th>{{ __('Profile') }}</th>
                <th>{{ __('Status') }}</th>
				<th>{{ __('Related Roles') }}</th>
                <th width="280px">{{ __('Action') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ( $profileprojects as $profileproject)
				<tr data-entry-id="{{ $profileproject->id }}">
					<td></td>
					<td>
						{{ $profileproject->id }}
					</td>
					<td>
                        <!-- Authorization Requires Spatie/permissions-->
                        @can('read')						
    						<a href="{{ route( $master_model . '.show',[$profileproject->id]) }}">{{ $profileproject->id }}</a>
                        @else
                            {{ $profileproject->project->id . ' - ' . $profileproject->project->name }}
                        @endcan
					</td>

                    <td>{{ $profileproject->profile->id . ' - ' . $profileproject->profile->name }}</td>

                    <td>{{ $profileproject->status }}</td>
						
					<td>
                        
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Roles') }}
                                        <span class="badge badge-info" >{{ count($profileproject->roles()->pluck('name')) }}</span>
                                    </th>
                                    <th>{{ __('Permissions') }}                                      
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profileproject->roles as $role)
                                    <tr>
                                        <td><span class="label label-info">{{ $role->name }}</span></td>
                                        <td>
                                            <table>
                                                @foreach($role->permissions as $permission)
                                                <tr><td>
                                                    <span class="label label-info">{{ $permission->name }}</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        <td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
					</td>

                    <!-- Actions -->
					<td>
						    <a href="{{ route( $master_model . '.show',[$profileproject->id]) }}" class="btn btn-xs btn-info">{{ __('Show') }}</a>
						    <a href="{{ route( $master_model . '.edit',[$profileproject->id]) }}" class="btn btn-xs btn-info">{{ __('Edit') }}</a>
							
                        <!-- Authorization Requires Spatie/permissions-->
						        <form method="POST" action="{{ route( $master_model . '.destroy', $profileproject->id) }}" 
							        class="display: inline-block;"
							        onsubmit="return confirm( {{ @("global.app_are_you_sure") }} " >
							        @csrf
							        @method('DELETE')
								
							        <button class="btn btn-xs btn-danger" type="submit">{{ __('Delete') }}</button>
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
        $('#tableindex').DataTable();
    </script>
	
@endsection
