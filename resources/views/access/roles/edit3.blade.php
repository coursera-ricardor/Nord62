@extends('access.roles.layout')

@section('header_styles')

@endsection



@section('content')

<div class="container">
    <h3 class="page-title">{{ __('Edit Roles') }}</h3>
    <div class="panel-group">
        <!-- Panel -->
		<div class="panel panel-default">
            <!-- Panel Heading -->
			<div class="panel-heading">
				{{ __('Roles') }}
            </div>
            <!-- . panel heading -->

            <!-- panel-body -->
			<div class="panel-body">
            </div>
            <!-- . panel-body -->
        </div>

    </div>
</div>



<div class="container">


    <div class="panel-group">

        <!-- Panel -->
		<div class="panel panel-default">
            <!-- Panel Heading -->
			<div class="panel-heading">

                <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#modalSearch"
                    data-master_model="{{ $master_model }}"
                    data-roleid="{{ $role->id }}"
                    data-rolename="{{ $role->name }}"
                    > Modal Search
                </button>

			</div>
            <!-- . panel heading -->

            <!-- panel-body -->
			<div class="panel-body">
		            <form class="form-horizontal" method="POST" action="{{ route( $master_model . '.update2Permission' ,$role->id) }}">
		                {{ csrf_field() }}
		                {{method_field('GET')}}

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

                            <!-- Field Validation Error -->
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

                        <!-- Updating from a Multiple Selection -->
                        <div class="row">
                            <div class="form-group col-xs-12">
				                <div class="form-group">
					                <label class="control-label" for="permissionsSelected">{{ __('Permissions') }}*</label>
					                <select id="permissionsSelected" name="permissionsSelected[]" class="form-control select2" multiple="multiple">

            				            @foreach ($permissionsToselect as $keyPermission => $permission)
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

                        <!-- Updating from a Multiple Selection Loadding Data -->
                        <div class="row">
                            <div class="form-group col-xs-12">
				                <div class="form-group">
					                <label class="control-label" for="permissionsSelected2">{{ __('Permissions') }}*</label>
					                <select id="permissionsSelected2" name="permissionsSelected2[]" class="form-control select2" multiple="multiple">

                                    </select>
				                </div>
                                <p class="help-block"></p>

                            </div>                            
                        </div>

		                <div class="form-group">		
			                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
			                <a class="btn btn-danger pull-right" href="javascript:history.back()">{{ __('Cancel') }}</a>
		                </div>
                    </form>

		            <form class="form-horizontal" method="POST" action="{{ route( $master_model . '.update' ,$role->id) }}">
		                {{ csrf_field() }}
		                {{method_field('PUT')}}
			            <div class="form-group">
                            <div class="col-md-4">
    					        <label class="control-label" for="name">{{ __('Name') }}*</label>
                            </div>
                            <div class="col-md-8">
					            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $role->name }}" required>
                            </div>
				        </div>								

				        <div class="form-group">
					        <label class="control-label" for="description">{{ __('Description') }}*</label>
					        <input type="text" class="form-control" id="description" name="description" value="{{ old('description') ? old('description') : $role->description }}" required>
				        </div>

		                <div class="form-group">
		
			                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
			
			                <a class="btn btn-danger pull-right" href="javascript:history.back()">{{ __('Cancel') }}</a>
			
		                </div>

                    </form>
			</div>
            <!-- . panel body -->

			<div class="panel-footer">
				{{ __('Roles') }}
			</div>
        </div>
        <!-- . Panel -->

        <!-- Panel Detail -->
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ __('Assigned Roles') }}
			</div>
			<div class="panel-body">
                <!-- Detail Table Information -->
                <div class="row">
		            <table id="tableDetail" class="table table-bordered table-hover {{ count($assignedPermissions) > 0 ? 'dataTable' : '' }}">
			            <thead>
				            <tr>
					            <th style="text-align:center;"><input type="checkbox" id="select-all" ></th>
					            <th>{{ __('Assigned Permissions') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Related Roles') }}</th>

					            <th>{{ __('Action') }}</th>
				            </tr>
			            </thead>
			            <tbody>
				            @foreach ($assignedPermissions as $permission)
					            <tr data-entry-id="{{ $permission->id }}">
						            <td></td>
						            <td>
							            <a href="#">{{ $permission->name }}</a>
						            </td>

						            <td>{{ $permission->description }}</td>

                                    <td>
                                        <span class="badge badge-info align-center" >1</span>
					                </td>

						            <td>
						
                                        <!-- Show Modal Form -->
                                        <a href="#" data-toggle="modal" data-target="#showDetailModal{{ $permission->id }}" class="btn btn-xs btn-info">{{ __('Show') }}
                                        </a>
                                        <!-- Modal -->
                                        <div id="showDetailModal{{ $permission->id }}" class="modal fade" role="dialog">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <br>{{ __('Permission') }}
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{__('Name')}}: {{ $permission->name }}</p>
                                                        <p>{{__('Description')}}: {{ $permission->description }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- . Modal Form -->

                                        <!-- Edit Modal Form -->
                                        <a href="#" data-toggle="modal" data-target="#updatePermissionModal{{ $permission->id }}" class="btn btn-xs btn-info">{{ __('Edit') }}
                                        </a>

                                        <!-- Modal Update -->
                                        <div class="modal fade" id="updatePermissionModal{{ $permission->id }}" tabindex="-1" role="dialog" aria-labelledby="Update Permission" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{__('Permission')}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route( $master_model . '.update2Permission',[$role->id]) }}" method="post">
			                                            {{method_field('GET')}}
			                                            {{csrf_field()}}
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">{{__('Name')}}</label>
		                                                    <input type="text" class="form-control" id="name{{ $permission->id }}" name="name" value="{{ old('name') ? old('name') : $permission->name }}">

                                                            </div>
                                                            <div class="form-group">
                                                            <label for="message-text" class="col-form-label">{{__('Description')}}</label>
			                                                <textarea class="form-control" id="description{{ $permission->id }}" name="description" value="{{ old('description') ? old('description') : $permission->description }}"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Send message</button>
                                                        </div>

                                                    </form>


                                                </div>
                                            </div>
                                        </div>

                                        <!-- . Modal Form -->							
							            <form method="POST" action="#" 
								            class="display: inline-block;"
								            onsubmit="return confirm( {{ @("global.app_are_you_sure") }} " >

								            {{ csrf_field() }}
								            {{ method_field('DELETE') }}
								
								            <button class="btn btn-xs btn-danger" type="submit">{{ __('Remove Role') }}</button>
							            </form>
						            </td>
					            </tr>
				            @endforeach

                        <!-- Option 2 -->
				            @foreach ($assignedPermissions as $permission)
					            <tr data-entry-id="Opt2{{ $permission->id }}">
						            <td>2nd</td>
						            <td>
							            <a href="#">{{ $permission->name }}</a>
						            </td>

						            <td>{{ $permission->description }}</td>

                                    <td>
                                        <span class="badge badge-info align-center" >1</span>
					                </td>

						            <td>
						
                                        <!-- Show Modal Form -->
                                        <a href="#" data-toggle="modal" data-target="#showDetailModal{{ $permission->id }}" class="btn btn-xs btn-info">{{ __('Show') }}
                                        </a>
                                        <!-- Modal -->
                                        <!-- Defined in the previous cycle -->
                                        <!-- . Modal Form -->

                                        <!-- Edit Modal Form -->

                                        <button class="btn btn-info" 
	                                        data-mytitle="Permission" 
	                                        data-myname="{{$permission->name}}" 
	                                        data-mydescription="{{$permission->description}}"
                                            data-mypermission_id="{{$permission->id}}"
	                                        data-toggle="modal" 
	                                        data-target="#updatePermissionModalOpt2">Edit JQuery
                                        </button>

                                        <!-- . Modal Form -->
							
							            <form method="POST" action="#" 
								            class="display: inline-block;"
								            onsubmit="return confirm( {{ @("global.app_are_you_sure") }} " >

								            {{ csrf_field() }}
								            {{ method_field('DELETE') }}
								
								            <button class="btn btn-xs btn-danger" type="submit">{{ __('Remove Role') }}</button>
							            </form>
						            </td>
					            </tr>
				            @endforeach

                        <!-- . Option 2 -->
			
			            </tbody>
		            </table>
                </div>
                <!-- .Detail Table row -->
			</div>
			<div class="panel-footer">
				 <div class="pull-right">
                    <a class="btn btn-success" href="#"> {{ __('Assign Permission') }}</a>
                </div>
			</div>

        </div>
        <!-- . Panel Detail-->

    </div>
    <!-- . panel-group -->


    <div class="row col-md-12">

    </div>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="mdo">Open modal for @mdo</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="fat">Open modal for @fat</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="getbootstrap">Open modal for @getbootstrap</button>
