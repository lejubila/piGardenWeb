<?php
//$fields = new stdClass();
//$fields->email;

?>


@if (Session::has('message'))
    <br /><h1>{{Session::get('message')}}</h1><br />
@endif

{!! Form::open(['route' => 'prova.post']) !!}


{!! Form::text('open["email"][1]', 'open1@default.it') !!} <br/>
{!! Form::text('open["email"][2]', 'open2@default.it') !!} <br/>
{!! Form::text('open["nome"][1]', 'open1') !!} <br/>
{!! Form::text('open["nome"][2]', 'open2') !!} <br/>
<br/>
{!! Form::text('close["email"][1]', 'close@default.it') !!} <br/>
{!! Form::text('close["email"][2]', 'close2@default.it') !!} <br/>
{!! Form::text('close["nome"][1]', 'close1') !!} <br/>
{!! Form::text('close["nome"][2]', 'close2') !!} <br/>


<br/>
{!! Form::submit('Click Me!') !!}

{!! Form::close() !!}


LANG={{ env('LANG', 'it') }} <br>
LOCALE={{ env('LOCALE', 'it') }} <br>
PIGARDEN_TZ={{ env('PIGARDEN_TZ') }}