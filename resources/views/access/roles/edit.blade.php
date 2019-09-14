@extends('access.roles.layout')

@section('header_styles')

    <!-- Styles -->
	
@endsection



@section('content')


<div class="container">

    <h3 class="page-title">{{ __('Edit Roles') }}</h3>
    
	<form method="POST" action="{{ route( $master_model . '.update' ,$role->id) }}">
		{{ csrf_field() }}
		{{method_field('PUT')}}
		
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ __('Role ID') }}: {{ $role->id }}
			</div>

            <!-- panel-body -->
			<div class="panel-body">
			
				<div class="form-group">
					<label for="name">{{ __('Name') }}*</label>
					<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $role->name }}" required>

				</div>								

				<div class="form-group">
					<label for="description">{{ __('Description') }}*</label>
					<input type="text" class="form-control" id="description" name="description" value="{{ old('description') ? old('description') : $role->description }}" required>
				</div>								

                <!--
                    Second Option
                    Loading using Eloquent and multi-select (Not JQuery Version Candidate to be use in Vue or React)
                -->
                <div class="form-group row col-md-12">
		            <div class="col-md-5">
					    <label for="multiview" class="control-label">{{ __('Permissions Available') }}</label>
			            <select name="permissionsAvailable[]" id="multiview" class="form-control" size="14" multiple="multiple">
						    <!-- Search in the Collection -->
						    @foreach ( $permissionsToSelect as $keyPermission => $permissionAvailable )
                                @if( ! $role->permissions()->pluck('name','name')->has($permissionAvailable) )
                                    <option value="{{ $keyPermission }}">{{ $permissionAvailable }}
                                    </option>
                                @endif

						    @endforeach						
			            </select>
		            </div>
				
		            <div class="col-md-2">
                        <p>Actions</p>
                        <br>
			            <button type="button" id="multiview_undo" class="btn btn-danger btn-block">{{ __('undo') }}</button>
			            <button type="button" id="multiview_rightAll" class="btn btn-default btn-block"><i class="fas fa-forward"></i></button>
			            <button type="button" id="multiview_rightSelected" class="btn btn-default btn-block"><i class="fas fa-chevron-right"></i></button>
			            <button type="button" id="multiview_leftSelected" class="btn btn-default btn-block"><i class="fas fa-chevron-left"></i></button>
			            <button type="button" id="multiview_leftAll" class="btn btn-default btn-block"><i class="fas fa-backward"></i></button>
			            <button type="button" id="multiview_redo" class="btn btn-warning btn-block">{{ __('redo') }}</button>
		            </div>
				
		            <div class="col-md-5">
					    <label for="multiview_to" class="control-label">{{ __('Permissions Assigned') }}</label>
			            <select name="permissionsAssigned[]" id="multiview_to" class="form-control" size="14" multiple="multiple">
						    <!-- Search in the Collection -->
						    @foreach ( $permissionsAssigned as $keyPermission => $permission )
							    <option value="{{ old('permissions[]') ? old('permissions[]') : $keyPermission }}" >{{ $permission }}
							    </option>
						    @endforeach
                        </select>
		            </div>

	            </div>				
			</div>
            <!-- .panel-body -->

            <!-- panel-footer -->
            <div class="panel-footer">
		        <div class="form-group text-center">
		
			        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
			
			        <a class="btn btn-danger pull-right" href="{{ route( $master_model . '.index' ) }}">{{ __('Cancel') }}</a>
			
		        </div>
			</div>
            <!-- .panel-footer -->

		</div>

    </form>


</div>


@endsection

@section('javascripts')
    <!-- NON JQuery multi-select Plugin -->

@endsection

@section('javascriptscode')

    <script type="text/javascript">
        // This is not the Official Jquery Plugin
        //  This is the link to the multiselect code used https://crlcu.github.io/multiselect/
        $('#multiview').multiselect({
            search: {
                left:  '<input type="text" name="qpermit" class="form-control" placeholder="{{ __('Search') }}..." />',
                right: '<input type="text" name="qpermit" class="form-control" placeholder="{{ __('Search') }}..." />',
            },
            fireSearch: function(value) {
                return value.length > 3;
            }
        });
	</script>


@endsection
