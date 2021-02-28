{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.auth')

{{-- Page Title --}}
@section('title')
{{--    {{ extract_title(Breadcrumbs::render()) }}--}}
@endsection

{{-- Main Content --}}
@section('content')

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('adminarea.home') }}"><b>{{ config('app.name') }}</b></a>
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('cortex/oauth::common.authorization_request') }}</p>

            {{-- Client --}}
            <p>{!! trans('cortex/oauth::common.permission_request', ['client' => $client->name]) !!}</p>

            {{-- Scopes--}}
            @if (count($scopes) > 0)
                <div class="scopes">
                    <p><strong>{{ trans('cortex/oauth::common.client_will_access') }}</strong></p>

                    <ul>
                        @foreach ($scopes as $scope)
                            <li>{{ $scope->title }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ Form::open(['id' => 'adminarea-authorization-request-form', 'role' => 'auth']) }}

                {{ Form::hidden('_method', 'POST', ['class' => 'skip-validation', 'id' => '_method']) }}
                {{ Form::hidden('state', $request->state, ['class' => 'skip-validation', 'id' => 'state']) }}
                {{ Form::hidden('client_id', $client->id, ['class' => 'skip-validation', 'id' => 'client_id']) }}
                {{ Form::hidden('auth_token', $authToken, ['class' => 'skip-validation', 'id' => 'auth_token']) }}

                <div class="row">
                    <div class="col-md-12">

                        <div class="pull-right">
                            {{ Form::button(trans('cortex/oauth::common.approve'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit',  "onclick" => "event.preventDefault(); document.getElementById('_method').value = 'POST'; document.getElementById('adminarea-authorization-request-form').submit();"]) }}
                            {{ Form::button(trans('cortex/oauth::common.deny'), ['class' => 'btn btn-danger btn-flat', 'type' => 'submit',  "onclick" => "event.preventDefault(); var _method = document.getElementById('_method'); _method.value = 'DELETE'; document.getElementById('adminarea-authorization-request-form').submit();"]) }}
                        </div>

                    </div>
                </div>

            {{ Form::close() }}

        </div>

    </div>

@endsection
