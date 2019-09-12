@extends('access.roles.layout')

@section('header_styles')

    <!-- Styles -->
    <link href="{{ asset('css/multi-select.css') }}" rel="stylesheet">
	
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
				
                <!-- MultiSelect -->
				<div class="form-group col-xs-12">
                    <div class="row">

                        <!-- Permissions Available -->
                        <div class="col-5">
					        <label for="permission" class="control-label">{{ __('Permissions Available') }}</label>
					        <select id="permissionindex" name="permissionsToSelect[]" class="form-control select2" multiple="multiple" size="10">
						        <!-- Search in the Collection -->
						        @foreach ( $permissionsToSelect as $keyPermission => $permissionAvailable )
                                    @if( ! $role->permissions()->pluck('name','name')->has($permissionAvailable) )
                                        <option value="{{ $keyPermission }}">{{ $permissionAvailable }}
                                        </option>
                                    @endif

						        @endforeach						
					        </select>
                        </div>

                        <div class="col-2">
                	        <h4>@{{ title_actions }}</h4>
                            <button class="btn btn-primary btn-block mb-2" v-on:click="allToRight">&raquo;</button>
                            <button class="btn btn-primary btn-block mb-2" v-on:click="oneToRight">&gt;</button>
                            <button class="btn btn-primary btn-block mb-2" v-on:click="allToLeft">&laquo;</button>
                            <button class="btn btn-primary btn-block mb-2" v-on:click="oneToLeft">&lt;</button>
                        </div>

                        <!-- Permissions Assigned -->
                        <div class="col-5">
					        <label for="permissionsSelected" class="control-label">{{ __('Permissions Assigned') }}</label>
					        <select id="permissionSelected" name="permissionsSelected[]" class="form-control select2" multiple="multiple" size="10">
						        <!-- Search in the Collection -->
						        @foreach ( $permissionsAssigned as $keyPermission => $permission )
							        <option value="{{ old('permissions[]') ? old('permissions[]') : $keyPermission }}" >{{ $permission }}
							        </option>
						        @endforeach						
					        </select>
                        </div>
				    </div>

                    <div class="row">
                        <button class="btn btn-primary btn-block mb-2" v-on:click="allToRight">Update Detail</button>
				    </div>

				</div>		
                <!-- . MultiSelect -->
				
			</div>
            <!-- .panel-body -->

            <!-- panel-footer -->
            <div class="panel-footer">
		        <div class="form-group">
		
			        <button type="submit" class="btn btn-primary">@lang('global.app_update')</button>
			
			        <a class="btn btn-danger pull-right" href="{{ route( $master_model . '.index' ) }}">@lang('global.app_cancel')</a>
			
		        </div>
			</div>
            <!-- .panel-footer -->

		</div>



    <!-- Second Option -->
    <div class="form-group row col-md-12">
		<div class="col-md-5">
			<select name="from[]" id="lstview" class="form-control" size="14" multiple="multiple">
				<option value="HTML">HTML</option>
				<option value="2CSS">CSS</option>
				<option value="CSS">CSS3</option>
				<option value="jQuery">jQuery</option>
				<option value="JavaScript">JavaScript</option>
				<option value="Bootstrap">Bootstrap</option>
				<option value="MySQL">MySQL</option>
				<option value="PHP">PHP</option>
				<option value="JSP">JSP</option>
				<option value="Rubi on Rails">Rubi on Rails</option>
				<option value="SQL">SQL</option>
                <option value="Java">Java</option>
                <option value="Python">Python</option>
			</select>
		</div>
				
		<div class="col-md-2">
			<button type="button" id="lstview_undo" class="btn btn-danger btn-block">undo</button>
			<button type="button" id="lstview_rightAll" class="btn btn-default btn-block"><i class="fas fa-forward"></i></button>
			<button type="button" id="lstview_rightSelected" class="btn btn-default btn-block"><i class="fas fa-chevron-right"></i></button>
			<button type="button" id="lstview_leftSelected" class="btn btn-default btn-block"><i class="fas fa-chevron-left"></i></button>
			<button type="button" id="lstview_leftAll" class="btn btn-default btn-block"><i class="fas fa-backward"></i></button>
			<button type="button" id="lstview_redo" class="btn btn-warning btn-block">redo</button>
		</div>
				
		<div class="col-md-5">
			<select name="to[]" id="lstview_to" class="form-control" size="14" multiple="multiple"></select>
		</div>

	</div>

    </form>


</div>


@endsection

@section('javascripts')
    <!-- JQuery multi-select Plugin -->
    <script type="text/javascript" charset="utf8" src="{{ asset('js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('js/multiselect.js') }}"></script>

@endsection

@section('javascriptscode')

    <script type="text/javascript">
        // This is not the Official Jquery Plugin https://crlcu.github.io/multiselect/
        $('#lstview').multiselect();
	</script>

    <script type="text/javascript">

        // Select all the elements of the Select
        var masterForm = document.getElementById("permissionindex").closest("form");
        masterForm.addEventListener("submit", setAllTags);

        function setAllTags () {
            selectAllTags("permissionindex");
            selectAllTags("permissionSelected");
        }

        function selectAllTags(element) {
            var selectAll = document.getElementById(element);

            for ( var i = 0; i < selectAll.length; ++i ) {
                selectAll.options[i].selected = true;
            }

        }
	</script>


@endsection
