@extends('backpack::layout')

@section('body_class', 'dashboard')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('pigarden.dashboard') }}</li>
      </ol>
    </section>
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
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-solid bg-gray-light">
                    <div class="box-body text-right">

                        <div class="pull-left wrp-pigarden-date-time">
                            <span id="pigarden-date-time">{{$date_time}}</span>
                        </div>


                        <div class="pull-right">

                            @if(backpack_user()->hasPermissionTo('manage cron zones', backpack_guard_name()))
                            <a class="btn btn-success" href="{{ route('zone.all_enable_cron') }}" onclick="return confirm('{{ trans('pigarden.confirm') }}')" title="{{ trans('pigarden.irrigation_enable_all_schduling') }}">
                                <i class="fa fa-clock-o"></i> <span class="hide">&nbsp;{{ trans('pigarden.irrigation_enable_all_schduling') }}</span>
                            </a>
                            @endif
                            @if(backpack_user()->hasPermissionTo('start stop zones', backpack_guard_name()))
                            <div class="btn-group">
                                <a class="btn btn-warning" href="{{ route('zone.all_stop') }}" onclick="return confirm('{{ trans('pigarden.confirm') }}')" title="{{ trans('pigarden.irrigation_stop_all') }}">
                                    <i class="fa fa-stop"></i> <span class="hide">&nbsp;{{ trans('pigarden.irrigation_stop_all') }}</span>
                                </a>
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-close-all" role="menu" style="right:0; left:auto;">
                                    <li><a href="{{ route('zone.all_stop') }}" onclick="return confirm('{{ trans('pigarden.confirm') }}')"><i class="fa fa-stop"></i> {{ trans('pigarden.irrigation_stop_all') }}</a></li>
                                    @if(backpack_user()->hasPermissionTo('manage cron zones', backpack_guard_name()))
                                    <li><a href="{{ route('zone.all_stop', ['disable_scheduling' => 'disable_scheduling']) }}" onclick="return confirm('{{ trans('pigarden.confirm') }}')"><i class="fa fa-clock-o"></i> {{ trans('pigarden.irrigation_stop_all_and_disable_scheduled') }}</a></li>
                                    @endif
                                </ul>
                            </div>
                            @endif
                            @if(backpack_user()->hasPermissionTo('shutdown restart', backpack_guard_name()))
                            <div class="btn-group">
                                <a class="btn btn-danger" href="{{ route('reboot') }}" onclick="return confirm('{{ trans('pigarden.confirm') }}')" title="{{ trans('pigarden.system_reboot') }}">
                                    <i class="fa fa-power-off"></i> <span class="hide">&nbsp;{{ trans('pigarden.system_reboot') }}</span>
                                </a>
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-reboot" role="menu" style="right:0; left:auto;">
                                    <li><a href="{{ route('reboot') }}" onclick="return confirm('{{ trans('pigarden.confirm') }}')"><i class="fa fa-refresh"></i> {{ trans('pigarden.system_reboot') }}</a></li>
                                    <li><a href="{{ route('poweroff') }}" onclick="return confirm('{{ trans('pigarden.confirm') }}')"><i class="fa fa-power-off"></i> {{ trans('pigarden.system_shutdown') }}</a></li>
                                </ul>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
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

    <div class="row" id="vue-sensor" v-if="sensor">
        <div class="col-md-12" v-for="(sensor_item, sensor_name) in sensor">
            <div class="box box-warning">
                <div class="box-header with-border text-center">
                    <div class="box-title">{{trans('pigarden.sensor')}}: <strong>@{{ sensor_name.replace('_', ' ') }}</strong></div>
                </div>
                <div class="box-body">

                    <div class="row text-center">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-right">
                                    <i class="fa fa-tint" aria-hidden="true" style="font-size: 3em; color: #0b58a2"></i>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-left">
                                    <div class="weather-text">
                                        {{ trans('pigarden.moisture') }} <strong><span>@{{ sensor_item.moisture }}</span></strong> %
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-right">
                                    <i class="fa fa-thermometer-half" aria-hidden="true" style="font-size: 3em; color: #ff6a00"></i>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-left">
                                    <div class="weather-text">
                                        {{ trans('pigarden.temp_c') }} <strong><span>@{{ sensor_item.temperature }}</span></strong> C°
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-right">
                                    <i class="fa fa-pagelines" aria-hidden="true" style="font-size: 3em; color: #32bb1b"></i>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-left">
                                    <div class="weather-text">
                                        {{ trans('pigarden.fertility') }} <strong><span>@{{ sensor_item.fertility }}</span></strong> us/cm
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-right">
                                    <i class="fa fa-sun-o" aria-hidden="true" style="font-size: 3em; color: #f6dc27"></i>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 box-weather text-left">
                                    <div class="weather-text">
                                        {{ trans('pigarden.illuminance') }} <strong><span>@{{ sensor_item.illuminance }}</span></strong> lx
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('after_scripts')
    <script src="{{ asset('js/vue2.js') }}"></script>
    <script src="{{ asset('js/base.js') }}"></script>
    <script>
        var urlJsonDashboardStatus = "{{ route('get.json.dashboard.status') }}";
        var timeoutJsonDashboardStatus = {{ config('pigarden.timeout_json_dashboard_status') }};
    </script>
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
