@extends('access.roles.layout')

@section('header_styles')

@endsection



@section('content')


<div class="container">

    <h3 class="page-title">{{ __('Edit Roles') }}</h3>
    <div class="panel-group">

        <!-- Panel Header -->
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ __('Roles') }}
			</div>
			<div class="panel-body">
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
			<div class="panel-footer">
				{{ __('Roles') }}
			</div>
        </div>
        <!-- . Panel Header -->

        <!-- Panel Detail -->
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ __('Assigned Roles') }}
			</div>
			<div class="panel-body">
                <!-- Detail Table Information -->
                <div class="row">
		            <table id="tableDetail" class="table table-bordered table-hover {{ count($permissions) > 0 ? 'dataTable' : '' }}">
			            <thead>
				            <tr>
					            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
					            <th>{{ __('Assigned Permissions') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Related Roles') }}</th>

					            <th>{{ __('Action') }}</th>
				            </tr>
			            </thead>
			            <tbody>
				            @foreach ($permissions as $permission)
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
				            @foreach ($permissions as $permission)
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
	                                        data-nameOpt2="{{$permission->name}}" 
	                                        data-mydescription="{{$permission->name}}"
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
    <div class="row col-md-12">


    </div>

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

                    <!-- <form action="{{ route( $master_model . '.update2Permission',[$role->id]) }}" method="post">
                    -->
                    <form action="{{ route( $master_model . '.update2Permission',$permission->id) }}" method="post">
                        @csrf
                        @method('GET')
                        <div class="modal-body">

                            <input type="hidden" name="permission_id" value="{{$permission->id}}">

                            @include('access.roles.permission_form',['permission_name'=> $permission->name ])

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Permission</button>
                        </div>

                    </form>


                </div>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
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
</div>

    		
</div>



@endsection

@section('javascripts')


    <script>
        $(document).ready(function () {
            $.noConflict();
            var table = $('#tableDetail').DataTable();

        });
    </script>

    <script>
	    $('#updatePermissionModalOpt2').on('show.bs.modal', function (event) {
		    var button = $(event.relatedTarget)
		    var name = button.data('nameOpt2')
		    var description = button.data('mydescription')
		    var permission_id = button.data('mypermission_id')
		    var modal = $(this)
		
		    modal.find('.modal-body #nameOpt2').val(name);
		    modal.find('.modal-body #descriptionOpt2').val(description);
		    modal.find('.modal-body #permission_id').val(permission_id);
            alert('in9');
	    });
    </script>

    <script>
        $('#exampleModal').on('show.bs.modal', function (event) {
            alert('loaded');
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          var modal = $(this)
          modal.find('.modal-title').text('New message to ' + recipient)
          modal.find('.modal-body input').val(recipient)
        });

    </script>


@endsection
