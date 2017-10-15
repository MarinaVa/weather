@extends('voyager::master')
@section('content')

@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

<div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body table-responsive">
                        <div class="margin-bottom-20">
                            {{ Form::open(['url' => 'admin/cities/save']) }}    
                                {!! csrf_field() !!}
                                {{ Form::text('city_name') }}
                                {{ Form::submit('Search') }}
                            {{ Form::close() }}
                        </div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
<?php

$headers = [ 'City ID','Name', 'Weather', 'Description', 'Temperature, °C', 'Pressure, hPa', 'Humidity, %', 'Wind Speed, m/s', 'Clouds', 'Created At', 'Updated At' ];

$attributes = ['class'=>'table table-hover dataTable no-footer', 'id' => 'dataTable', 'role' => 'grid'];

echo Table::generateTable($headers, $cities, $attributes);
?>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- Few Dynamic Styles -->
    <style type="text/css">
        .margin-bottom-20 {
            margin-bottom: 20px;
        }
    </style>    
@stop

