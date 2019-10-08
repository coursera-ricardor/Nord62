@extends('access.users.layout')

@section('header_styles')

    <!-- Styles -->
    <!-- Multiselect --> 
@endsection



@section('content')




<div class="container">


    <h3 class="page-title">{{ __('Edit Users') }}</h3>
    
		
        <!-- panel -->
        <div class="panel panel-default">
			<div class="panel-heading">
				{{ __('User ID') }}: {{ $user->id }}
			</div>

            <!-- panel-body -->
			<div class="panel-body">
			
                <!-- form Users and Profile shared Infomration -->
	            <form method="POST" action="{{ route( $master_model . '.update' ,$user->id) }}">
		            {{ csrf_field() }}
		            {{method_field('PUT')}}
                    <!-- Name -->
				    <div class="form-group row col-md-12">
					    <label for="name" class="col-form-label">{{ __('Name') }}*</label>
					    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $user->name }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
				    </div>								
                    <!-- . Name -->

                    <!-- Email -->
                    <div class="form-group row">
                        <div class="col-md-6">
					        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>
					        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') ? old('username') : $user->username }}" readonly>
                        </div>

                        <!-- Example using add-on buttons -->
                        <div class="col-md-6">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
                            <div class="input-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ? old('email') : $user->email }}" required autocomplete="email">
                                <div class="input-group-append">
                                    <span class="input-group-text">usr@srv.com</span>
                                </div>
                            </div>
                            <!-- Laravel Validation -->
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- . Email -->

		            <div class="form-group">

                        <!-- Displaying Errors in the form -->
		                @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

			            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
			
			            <a class="btn btn-info pull-right" href="{{ route( $master_model . '.index' ) }}">{{ __('Back') }}</a>
			
		            </div>

                </form>
                <!-- .form Users and Profile shared Infomration -->



                <!-- Tabs Profile + Roles + Permissions -->
                <nav>
                    <ul id="tabrolesperm" class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a href="#theprofile" id="profile-tab" class="nav-link active"
                                data-toggle="tab"
                                role="tab"
				                aria-controls="theprofile"
				                aria-selected="true"
                                >{{ __('Profile') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#theroles" id="theroles-tab" class="nav-link"
                                data-toggle="tab"
                                role="tab"
				                aria-controls="theroles"
				                aria-selected="true"
                                >{{ __('Roles') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#thepermissions" id="thepermissions-tab" class="nav-link"
                                data-toggle="tab"
                                role="tab"
				                aria-controls="thepermissions"
				                aria-selected="false"
                                >{{ __('Permissions') }}</a>
                        </li>
                    </ul>
                </nav>
                <!-- .Tabs Profile + Roles + Permissions -->

                <!-- Tabs Profile + Roles + Permissions Content -->
                <div class="tab-content">

                    <!-- Tab Profile -->
                    <div id="theprofile" class="tab-pane fade show active"
                        role="tabpanel"
            			aria-labelledby="theprofile-tab">
                        <br>
                        <!--
                            profile form
                        -->
                        <!-- form Users and Profile shared Infomration -->
	                    <form method="POST" action="{{ route( $master_model . '.updateProfile' ,$user->id) }}">
		                    {{ csrf_field() }}
		                    {{method_field('PATCH')}}
                            @include('access.users.edit_profile')

		                    <div class="form-group">
    		                    <button type="submit" class="btn btn-primary">{{__('Update Profile') }}</button>
		                    </div>
                        </form>

                    </div>
                    <!-- .Tab Profile -->

                    <!-- Tab Roles -->
                    <div id="theroles" class="tab-pane fade"
                        role="tabpanel"
            			aria-labelledby="theroles-tab">
                        <br>
                        <!-- form Profile Roles Assigment -->
	                    <form method="POST" action="{{ route( $master_model . '.updateRoles' ,$user->id) }}">
		                    {{ csrf_field() }}
		                    {{method_field('PATCH')}}
                            @include('access.users.edit_roles')

		                    <div class="form-group">
    		                    <button type="submit" class="btn btn-primary">{{__('Update Roles') }}</button>
		                    </div>
                        </form>
                        <!-- .form Profile Roles Assigment -->

                    </div>
                    <!-- .Tab Roles -->

                    <!-- Tab Permissions -->
                    <div id="thepermissions" class="tab-pane fade"
                        role="tabpanel"
                        aria-labelledby="thepermissions-tab">
                        <br>
                        <!-- form Profile Permissions Assigment -->
	                    <form method="POST" action="{{ route( $master_model . '.updatePermissions' ,$user->id) }}">
		                    {{ csrf_field() }}
		                    {{method_field('PATCH')}}
                            @include('access.users.edit_permissions')

		                    <div class="form-group">
    		                    <button type="submit" class="btn btn-primary">{{__('Update Permissions') }}</button>
		                    </div>
                        </form>
                        <!-- .form Profile Permissions Assigment -->

                    </div>
                    <!-- .Tab Permissions -->
                </div>
                <!-- .Tabs Profile + Roles + Permissions Content -->

			</div>
            <!-- .panel-body -->

            <!-- panel-footer -->
            <div class="panel-footer">
                <p>{{__('Created by')}}: {{ $user->find($profileInfo->created_by)->name }} / {{__('Updated by')}}: {{ $user->find($profileInfo->updated_by)->name }}</p>
			</div>
            <!-- .panel-footer -->

		</div>
        <!-- .panel -->

</div>


@endsection

@section('javascripts')
    <!-- Multiselect - NON JQuery multi-select Plugin -->

@endsection

@section('javascriptscode')

    <script type="text/javascript">
        // This is not the Official Jquery Plugin
        //  This is the link to the multiselect code used https://crlcu.github.io/multiselect/
        $('#permissionsmultiview').multiselect();
        $('#rolesmultiview').multiselect();
	</script>


@endsection
