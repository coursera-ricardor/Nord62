<!--
    Profile Fields Edition
    Requirements:
        - Boostrap
        - The parent Requires to call the activation of the multiselect javascript
            This is the link to the multiselect code used https://crlcu.github.io/multiselect/
            $('#rolesmultiview').multiselect();

    This file can be included from a master FORM
-->
                        <!-- Roles Assigment -->
                        <div class="form-group row col-md-12">

                            <!-- Left Options -->
		                    <div class="col-md-5">
					            <label for="rolesmultiview" class="control-label">{{ __('Roles Assigned') }}</label>
			                    <select name="rolesAssigned[]" id="rolesmultiview" class="form-control" size="14" multiple="multiple">
						            <!-- Search in the Collection -->
						            @foreach ( $rolesAssigned as $role )
							            <option value="{{ old('roles[]') ? old('roles[]') : $role->id }}" >{{ $role->name }}
							            </option>
						            @endforeach
                                </select>

		                    </div>
                            <!-- . Left Options -->
				
                            <!-- Actions -->
		                    <div class="col-md-2">
			                    <button type="button" id="rolesmultiview_undo" class="btn btn-danger btn-block">undo</button>
			                    <button type="button" id="rolesmultiview_rightAll" class="btn btn-default btn-block"><i class="fas fa-forward"></i></button>
			                    <button type="button" id="rolesmultiview_rightSelected" class="btn btn-default btn-block"><i class="fas fa-chevron-right"></i></button>
			                    <button type="button" id="rolesmultiview_leftSelected" class="btn btn-default btn-block"><i class="fas fa-chevron-left"></i></button>
			                    <button type="button" id="rolesmultiview_leftAll" class="btn btn-default btn-block"><i class="fas fa-backward"></i></button>
			                    <button type="button" id="rolesmultiview_redo" class="btn btn-warning btn-block">redo</button>
		                    </div>
                            <!-- . Actions -->
				
                            <!-- Right Options -->
		                    <div class="col-md-5">
					            <label for="rolesmultiview_to" class="control-label">{{ __('Roles Available') }}</label>
			                    <select name="rolesAvailable[]" id="rolesmultiview_to" class="form-control" size="14" multiple="multiple">
						            <!-- Search in the Collection -->
						            @foreach ( $rolesToSelect as $keyRole => $roleAvailable )
                                        @if( ! $profileInfo->roles()->pluck('name','name')->has($roleAvailable) )
                                            <option value="{{ $keyRole }}">{{ $roleAvailable }}
                                            </option>
                                        @endif
						            @endforeach						
			                    </select>
		                    </div>
                            <!-- . Right Options -->

	                    </div>
                        <!-- .Roles Assigment -->
