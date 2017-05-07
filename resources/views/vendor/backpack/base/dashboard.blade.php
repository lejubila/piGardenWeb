@extends('backpack::layout')

@section('body_class', 'dashboard')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('pigarden.dashboard') }}<small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('pigarden.dashboard') }}</li>
      </ol>
    </section>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset("css/pigarden.css") }}">
@endsection

@section('content')

    @if(!empty($error->description))
    <div class="callout callout-danger lead">
        <h4>PiGarden server error</h4>
        <pre><?php print_r($error) ?></pre>
    </div>
    @endif

    @if(!empty($zones) && $zones->count() > 0)
    <div class="row">
    @foreach($zones->chunk(3) as $chunk)
        @foreach($chunk as $id => $zone)
        <div class="col-md-4 col-sm-6 col-xs-12">
            @include('_partials.zone', ['zone' => $zone])
        </div>
        @endforeach
    @endforeach
    </div>
    @endif

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border text-center">
                    <div class="box-title">{{ trans('pigarden.last_rain_sensor') }}</div>
                </div>
                <div class="box-body text-center" id="last_rain_sensor">{{$last_rain_sensor}}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border text-center">
                    <div class="box-title">{{ trans('pigarden.last_rain_online') }}</div>
                </div>
                <div class="box-body text-center" id="last_rain_online">{{$last_rain_online}}</div>
            </div>
        </div>
    </div>

    @if(!empty($weather))
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border text-center">
                    <div class="box-title">{{trans('pigarden.weather_conditions')}} (<span id="observation_time">{{$weather->observation_time}}</span>)</div>
                </div>
                <div class="box-body">

                    <div class="row text-center">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-right">
                                    <img id="icon_url" src="{{ $weather->icon_url }}" alt="{{ $weather->weather }}" />
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-left">
                                    <div class="weather-text">
                                        @if(!empty($weather->weather))
                                        <strong><span id="weather">{{ $weather->weather }}</span></strong>
                                        <br/>
                                        @endif
                                        {{ trans('pigarden.temp_c') }} <strong><span id="temp_c">{{ $weather->temp_c }}</span></strong> C°
                                        <br/>
                                        {{ trans('pigarden.feelslike_c') }} <strong><span id="feelslike_c">{{ $weather->feelslike_c }}</span></strong> C°
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-right">
                                    <div id="curWind">
                                        <div id="windCompassContainer">
                                            <div id="windCompass" class="wx-data" style="transform:rotate({{$weather->wind_degrees}}deg);-ms-transform:rotate({{$weather->wind_degrees}}deg);-webkit-transform:rotate({{$weather->wind_degrees}}deg);">
                                                <div class="dial">
                                                    <div class="arrow-direction"></div>
                                                </div>
                                            </div>
                                            <div id="windN">N</div>
                                            <div id="windCompassSpeed" class="wx-data" >
                                                <span class="wx-value" id="wind_kph">{{$weather->wind_kph}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-left">
                                    <div class="weather-text">
                                        {{ trans('pigarden.wind_dir') }} <strong><span id='wind_dir'>{{ $weather->wind_dir }}</span></strong>
                                        <br/>
                                        {{ trans('pigarden.wind_gust_kph') }} <strong><span id='wind_gust_kph'>{{$weather->wind_gust_kph}}</span></strong> km/h
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 box-weather weather-text">
                            {{ trans('pigarden.pressure_mb') }} <strong><span id='pressure_mb'>{{ $weather->pressure_mb }}</span></strong> hPa
                            <br/>
                            {{ trans('pigarden.relative_humidity') }} <strong><span id='relative_humidity'>{{ $weather->relative_humidity }}</span></strong>
                            <br/>
                            {{ trans('pigarden.dewpoint_c') }} <strong><span id='dewpoint_c'>{{ $weather->dewpoint_c }}</span></strong> C°
                        </div>

                    </div>

                    <?php //echo '<pre>'; print_r($status); echo '</pre>'; ?>

                </div>
            </div>
        </div>
    </div>
    @endif

@endsection

@section('after_scripts')
    <script src="{{ asset('js/base.js') }}"></script>
    <script src="{{ asset('js/backend.js') }}"></script>
    <script>

    $(document).ready(function(){
        $('.btn-zone, .btn-zone-open-in, .btn-zone-open-in-cancel').click(function(e){
            var btn = $(this);
            var id;

            if(btn.hasClass('btn-zone-open-in') || btn.hasClass('btn-zone-open-in-cancel')){
                id = $(btn.parents('.btn-group-zone').find('.btn-zone')).prop('id').replace('btn-zone-', '');
            } else {
                id = $(btn).prop('id').replace('btn-zone-', '');
            }

            $.ajax({
                type : "GET",
                url : btn.attr('href'),
                dataType: 'json',
                beforeSend: function(jqXHR) {
                    $('#box-zone-'+id).append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    updateZones(data);
                    updateNotify(data);
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    callBackAjaxError(jqXHR, textStatus, errorThrown);
                },
                complete: function(jqXHR, textStatus){
                    $('#box-zone-'+id+' .overlay').remove();
                }
            });

            e.preventDefault();
        });
    });

    </script>
@endsection
