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
						
						            <a href="#" class="btn btn-xs btn-info">{{ __('Show') }}</a>
					            </td>

				            </tr>
			            @endforeach
			
		            </tbody>
	            </table>
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

     <script>
        $('#tableindex').DataTable();
    </script>
	
@endsection
