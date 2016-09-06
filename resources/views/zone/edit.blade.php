@extends('backpack::layout')

@section('body_class', 'zone-edit')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('pigarden.zone') . ' ' . $zone->name_stripped }}<small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('pigarden.zone')  . ' ' . $zone->name_stripped}}</li>
      </ol>
    </section>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset("css/pigarden.css") }}">
    <link href="{{ asset('css/icheck/line/blue.css') }}" rel="stylesheet">
@endsection

@section('content')

    @if(!empty($error->description))
    <div class="callout callout-danger lead">
        <h4>PiGarden server error</h4>
        <pre><?php print_r($error) ?></pre>
    </div>
    @endif

    @if(!empty($zone))
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('_partials.zone', ['zone' => $zone, 'force' => true])
        </div>
    </div>
    @endif
@endsection

@section('after_scripts')
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script src="{{ asset('js/base.js') }}"></script>
    <script>
    $(document).ready(function(){
        $('.btn-zone').click(function(e){
            var btn = $(this);
            var id=$(btn).prop('id').replace('btn-zone-', '');
            var url = btn.attr('href');
            if(url.indexOf('/play/')>=0 && $($('.force_open').get(0)).prop('checked')){
                url = url + '/force';
            }
            $.ajax({
                type : "GET",
                url : url,
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

        $('input.icheck').each(function(){
            var self = $(this),
            label = self.next(),
            label_text = label.text();

            label.remove();
            self.iCheck({
                checkboxClass: 'icheckbox_line-blue',
                radioClass: 'iradio_line-blue',
                insert: '<div class="icheck_line-icon"></div>' + label_text
            });

/*
            $(this).on('ifChecked', function(event){
              $(this).prop('checked', true);
            });
            $(this).on('ifUnchecked', function(event){
              $(this).prop('checked', false);
            });
*/

        });
    });

    </script>
@endsection