<!--
    Profile Fields Edition
    Requirements:
        - Boostrap
        - The parent Requires to call the activation of the multiselect javascript
            This is the link to the multiselect code used https://crlcu.github.io/multiselect/
            $('#permissionsmultiview').multiselect();

    This file can be included from a master FORM
-->
                        <!-- Permissions Assigment -->
                        <div class="form-group row col-md-12">
                            <!-- Left Options -->
		                    <div class="col-md-5">
					            <label for="permissionsmultiview" class="control-label">{{ __('Permissions Assigned') }}</label>
			                    <select name="permissionsAssigned[]" id="permissionsmultiview" class="form-control" size="14" multiple="multiple">
						            <!-- Search in the Collection -->
						            @foreach ( $permissionsAssigned as $permission )
							            <option value="{{ old('permissions[]') ? old('permissions[]') : $permission->id }}" >{{ $permission->name }}
							            </option>
						            @endforeach
                                </select>
		                    </div>
                            <!-- . Left Options -->
				
                            <!-- Actions -->
		                    <div class="col-md-2">
			                    <button type="button" id="permissionsmultiview_undo" class="btn btn-danger btn-block">undo</button>
			                    <button type="button" id="permissionsmultiview_rightAll" class="btn btn-default btn-block"><i class="fas fa-forward"></i></button>
			                    <button type="button" id="permissionsmultiview_rightSelected" class="btn btn-default btn-block"><i class="fas fa-chevron-right"></i></button>
			                    <button type="button" id="permissionsmultiview_leftSelected" class="btn btn-default btn-block"><i class="fas fa-chevron-left"></i></button>
			                    <button type="button" id="permissionsmultiview_leftAll" class="btn btn-default btn-block"><i class="fas fa-backward"></i></button>
			                    <button type="button" id="permissionsmultiview_redo" class="btn btn-warning btn-block">redo</button>
		                    </div>
                            <!-- . Actions -->
				
                            <!-- Right Options -->
		                    <div class="col-md-5">
					            <label for="permissionsmultiview_to" class="control-label">{{ __('Permissions Available') }}</label>
			                    <select name="permissionsAvailable[]" id="permissionsmultiview_to" class="form-control" size="14" multiple="multiple">
						            <!-- Search in the Collection -->
						            @foreach ( $permissionsToSelect as $keyPermission => $permissionAvailable )
                                        @if( ! $profileInfo->permissions()->pluck('name','name')->has($permissionAvailable) )
                                            <option value="{{ $keyPermission }}">{{ $permissionAvailable }}
                                            </option>
                                        @endif

						            @endforeach						
			                    </select>
		                    </div>
                            <!-- .Right Options -->

	                    </div>
                        <!-- . Permissions Assigment -->
