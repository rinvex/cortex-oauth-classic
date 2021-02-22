<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;

Broadcast::channel('cortex.oauth.clients.index', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.client'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.oauth.clients.auth_codes', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.auth_code'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.oauth.clients.access_tokens', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.access_token'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.auth.admins.index', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.client'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.auth.admins.auth_codes', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.auth_code'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.auth.admins.access_tokens', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.access_token'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.auth.manager.index', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.client'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.auth.manager.auth_codes', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.auth_code'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.auth.manager.access_tokens', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.access_token'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.auth.members.index', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.client'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.auth.members.auth_codes', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.auth_code'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.auth.members.access_tokens', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.access_token'));
}, ['guards' => ['admin']]);
