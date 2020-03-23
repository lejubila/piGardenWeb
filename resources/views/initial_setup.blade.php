@extends('backpack::layout')

@section('body_class', 'initial-setup')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('pigarden.initial_setup.title') }}<small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('pigarden.initial_setup.title') }}</li>
      </ol>
    </section>
@endsection

@section('before_styles')
@endsection

@section('after_styles')
    {{-- <link href="{{ asset("css/pigarden.css") }}" rel="stylesheet"> --}}
@endsection

@section('content')

    @if(!empty($error->description))
    <div class="callout callout-danger lead">
        <h4>PiGarden server error</h4>
        <pre><?php print_r($error) ?></pre>
    </div>
    @else
        @include('_partials.errors')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="box box-primary box-info">
                <div class="box-body">
                    {{-- !! Form::open(['route' => ['initial_setup.post']]) !! --}}
                    <form action="{{route('initial_setup.post')}}" method="POST">
                        {{ csrf_field() }}
                        <p><i>{{trans('pigarden.initial_setup.description')}}</i></p>
                        <ul>
                            @foreach(trans('pigarden.initial_setup.description_elements') as $t)
                            <li>{{$t}}</li>
                            @endforeach
                        </ul>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-cogs"></i>&nbsp; {{trans('pigarden.initial_setup.confirm')}}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @endif

@endsection

@section('after_scripts')
    <script src="{{ asset('js/base.js') }}"></script>
    <script>
        var urlJsonDashboardStatus = "{{ route('get.json.dashboard.status') }}";
        var timeoutJsonDashboardStatus = {{ config('pigarden.timeout_json_dashboard_status') }};
    </script>
    <script src="{{ asset('js/backend.js') }}"></script>
@endsection
