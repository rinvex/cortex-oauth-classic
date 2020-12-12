<?php

declare(strict_types=1);

use Cortex\OAuth\Models\Client;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('frontarea.cortex.oauth.clients.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('frontarea.home'));
    $breadcrumbs->push(trans('cortex/oauth::common.clients'), route('frontarea.cortex.oauth.clients.index'));
});

Breadcrumbs::register('frontarea.cortex.oauth.clients.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('frontarea.cortex.oauth.clients.index');
    $breadcrumbs->push(trans('cortex/oauth::common.create_client'), route('frontarea.cortex.oauth.clients.create'));
});

Breadcrumbs::register('frontarea.cortex.oauth.clients.edit', function (BreadcrumbsGenerator $breadcrumbs, Client $client) {
    $breadcrumbs->parent('frontarea.cortex.oauth.clients.index');
    $breadcrumbs->push(strip_tags($client->name), route('frontarea.cortex.oauth.clients.edit', ['client' => $client]));
});

Breadcrumbs::register('frontarea.cortex.oauth.clients.auth_codes', function (BreadcrumbsGenerator $breadcrumbs, Client $client) {
    $breadcrumbs->parent('frontarea.cortex.oauth.clients.edit', $client);
    $breadcrumbs->push(trans('cortex/oauth::common.auth_codes'), route('frontarea.cortex.oauth.clients.auth_codes', ['client' => $client]));
});

Breadcrumbs::register('frontarea.cortex.oauth.clients.access_tokens', function (BreadcrumbsGenerator $breadcrumbs, Client $client) {
    $breadcrumbs->parent('frontarea.cortex.oauth.clients.edit', $client);
    $breadcrumbs->push(trans('cortex/oauth::common.access_tokens'), route('frontarea.cortex.oauth.clients.access_tokens', ['client' => $client]));
});
