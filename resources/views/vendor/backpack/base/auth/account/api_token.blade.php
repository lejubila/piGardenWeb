@extends('backpack::layout')

@section('after_styles')
<style media="screen">
    .backpack-profile-form .required::after {
        content: ' *';
        color: red;
    }
</style>
@endsection

@section('header')
<section class="content-header">

    <h1>
        {{ trans('backpack::base.my_account') }}
    </h1>

    <ol class="breadcrumb">

        <li>
            <a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a>
        </li>

        <li>
            <a href="{{ route('backpack.account.info') }}">{{ trans('backpack::base.my_account') }}</a>
        </li>

        <li class="active">
            {{ trans('backpack::base.update_account_info') }}
        </li>

    </ol>

</section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('backpack::auth.account.sidemenu')
    </div>
    <div class="col-md-6">

        <form class="form" action="{{ route('backpack.account.api_token') }}" method="post">

            {!! csrf_field() !!}

            <div class="box padding-10">

                <div class="box-body backpack-profile-form">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->count())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        @php
                            $label = trans('backpack::base.name');
                            $field = 'name';
                        @endphp
                        <label>Api Token</label>
                        <input class="form-control" type="text" name="api_token" value="{{ $user->api_token }}" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label>{{__('Action')}}</label>
                        <select name="action_api_token" class="form-control">
                            <option value=""></option>
                            <option value="remove_token">{{__('Remove token')}}</option>
                            <option value="regenerate_token">{{__('Generate new token')}}</option>
                        </select>
                    </div>

                    <div class="form-group m-b-0">
                        <button type="submit" class="btn btn-success"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::base.save') }}</span></button>
                        <a href="{{ backpack_url() }}" class="btn btn-default"><span class="ladda-label">{{ trans('backpack::base.cancel') }}</span></a>
                    </div>

                </div>
            </div>

        </form>

    </div>
</div>
@endsection
