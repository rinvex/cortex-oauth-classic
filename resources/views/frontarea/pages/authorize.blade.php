{{-- Master Layout --}}
@extends('cortex/foundation::frontarea.layouts.default')

{{-- Page Title --}}
@section('title')
{{--    {{ extract_title(Breadcrumbs::render()) }}--}}
@endsection

@section('body-attributes')class="auth-page"@endsection

{{-- Main Content --}}
@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-4 col-md-offset-4">

                <section class="auth-form">

                    {{ Form::open(['id' => 'frontarea-cortex-oauth-authorization-request-form', 'role' => 'auth']) }}

                        <div class="centered"><strong>{{ trans('cortex/oauth::common.authorization_request') }}</strong></div>

                        {{-- Client --}}
                        <p>{!! trans('cortex/oauth::common.permission_request', ['client' => $client->name]) !!}</p>

                        {{-- Scopes--}}
                        @if (count($scopes) > 0)
                            <div class="scopes" style="text-align: left">
                                <div><strong>{{ trans('cortex/oauth::common.client_will_access') }}</strong></div>
                                <ul>
                                    @foreach ($scopes as $scope)
                                        <li>{{ $scope->description }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        {{ Form::hidden('_method', 'POST', ['class' => 'skip-validation', 'id' => '_method']) }}
                        {{ Form::hidden('state', $request->state, ['class' => 'skip-validation', 'id' => 'state']) }}
                        {{ Form::hidden('client_id', $client->id, ['class' => 'skip-validation', 'id' => 'client_id']) }}
                        {{ Form::hidden('auth_token', $authToken, ['class' => 'skip-validation', 'id' => 'auth_token']) }}

                        <div class="row">
                            <div class="col-md-12">

                                <div class="pull-right">
                                    {{ Form::button(trans('cortex/oauth::common.approve'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit',  "onclick" => "event.preventDefault(); document.getElementById('_method').value = 'POST'; document.getElementById('frontarea-cortex-oauth-authorization-request-form').submit();"]) }}
                                    {{ Form::button(trans('cortex/oauth::common.deny'), ['class' => 'btn btn-danger btn-flat', 'type' => 'submit',  "onclick" => "event.preventDefault(); var _method = document.getElementById('_method'); _method.value = 'DELETE'; document.getElementById('frontarea-cortex-oauth-authorization-request-form').submit();"]) }}
                                </div>

                            </div>
                        </div>

                    {{ Form::close() }}

                </section>

            </div>

        </div>

    </div>

@endsection
