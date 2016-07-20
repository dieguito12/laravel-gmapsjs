@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Business
        </h1>
   </section>
   <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($business, ['route' => ['businesses.update', $business['id']], 'method' => 'patch']) !!}

                        @include('businesses.fields')

                   {!! Form::close() !!}
               </div>
           </div>
           <div class="col-md-6" id="map"></div>
       </div>
   </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="{{ URL::asset('js/gmaps.add.js') }}"></script>
@endsection