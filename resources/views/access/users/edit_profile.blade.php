<!--
    Profile Fields Edition
    Requirements:
        - Boostrap
    This file can be included from a master FORM
-->
<!-- Name -->
<div class="form-group row col-md-12">
	<label for="first_name" class="col-form-label">{{ __('First Name') }}*</label>

    <!--
        Validation Error Display with ERROR Directive
        Requires:
            conditional format: class="is-invalid" -> @error('first_name') is-invalid @enderror
            extra span to display the error:
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
    -->
	<input type="text" class="form-control @error('first_name') is-invalid @enderror"
        id="first_name" name="first_name" value="{{ old('first_name') ? old('first_name') : $profileInfo->first_name }}">
        <!-- New Directive Option -->
        @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ __( $message ) }}</strong>
            </span>
        @enderror
        <!-- Previous Option -->
        @if ($errors->has('first_name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ __($errors->first('first_name')) }}</strong>
            </span>
        @endif
</div>								
<!-- . Name -->

<!-- Last Name -->
<div class="form-group row col-md-12">
	<label for="last_name" class="col-form-label">{{ __('Last Name') }}*</label>
	<input type="text" class="form-control @error('last_name') is-invalid @enderror"
        id="last_name" name="last_name" value="{{ old('last_name') ? old('last_name') : $profileInfo->last_name }}">
        @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>								
<!-- . Last Name -->

<!-- Email -->
<div class="form-group row">
    <div class="col-md-6">
		<label for="usernameProf" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>
		<input type="text" class="form-control" id="usernameProf" name="usernameProf" value="{{ old('usernameProf') ? old('usernameProf') : $user->username }}" readonly>
    </div>

    <!-- Example using add-on buttons -->
    <div class="col-md-6">
        <label for="email2" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
        <div class="input-group">
            <input id="email2" type="email" class="form-control" name="email2" value="{{ old('email2') ? old('email2') : $profileInfo->email }}" autocomplete="email2" readonly>
            <div class="input-group-append">
                <span class="input-group-text">usr@srv.com</span>
            </div>
        </div>
        <!-- Laravel Validation -->
        @error('email2')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<!-- . Email -->

