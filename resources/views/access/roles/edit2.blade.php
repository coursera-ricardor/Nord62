@extends('access.roles.layout')

@section('header_styles')

@endsection


@section('content')

<div class="container">
    <h3 class="page-title">{{ __('Edit Roles') }}</h3>
    <!-- panel-group -->
    <div class="panel-group">

        <!-- Form Master Record -->
		<form class="form-horizontal" method="POST" action="{{ route( $master_model . '.update2Permission' ,$role->id) }}">
		    {{ csrf_field() }}
		    {{method_field('GET')}}

            <!-- Panel -->
		    <div class="panel panel-info">
                <!-- Panel Heading -->
			    <div class="panel-heading">
				    {{ __('Roles') }}
                </div>
                <!-- . panel heading -->

                <!-- panel-body -->
			    <div class="panel-body">

			            <div class="form-group">
                            <div class="col-md-4">
    					        <label class="control-label" for="name">{{ __('Name') }}*</label>
                            </div>
                            <div class="col-md-8">
					            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $role->name }}" required>
                            </div>
                            <p class="help-block"></p>
				        </div>

				        <div class="form-group">
					        <label class="control-label" for="description">{{ __('Description') }}*</label>
					        <input type="text" class="form-control" id="description" name="description" value="{{ old('description') ? old('description') : $role->description }}">

                            <!-- Field Extra Validation Error Handling -->
                            @error('description')
                                    <strong>{{ $message }}</strong>
                            @enderror
                            <!-- Option 2 -->
                            @if($errors->has('description'))
                                <p class="help-block">
                                    {{ $errors->first() }}                                    
                                </p>
                            @endif
				        </div>

                        <!-- Detail Records Updating from a Multiple Selection -->
                        <div class="row">
                            <div class="form-group col-xs-12">
				                <div class="form-group">
					                <label class="control-label" for="permissionsSelected">{{ __('Permissions') }}*</label>
					                <select id="permissionsSelected" name="permissionsSelected[]" class="form-control select2" multiple="multiple">

            				            @foreach ($permissionsToSelect as $keyPermission => $permission)
                                            <option value="{{ old('permission') ? old('permission') : $keyPermission }}"
                                                @if($role->permissions->contains($keyPermission)) selected="selected"@endif
                                            >{{ $permission }}
                                            </option>
                                        @endforeach

                                    </select>
				                </div>
                                <p class="help-block"></p>
                            </div>                            
                        </div>

		                <div class="form-group">		
			                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
			                <a class="btn btn-danger pull-right" href="javascript:history.back()">{{ __('Cancel') }}</a>
		                </div>

                </div>
                <!-- . panel-body -->

                <!-- panel-footer -->
			    <div class="panel-footer">
				    {{ __('Roles') }}
			    </div>
                <!-- .panel-footer -->
            </div>
            <!-- .panel -->

        </form>
        <!-- . Form Master Record -->

    </div>
    <!-- .panel-group-->
</div>
<!-- container -->


@endsection

@section('javascripts')

@endsection

@section('javascriptscode')

    <script>
        //
        // Permissions Selection 
        //
        $('#permissionsSelected').select2({
            placeholder: 'Choose a tag'
        });
    </script>

@endsection

@section('footer')
@endsection
