@extends('access.users.layout')


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

   	<table id="tableindex" class="table table-bordered table-hover {{ count($users) > 0 ? 'dataTable' : '' }}">
		<thead>
			<tr>
				<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Login') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Status') }}</th>
				<th>{{ __('Related Roles') }}</th>
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
                        <!-- Authorization Requires Spatie/permissions-->
                        @can('read')						
    						<a href="{{ route( $master_model . '.show',[$user->id]) }}">{{ $user->username }}</a>
                        @else
                            {{ $user->username }}
                        @endcan
					</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ $user->status }}</td>
						
					<td>
                        <span class="badge badge-info" >count($permission->roles()->pluck('name'))</span>
					</td>

                    <!-- Actions -->
					<td>
                        <!-- Authorization Requires Spatie/permissions-->
                        @can('read')						
						    <a href="{{ route( $master_model . '.show',[$user->id]) }}" class="btn btn-xs btn-info">{{ __('Show') }}</a>
                        @endcan

                        <!-- fails if(auth()->user()->profile->can('read')) -->
            			@foreach ( $profilePermissions as $profilePermission )
                            <p>{{ $profilePermission }}</p>
                        @endforeach

                        @if($profilePermissions->search('read'))
						    <a href="{{ route( $master_model . '.show',[$user->id]) }}" class="btn btn-xs btn-info">{{ __('Show') }}</a>
                        @endif

                        <!-- Authorization Requires Spatie/permissions-->
                        @can('edit')
						    <a href="{{ route( $master_model . '.edit',[$user->id]) }}" class="btn btn-xs btn-info">{{ __('Edit') }}</a>
                        @endcan

                        @if( in_array('edit',$profilePermissions->toArray()) )
						    <a href="{{ route( $master_model . '.edit',[$user->id]) }}" class="btn btn-xs btn-info">{{ __('Edit') }}</a>
                        @endif

                        <!--
                            Really annoying validation.
                            @todo: Change the validation to the controller
                        -->
                        @if( auth()->check() && (! is_Null(auth()->user()->profile) ))
                            @if( in_array('edit', auth()->user()->profile->getAllPermissions()->pluck('name')->toArray() ) )
						        <a href="{{ route( $master_model . '.edit',[$user->id]) }}" class="btn btn-xs btn-info">{{ __('Edit') }}</a>
                            @endif
                        @endif

							
                        <!-- Authorization Requires Spatie/permissions-->

                        @if( auth()->check() && (! is_Null(auth()->user()->profile) ))
                            @if(auth()->user()->profile->can('delete'))
						        <form method="POST" action="{{ route( $master_model . '.destroy', $user->id) }}" 
							        class="display: inline-block;"
							        onsubmit="return confirm( {{ @("global.app_are_you_sure") }} " >
							        @csrf
							        @method('DELETE')
								
							        <button class="btn btn-xs btn-danger" type="submit">{{ __('Delete') }}</button>
						        </form>
                            @endif
                        @endif

                        <!--to validate -->
                        @can('delete')
						    <form method="POST" action="{{ route( $master_model . '.destroy', $user->id) }}" 
							    class="display: inline-block;"
							    onsubmit="return confirm( {{ @("global.app_are_you_sure") }} " >
							    @csrf
							    @method('DELETE')
								
							    <button class="btn btn-xs btn-danger" type="submit">{{ __('Delete') }}</button>
						    </form>
                        @endcan
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
