@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1 class="pull-left">Businesses</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('businesses.create') !!}">Add New</a>
           <a id= "calculate" onclick="calculateAndShowArea()" class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px; margin-right: 10px;">Calculate Area</a>
        </h1>
    </section>
    <div class="content">
    <hr style="border-width: 2px;">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-7 box-primary">
                <div class="box-body">
                        @include('businesses.table')
                </div>
            </div>
            <div class="col-md-5" id="map"></div>
        </div>
        
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="{{ URL::asset('js/gmaps.index.js') }}"></script>

@endsection

