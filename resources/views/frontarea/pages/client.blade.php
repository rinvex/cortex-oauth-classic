{{-- Master Layout --}}
@extends('cortex/foundation::frontarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\OAuth\Http\Requests\Frontarea\ClientFormRequest::class)->selector("#frontarea-cortex-oauth-clients-create-form, #frontarea-cortex-oauth-clients-{$client->getRouteKey()}-update-form")->ignore('.skip-validation') !!}
@endpush

{{-- Main Content --}}
@section('content')

    @includeWhen($client->exists, 'cortex/foundation::common.partials.modal', ['id' => 'delete-confirmation'])

    <div class="container">

        <div class="row profile">
            <div class="col-md-3">
                @include('cortex/auth::frontarea.partials.sidebar')
            </div>

            <div class="col-md-9">

                <div class="profile-content">

                    <nav aria-label="breadcrumb">
                        {{ Breadcrumbs::render() }}
                    </nav>

                    <div class="nav-tabs-custom">
                        {!! Menu::render('frontarea.cortex.oauth.clients.tabs', 'nav-tab') !!}

                        <div class="tab-content">

                            <div class="tab-pane active" id="frontarea-cortex-oauth-clients-{{ $client->exists ? $client->getRouteKey().'-' : '' }}tab">

                                @if ($client->exists)
                                    {{ Form::model($client, ['url' => route('frontarea.cortex.oauth.clients.update', ['client' => $client]), 'method' => 'put', 'id' => "frontarea-cortex-oauth-clients-{$client->getRouteKey()}-update-form", 'files' => true]) }}
                                @else
                                    {{ Form::model($client, ['url' => route('frontarea.cortex.oauth.clients.store'), 'id' => 'frontarea-cortex-oauth-clients-create-form', 'files' => true]) }}
                                @endif

                                <div class="row">

                                    <div class="col-md-{{ $client->exists ? 12 : 8 }}">

                                        <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                                            {{ Form::label('name', trans('cortex/oauth::common.name'), ['class' => 'control-label']) }}
                                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/oauth::common.name'), 'required' => 'required']) }}

                                            <span class="form-text text-muted">{{ trans('cortex/oauth::common.name_info') }}</span>

                                            @if ($errors->has('name'))
                                                <span class="help-block">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>

                                    </div>


                                    @if (! $client->exists)

                                        <div class="col-md-4">

                                            {{-- Grant Type --}}
                                            <div class="form-group{{ $errors->has('grant_type') ? ' has-error' : '' }}">
                                                {{ Form::label('grant_type', trans('cortex/oauth::common.grant_type'), ['class' => 'control-label']) }}
                                                {{ Form::select('grant_type', $grantTypes, null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'required' => 'required']) }}

                                                @if ($errors->has('grant_type'))
                                                    <span class="help-block">{{ $errors->first('grant_type') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                    @endif

                                </div>

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group has-feedback{{ $errors->has('redirect') ? ' has-error' : '' }}">
                                            {{ Form::label('redirect', trans('cortex/oauth::common.redirect'), ['class' => 'control-label']) }}
                                            {{ Form::text('redirect', null, ['class' => 'form-control', 'placeholder' => trans('cortex/oauth::common.redirect'), 'required' => 'required']) }}

                                            <span class="form-text text-muted">{{ trans('cortex/oauth::common.redirect_info') }}</span>

                                            @if ($errors->has('redirect'))
                                                <span class="help-block">{{ $errors->first('redirect') }}</span>
                                            @endif
                                        </div>

                                    </div>

                                </div>

                                @if (! $client->exists)

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group has-feedback{{ $errors->has('is_confidential') ? ' has-error' : '' }}">
                                                {{ Form::label('is_confidential', trans('cortex/oauth::common.is_confidential'), ['class' => 'control-label']) }}
                                                {{ Form::select('is_confidential', [1 => trans('cortex/oauth::common.yes'), 0 => trans('cortex/oauth::common.no')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'required' => 'required']) }}

                                                <span class="form-text text-muted">{{ trans('cortex/oauth::common.is_confidential_info') }}</span>

                                                @if ($errors->has('is_confidential'))
                                                    <span class="help-block">{{ $errors->first('is_confidential') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>

                                @endif

                                <div class="row">
                                    <div class="col-md-12 text-center profile-buttons">
                                        {{ Form::button('<i class="fa fa-save"></i> '.trans('cortex/oauth::common.save'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}

                                        @if($client->exists && request()->user()->can('revoke', $client))
                                            <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                                               data-modal-action="{{ route('frontarea.cortex.oauth.clients.revoke', ['client' => $client]) }}"
                                               data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                                               data-modal-button="<a href='#' class='btn btn-danger' data-form='put' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.revoke') }}</a>"
                                               data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/oauth::common.client'), 'identifier' => $client->getRouteKey()]) }}"
                                               title="{{ trans('cortex/foundation::common.revoke') }}" class="btn btn-warning btn-flat" style="margin: 4px"><i class="fa fa-times text-warning"></i> {{ trans('cortex/foundation::common.revoke') }}
                                            </a>
                                        @endif

                                        @if($client->exists && request()->user()->can('delete', $client))
                                            <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                                               data-modal-action="{{ route('frontarea.cortex.oauth.clients.destroy', ['client' => $client]) }}"
                                               data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                                               data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                                               data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/oauth::common.client'), 'identifier' => $client->getRouteKey()]) }}"
                                               title="{{ trans('cortex/foundation::common.delete') }}" class="btn btn-danger btn-flat" style="margin: 4px"><i class="fa fa-trash text-danger"></i> {{ trans('cortex/foundation::common.delete') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                {{ Form::close() }}


                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
