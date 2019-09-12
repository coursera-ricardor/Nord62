@extends('access.permissions.layout')

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
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('permissions.create') }}"> {{ __('Create New Permission') }}</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

   	<table id="tableindex" class="table table-bordered table-hover {{ count($permissions) > 0 ? 'dataTable' : '' }}">
		<thead>
			<tr>
				<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Guard') }}</th>
                <th>{{ __('Description') }}</th>
				<th>{{ __('Related Roles') }}</th>
                <th width="280px">{{ __('Action') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($permissions as $permission)
				<tr data-entry-id="{{ $permission->id }}">
					<td></td>
					<td>
						<a href="{{ route( $master_model . '.show',[$permission->id]) }}">{{ $permission->name }}</a>
					</td>

                    <td>{{ $permission->guard_name }}</td>

                    <td>{{ $permission->description }}</td>
						
					<td>
                        <span class="badge badge-info" >{{ count($permission->roles()->pluck('name')) }}</span>
					</td>

                    <!-- Actions -->
					<td>
						
						<a href="{{ route( $master_model . '.show',[$permission->id]) }}" class="btn btn-xs btn-info">{{ __('Show') }}</a>

						<a href="{{ route( $master_model . '.edit',[$permission->id]) }}" class="btn btn-xs btn-info">{{ __('Edit') }}</a>
							
						<form method="POST" action="{{ route( $master_model . '.destroy', $permission->id) }}" 
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
    $(document).ready(function () {
        $.noConflict();
        var table = $('#tableindex').DataTable();
    });
</script>
	
@endsection
