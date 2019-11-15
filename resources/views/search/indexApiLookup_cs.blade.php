@extends('search.layout')


@section('header_styles')

@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel Search Example</h2>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <!-- dataTable Dynamic Server - Client Side -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" id="table_data_dynamic_v2">
                <!-- Dynamic Datable Here -->
            </div>
        </div>
    </div>


</div>
@endsection

@section('javascripts')

    <script>

        /*
         * Datatables Configuration
         *  Ajax Call - Client Side Configuration
         *      Render the Table after Success
         *      Each case is different, based on the Server Response.
        */
        $.ajax({
                url: "{{ route('api.search.countries.index') }}",
                headers: {
                    'CSRFToken' : '{{ csrf_token() }}'
                },
                success: function (response) {
                    var tableHeaders = '';
                    $.each(response.data[0], function (field_id, val) {
                        if (field_id != 'id') {
                            tableHeaders += "<th>" + field_id + "</th>";
                        }
                    });
                    // console.log(tableHeaders);

                    var columns = [];
                    $.each(response.data[0], function (key, value) {
                        var obj = { data: key, name: key };
                        columns.push(obj);
                    });
                    // console.log(columns);

                    //
                    // Datatable construction
                    //
                    $('#table_data_dynamic_v2').empty();
                    $('#table_data_dynamic_v2').append(
                        '<table id="dyn_v2_display" class="table table-bordered table-hover">' +
                        '<thead><tr>' +
				            '<th style="text-align:center;">' +
                            '<input type="checkbox" id="select-all" /></th>' +
                            tableHeaders + '</tr></thead>' +
                        '</table>'
                    );

                    $('#dyn_v2_display').dataTable({data: response.data, columns: columns});

                },
                function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                    $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                    console.log('jqXHR:');
                    console.log(jqXHR);
                    console.log('textStatus:');
                    console.log(textStatus);
                    console.log('errorThrown:');
                    console.log(errorThrown);
                },
            });

    </script>

	
@endsection
