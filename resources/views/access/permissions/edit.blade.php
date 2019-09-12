@extends('access.permissions.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('Edit Permission') }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="javascript:history.back()"> {{ __('Back') }}</a>
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> {{ __('There were some problems with your input.') }}<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('permissions.update',$permission->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('Permission Name') }}</strong>
                <input type="text" name="name" value="{{ $permission->name }}" class="form-control" placeholder="Name">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('Guard Name') }}</strong>
                <input type="text" name="guard_name" value="{{ $permission->guard_name }}" class="form-control" placeholder="Guard Name">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('Description') }}</strong>
                <textarea class="form-control" style="height:150px" name="description" value="{{ $permission->description }}" placeholder="{{ __('Description') }}">{{ $permission->description }}</textarea>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        </div>
    </div>
</form>
@endsection
