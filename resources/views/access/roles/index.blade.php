@extends('access.roles.layout')

@section('header_styles')
  <!-- DataTables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>

@endsection

@section('content')
<div class="container">

<div class="box">
	<div class="box-header">
		<h4 class="box-title">@lang('global.app_list') @lang('access.roles.title')</h4>
	</div>
	
	<div class="box-body">

		<!-- @todo: Check Rights to create -->
		@if (true)
			<p>
				<a href="{{ route( $master_model . '.create') }}" class="btn btn-success">{{ __('Create') }}</a>
			</p>
		@endif

		<table id="tableindex" class="table table-bordered table-hover {{ count($roles) > 0 ? 'dataTable' : '' }}">
			<thead>
				<tr>
					<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
					<th>@lang('access.roles.fields.name')</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Related Permissions') }}</th>

					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($roles as $role)
					<tr data-entry-id="{{ $role->id }}">
						<td></td>
						<td>
							<a href="{{ route( $master_model . '.show',[$role->id]) }}">{{ $role->name }}</a>
						</td>

						<td>{{ $role->description }}</td>

                        <td>
                            <span class="badge badge-info align-center" >{{ count($role->permissions()->pluck('name')) }}</span>
					    </td>

						<td>
						
							<a href="{{ route( $master_model . '.show',[$role->id]) }}" class="btn btn-xs btn-info">{{ __('Show') }}</a>

							<a href="{{ route( $master_model . '.edit',[$role->id]) }}" class="btn btn-xs btn-info">{{ __('Edit') }}</a>
							<a href="{{ route( $master_model . '.edit2',[$role->id]) }}" class="btn btn-xs btn-info">{{ __('Edit') }}2</a>
							
							<form method="POST" action="{{ route( $master_model . '.destroy', $role->id) }}" 
								class="display: inline-block;"
								onsubmit="return confirm( {{ @("global.app_are_you_sure") }} " >
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
								
								<button class="btn btn-xs btn-danger" type="submit">{{ __('Delete') }}</button>
							</form>
						</td>
					</tr>
				@endforeach
			
			</tbody>
		</table>
	</div>			
			
	
</div>
</div>
@endsection

<!-- Specific Scripts to the page to be yielded -->

@section('javascripts')

     <script>
        $('#tableindex').DataTable();
    </script>
	
@endsection

