@extends('access.roles.layout')

@section('content')
    <h3 class="page-title">@lang('access.roles.title')</h3>
	
	<form method="POST" action="{{ route( $master_model . '.store' ) }}">
		{{ csrf_field() }}
	
		<div class="panel panel-default">
			<div class="panel-heading">
				@lang('global.app_create')
			</div>
			
			<div class="panel-body">
			
				<div class="form-group">
					<label for="name">@lang('access.roles.fields.name')*</label>
					<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : '' }}" required>
				</div>
				<div class="form-group">
					<label for="description">@lang('access.roles.fields.description')*</label>
					<input type="text" class="form-control" id="description" name="description" value="{{ old('description') ? old('description') : '' }}" required>
				</div>
							
				<div class="form-group col-xs-12">
				
					<label for="permissionsSelected" class="control-label">@lang('access.roles.fields.permission')</label>
					
					<select name="permissionsSelected[]" class="form-control select2" multiple="multiple">
						<!-- Search in the Collection -->
						@foreach ( $permissions as $key => $permission )
							<option value="{{ $permission }}">{{ $key }}</option>
						@endforeach
						
					</select>

				</div>		
				
			</div>
		</div>

		<div class="form-group">
		
			<button type="submit" class="btn btn-primary">@lang('global.app_save')</button>
			
			<a class="btn btn-danger pull-right" href="{{ route( $master_model . '.index' ) }}">@lang('global.app_cancel')</a>
			
		</div>
	
    </form>
@stop

