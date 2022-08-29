<?php

declare(strict_types=1);

use Cortex\Oauth\Models\Client;
use Diglactic\Breadcrumbs\Generator;
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('frontarea.cortex.oauth.clients.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('frontarea.home');
    $breadcrumbs->push(trans('cortex/oauth::common.clients'), route('frontarea.cortex.oauth.clients.index'));
});

Breadcrumbs::for('frontarea.cortex.oauth.clients.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('frontarea.cortex.oauth.clients.index');
    $breadcrumbs->push(trans('cortex/oauth::common.create_client'), route('frontarea.cortex.oauth.clients.create'));
});

Breadcrumbs::for('frontarea.cortex.oauth.clients.edit', function (Generator $breadcrumbs, Client $client) {
    $breadcrumbs->parent('frontarea.cortex.oauth.clients.index');
    $breadcrumbs->push(strip_tags($client->name), route('frontarea.cortex.oauth.clients.edit', ['client' => $client]));
});

Breadcrumbs::for('frontarea.cortex.oauth.clients.auth_codes', function (Generator $breadcrumbs, Client $client) {
    $breadcrumbs->parent('frontarea.cortex.oauth.clients.edit', $client);
    $breadcrumbs->push(trans('cortex/oauth::common.auth_codes'), route('frontarea.cortex.oauth.clients.auth_codes', ['client' => $client]));
});

Breadcrumbs::for('frontarea.cortex.oauth.clients.access_tokens', function (Generator $breadcrumbs, Client $client) {
    $breadcrumbs->parent('frontarea.cortex.oauth.clients.edit', $client);
    $breadcrumbs->push(trans('cortex/oauth::common.access_tokens'), route('frontarea.cortex.oauth.clients.access_tokens', ['client' => $client]));
});
