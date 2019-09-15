@extends('access.roles.layout')

@section('header_styles')

@endsection

@section('content')

<div class="container">

    <h3 class="page-title">{{ __('Roles Table') }}</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body">
		
            <div class="row">
                <div class="col-xs-12 form-group">
					<label class="control-label">{{ __('Role Name') }}*</label>
					<div class="form-control">
						{{ $role->name }}
					</div>
                </div>
            </div>

            <div class="row form-group">
				<label class="control-label col-sm-2">{{ __('Description') }}*</label>
				<div class="form-control col-sm-10">
					{{ $role->description }}
				</div>
            </div>

            <!-- Only displays Information if the Role has Permissions assigned -->
            @unless( $role->permissions->isEmpty() )

            <div class="row col-xs-12">
				<label class="control-label">{{ __('Role Permissions') }}*
                <span class="badge badge-info">{{ count($permissions->pluck('name') ) }}</span>
                </label>
            </div>

            <div>

   	            <table id="tableindex" class="table table-bordered table-hover {{ count($permissions) > 0 ? 'dataTable' : '' }}">
		            <thead>
			            <tr>
				            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Guard') }}</th>
                            <th>{{ __('Description') }}</th>
				            <th>{{ __('Related Roles') }}</th>
                            <th width="280px">{{ __('Action') }}</th>
			            </tr>
		            </thead>
		            <tbody>
			            @foreach ($permissions as $permission)
				            <tr data-entry-id="{{ $permission->id }}">
					            <td></td>
					            <td>
						            <a href="#">{{ $permission->name }}</a>
					            </td>

                                <td>{{ $permission->guard_name }}</td>

                                <td>{{ $permission->description }}</td>
						
					            <td>
                                    <span class="badge badge-info" >{{ count($permission->roles()->pluck('name')) }}</span>
					            </td>

                                <!-- Actions -->
					            <td>
						            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rolesWithPermission"
                                        data-permissionid="{{ $permission->name }}"
                                        data-permissiondescription="{{ $permission->description }}"
                                        data-roles="{{ $permission->roles()->get() }}"
                                    >{{ __('Show') }}</button>
					            </td>

				            </tr>
			            @endforeach
			
		            </tbody>
	            </table>

                <!-- Modal to Display Roles with the Permission -->
                <div class="modal " id="rolesWithPermission" tabindex="-1" role="dialog" aria-labelledby="rolesWithPermissionCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rolesWithPermissionLongTitle">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table id="tablerolesindex" class="table table-bordered table-hover dataTable">
			                        <thead>
				                        <tr>
					                        <th id="tbhname">{{ __('Name') }}</th>
                                            <th>{{ __('Description') }}</th>
				                        </tr>
			                        </thead>
			                        <tbody id="roledata">
				                        <tr>
						                    <td>
							                    role name 
						                    </td>
						                    <td>role description</td>
				                        </tr>
			                        </tbody>
		                        </table>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
				<!-- .Modal -->


            </div>            
            @endunless()

        </div>
        <!-- .panel body -->

        <!-- panel-footer -->
        <div class="panel-footer">
	        <form method="GET" action="javascript:history.back()">
		        <button type="submit" class="btn btn-info"> {{ __('Back') }}</button>
	        </form>
        </div>
        <!-- .panel-footer -->
    </div>
    <!-- .panel -->

</div>	
	
@endsection

<!-- Specific Scripts to the page to be yielded -->

@section('javascripts')
@endsection

@section('javascriptscode')
     <script>
        /*
            Display the permissions assigned to the role
        */
        $('#tableindex').DataTable();
    </script>

     <script>
        /*
            Display the roles associated to the Permission
            This functionality allows to verify common actions between roles
        */
        var mytable = $('#tablerolesindex').DataTable({
            columns: [
                {data: 'name' },
                {data: 'description' }
            ]

        })

        $('#rolesWithPermission').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var permissionId = button.data('permissionid')
            var permissionDescription = button.data('permissiondescription')
            var permissionRoles = button.data('roles')
            var mymodal = $(this)

            mymodal.find('.modal-title').text( "{{ __('Roles related to: ') }}" + permissionId)
            mymodal.find('.modal-body #tbhname').text("{{ __('Name') }}")

            /*
                Clear the Table Body and the search
            */
            // console.log(mytable.row(':eq(0)').data() )
            // console.log(permissionRoles )
            mytable.clear()
            mytable.search('')

            // Example adding a row to the table
            // mytable.row.add({'name' : 'nombre','description':'descripcion'})

            /*
                Add rows to the table
            */
            permissionRoles.forEach(function(item){
                // console.log(item.id)
                // console.log(item.name)
                // console.log(item.description)
                // mytable.row().add([item.name, item.description]).draw( false )
                mytable.row.add(item)
                /*
                mymodal.find('.modal-body #roledata')
                    .append('<tr>' +
                        '<td>' + item.name + '</td>' +
                        '<td>'+ item.description+ '</td>' +
                        '</tr>')
                */
            })

            // Re-Draw the table
            mytable.draw()


        })	
    </script>
	
@endsection