...more buttons...

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>




    <div class="row col-md-12">
        <!-- Modal Update -->
        <div class="modal fade" id="updatePermissionModalOpt2" tabindex="-1" role="dialog" aria-labelledby="Update Permission" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{__('Permission')}} Option 2</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- <form action="{{ route( $master_model . '.update2Permission',[$role->id]) }}" method="post"> -->
                    <form action="{{ route( $master_model . '.update2Permission',$assignedPermissions->first()->id ) }}" method="post">
                        @csrf
                        @method('GET')
                        <div class="modal-body">

                            <input type="hidden" name="permission_id" value="{{$assignedPermissions->first()->id}}">
                            @include('access.roles.permission_form',['permission_name' => $permission->name, 'permission_description' => $permission->description ])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Permission</button>
                        </div>

                    </form>
                    
                </div>
            </div>
        </div>
    
    </div>


    </div>



@endsection

@section('javascripts')

    <script>
        $('#tableDetail').DataTable();

	    $('#updatePermissionModalOpt2').on('show.bs.modal', function (event) {
		    var button = $(event.relatedTarget)
		    var name = button.data('myname')
		    var description = button.data('mydescription')
		    var permission_id = button.data('mypermission_id')
		    var modal = $(this)

		    modal.find('.modal-body #nameOpt2').val(name);
		    modal.find('.modal-body #descriptionOpt2').val(description);
		    modal.find('.modal-body #permission_id').val(permission_id);
	    });
    </script>

    <script>
        $('#exampleModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          var modal = $(this)
          modal.find('.modal-title').text('New message to ' + recipient)
          modal.find('.modal-body input').val(recipient)
        });
    </script>


    <script>
        $('#modalSearch').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var masterModel = button.data('master_model') // Extract info from data-* attributes
          var roleIdSearch = button.data('roleid') // Extract info from data-* attributes
          var roleNameSearch = button.data('rolename') // Extract info from data-* attributes
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          var modal = $(this)

          modal.find('.modal-title').text( masterModel + ' Id: ' + roleIdSearch)

          modal.find('#searchParentIdFieldLabel').text(masterModel + '-Id:')
		
          modal.find('.modal-body #parent-id-field').val(roleIdSearch)
          modal.find('.modal-body #parent-name-field').val(roleNameSearch)

          // alert('call')
          // AJAX call
          var req = new XMLHttpRequest()
          req.responseType = 'json'
          req.open("GET","/foo",true)
          req.onload = function() {
              var testarray = req.responseType
              var content = "<ul>"
              for ( var testitem in testarray ) {
                  content += "<li>" + testitem + "</li>"
              }
              content += "</ul>"
              alert(content)
          }
          req.send(null)
          // alert('Exit call')

        });

    </script>




@endsection

@section('footer')
    <script>
        $('#permissionsSelected').select2({
            placeholder: 'Choose a tag'
        });

        $('#permissionsSelected2').select2({
            placeholder: 'Choose a tag',
            tags: true,
            data: [
                {'id': 'one', text: 'One'},
                {'id': 'two', text: 'Two'},
            ],
            ajax: {
                dataType: 'json', // return User::all(); Returned from Illuminate casted to JSON
                url: 'api/permissions',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    }
                }
            }
        });

        $('#permissionsSelected3').select2({
            placeholder: 'Choose a tag',
            tags: true,
            ajax: {
                dataType: 'json', // return User::all(); Returned from Illuminate casted to JSON
                // placed in the public directory
                url: 'permissions.json',
                processResults: function(data) {
                    return { results: data}
                }
            }
        });

        $('#permissionsSelected4').select2({
            placeholder: 'Choose a tag',
            tags: true,
            ajax: {
                dataType: 'json', // return User::all(); Returned from Illuminate casted to JSON
                url: 'api/permissions',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    }
                },
                processResults: function(data) {
                    return { results: data}
                }
            }
        });

    </script>
@endsection
