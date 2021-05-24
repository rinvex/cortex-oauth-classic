{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\OAuth\Http\Requests\Adminarea\ClientFormRequest::class)->selector("#adminarea-cortex-oauth-create-form, #adminarea-cortex-oauth-{$client->getRouteKey()}-update-form")->ignore('.skip-validation') !!}
@endpush

{{-- Main Content --}}
@section('content')

    @includeWhen($client->exists, 'cortex/foundation::adminarea.partials.modal', ['id' => 'delete-confirmation'])

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">

                @if($client->exists && (request()->user()->can('revoke', $client) || request()->user()->can('delete', $client) || request()->user()->can('create', $client)))
                    <div class="pull-right">

                        @if (request()->user()->can('create', $client))
                            <a href="{{ route('adminarea.cortex.oauth.clients.create', ['replicate' => $client->getRouteKey()]) }}" title="{{ trans('cortex/foundation::common.replicate') }}" class="btn btn-default" style="margin: 4px"><i class="fa fa-clone text-default"></i></a>
                        @endif

                        @if(request()->user()->can('revoke', $client))
                            <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                               data-modal-action="{{ route('adminarea.cortex.oauth.clients.revoke', ['client' => $client]) }}"
                               data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                               data-modal-button="<a href='#' class='btn btn-danger' data-form='put' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.revoke') }}</a>"
                               data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/oauth::common.client'), 'identifier' => $client->getRouteKey()]) }}"
                               title="{{ trans('cortex/foundation::common.revoke') }}" class="btn btn-warning" style="margin: 4px"><i class="fa fa-times text-warning"></i>
                            </a>
                        @endif

                        @if(request()->user()->can('delete', $client))
                            <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                               data-modal-action="{{ route('adminarea.cortex.oauth.clients.destroy', ['client' => $client]) }}"
                               data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                               data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                               data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/oauth::common.client'), 'identifier' => $client->getRouteKey()]) }}"
                               title="{{ trans('cortex/foundation::common.delete') }}" class="btn btn-danger" style="margin: 4px"><i class="fa fa-trash text-danger"></i>
                            </a>
                        @endif

                    </div>
                @endif

                {!! Menu::render('adminarea.cortex.oauth.clients.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                            @if ($client->exists)
                                {{ Form::model($client, ['url' => route('adminarea.cortex.oauth.clients.update', ['client' => $client]), 'method' => 'put', 'id' => "adminarea-cortex-oauth-clients-{$client->getRouteKey()}-update-form", 'files' => true]) }}
                            @else
                                {{ Form::model($client, ['url' => route('adminarea.cortex.oauth.clients.store'), 'id' => 'adminarea-cortex-oauth-clients-create-form', 'files' => true]) }}
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
                                <div class="col-md-12">

                                    <div class="pull-right">
                                        {{ Form::button(trans('cortex/oauth::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                    </div>

                                    @include('cortex/foundation::adminarea.partials.timestamps', ['model' => $client])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
