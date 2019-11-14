@extends('search.layout')

@section('header_styles')

    <!-- Styles -->
    <!-- Multiselect --> 
@endsection

@section('content')


    <!-- Processing Messages from the Form -->
    <!-- todo: Add a Collapsable Box -->
    @if ($message = Session::get('errors'))
        <div class="alert alert-warning">
            <ul>
            @foreach ($message->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    <!-- Option 2 -->
    @if($errors->any())
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    @endif

    <div class="container">
        <h4>Laravel 6 Autocomplete Search using Bootstrap Typeahead JS - ItSolutionStuff.com</h4>
        <input class="typeahead form-control" type="text">
    </div>

    <!-- First Form Test, Only One Button -->
    <div class="container">
        <h2> First Form</h2>

        <form method="post" action="{{ route('search.lookup', array( $searchDefs['s_searchField'], 'searchField', 'name' ) ) }}">
            {{ csrf_field() }}

            <!--
                Control Search Variables
                field => Table
            -->
            @foreach($searchDefs as $searchDefkey => $searchDef)
                <input type="hidden" name="{{$searchDefkey}}" value="{{ $searchDef }}">
            @endforeach

            <!--
                Field to fill
            -->
            <div>
                <label for="Service">Service:</label>
                <input type="text" name="service" value="{{ old('service') }}">
            </div>
            <div>
                <label for="city">City:</label>
                <input type="text" name="city" value="{{ old('city') }}">
            </div>

            <div>
            <br>{{ $arrArray = implode(',',$searchDefs) }}
                <label for="searchField" class="col-md-6 col-form-label text-md-center">Table: {{ $searchDefs['s_searchField'] }}->Field: {{ substr('s_searchField',2 ) }}</label>
                <div class="input-group">
                    <input id="searchField" type="text" class="form-control" name="fieldToSearch" value="{{ old('searchField') ? old('searchField') : 'lookupFiled' }}" autocomplete="searchField">
                    <div class="input-group-append">
                        <div class="btn-group">
                            <a href="{{ route('search.lookup', array( $searchDefs['s_searchField'], 'searchField', 'description' ) ) }}"
                                class="btn btn-primary">{{ __('Search') }}
                                <i class="fas fa-search"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Laravel Validation -->
                @error('searchField')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

		    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

        </form>

        <h2> Second Form </h2>
        <form method="get" action="{{url('search/indexlookup')}}">
            {{csrf_field()}}
            <div>
                <label for="Service">Service:</label>
                <input type="text" name="service">
            </div>
            <div>
                <label for="city">City:</label>
                <input type="text" name="city">
            </div>

            <div>
                <label for="searchField" class="col-md-4 col-form-label text-md-right">{{ __('Field 2') }}</label>
                <div class="input-group">
                    <input id="searchField2" type="text" class="form-control" name="searchField" value="{{ old('searchField2') ? old('searchField2') : 'lookupFiled2' }}" autocomplete="searchField">
                    <div class="input-group-append">
                        <span class="input-group-text">usr@srv.com</span>
                    </div>
                </div>
                <!-- Laravel Validation -->
                @error('searchField2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

		    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>

        </form>

    <!--
            Initial Idea
    -->
        <hr>
        <form method="post" action="{{url('search/servicecity')}}">
            {{csrf_field()}}
            <div>
                <label for="Service">Service:</label>
                <input type="text" name="service">
            </div>
            <div>
                <label for="city">City:</label>
                <input type="text" name="city">
            </div>

            <div>
                <label for="searchField" class="col-md-4 col-form-label text-md-right">{{ __('Field 1') }}</label>
                <div class="input-group">
                    <input id="searchField" type="text" class="form-control" name="searchField" value="{{ old('searchField') ? old('searchField') : 'lookupFiled' }}" autocomplete="searchField">
                    <div class="input-group-append">
                        <span class="input-group-text">usr@srv.com</span>
                    </div>
                </div>
                <!-- Laravel Validation -->
                @error('searchField')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

		    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>

        </form>

        <form method="get" action="{{url('search/servicecitysearch')}}">
            {{csrf_field()}}
            <div>
                <label for="Service">Service:</label>
                <input type="text" name="service">
            </div>
            <div>
                <label for="city">City:</label>
                <input type="text" name="city">
            </div>

            <div>
                <label for="searchField" class="col-md-4 col-form-label text-md-right">{{ __('Field 1') }}</label>
                <div class="input-group">
                    <input id="searchField" type="text" class="form-control" name="searchField" value="{{ old('searchField') ? old('searchField') : 'lookupFiled' }}" autocomplete="searchField">
                    <div class="input-group-append">
                        <span class="input-group-text">usr@srv.com</span>
                    </div>
                </div>
                <!-- Laravel Validation -->
                @error('searchField')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

		    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>

        </form>



    </div>

@endsection


@section('javascripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

@endsection

@section('javascriptscode')


    <script type="text/javascript">

        var path = "{{ route('autocomplete') }}";

        $('input.typeahead').typeahead({
            source:  function (query, process) {
                return $.get(path, { query: query }, function (data) {
                        return process(data);
                    });
            }
        });

    </script>

@endsection
