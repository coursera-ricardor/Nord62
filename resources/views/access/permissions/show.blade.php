@extends('access.permissions.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 5.8 CRUD Example</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('permissions.create') }}"> {{ __('Create New Permission') }}</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <h3 class="page-title">@lang('access.permissions.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body">
		
            <div class="row">
                <div class="col-xs-12 form-group">
					<label class="control-label">{{ __('Name') }}*</label>
					<div class="form-control">
						{{ $permission->name }}
					</div>
                </div>
            </div>
			
            <div class="row">
                <div class="col-xs-12 form-group">
					<label class="control-label">{{ __('Guard Name') }}*</label>
					<div class="form-control">
						{{ $permission->guard_name }}
					</div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
					<label class="control-label">{{ __('Description') }}</label>
					<div class="form-control">
						{{ $permission->description }}
					</div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
					<label class="control-label">{{ __('Roles*') }}</label>
					<div class="form-control">
						@foreach ($permission->roles()->pluck('name') as $role)
							<span class="label label-info label-many">{{ $role }}</span>
						@endforeach
					</div>
                </div>
            </div>
            
        </div>
    </div>

	<form method="GET" action="javascript:history.back()">
		<button type="submit" class="btn btn-info">{{ __('Back') }}</button>
	</form>


</div>
@endsection
