@extends('access.roles.layout')

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

            <div class="row">
                <div class="col-xs-12 form-group">
					<label class="control-label">{{ __('Description') }}*</label>
					<div class="form-control">
						{{ $role->description }}
					</div>
                </div>
            </div>

			
            <div class="row">
                <div class="col-xs-12 form-group">
					<label class="control-label">{{ __('Role Permissions') }}*
                    <span class="badge badge-info">{{ count($permissions->pluck('name') ) }}</span>
                    </label>
					<div class="form-control">
						@foreach ($permissions->pluck('name') as $permission)
							<span class="label label-info label-many">{{ $permission }}</span>
						@endforeach
					</div>


                </div>
            </div>

            <!-- Only displays Information if the Role has Permissions assigned -->
            @unless( $role->permissions->isEmpty() )

            <div class="panel panel-primary">
                <div class="panel-heading">{{ __('Role Permissions') }} <span class="badge badge-info">{{ count($permissions->pluck('name') ) }}</span>
                </div>

                    <div class="panel-body">
                        <dl class="row">
					        @foreach ($permissions as $permission)
                                <dt class="col-sm-3">{{ $permission->name }}</dt>
                                <dd class="col-sm-9">{{ $permission->description }}</dd>
					        @endforeach
                        </dl>

                        <dl class="row">
					        @foreach ($permissions as $permission)
                                <dt class="col-sm-3">{{ $permission->name }}</dt>
                                <dd class="col-sm-9">{{ $permission->description }}</dd>
					        @endforeach
                        </dl>

                    </div>

            </div>

            @endunless()
            
        </div>
    </div>

	<form method="GET" action="javascript:history.back()">
		<button type="submit" class="btn btn-info"> {{ __('Back') }}</button>
	</form>
</div>	
	
@endsection

