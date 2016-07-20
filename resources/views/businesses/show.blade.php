@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Business
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-md-4">
                    <div class="row" style="padding-left: 20px">
                        @include('businesses.show_fields')
                        <a href="{!! route('businesses.index') !!}" class="btn btn-default">Back</a>
                    </div>
                </div>
                <div style="width:800px; height:400px; " class="col-md-8" id="map"></div>
            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="{{ URL::asset('js/gmaps.show.js') }}"></script>
@endsection
