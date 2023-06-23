<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;

Broadcast::channel('cortex.oauth.clients.index', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.client'));
});

Broadcast::channel('cortex.oauth.clients.auth_codes', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.auth_code'));
});

Broadcast::channel('cortex.oauth.clients.access_tokens', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.access_token'));
});

Broadcast::channel('cortex.auth.admins.clients', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.client'));
});

Broadcast::channel('cortex.auth.admins.auth_codes', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.auth_code'));
});

Broadcast::channel('cortex.auth.admins.access_tokens', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.access_token'));
});

Broadcast::channel('cortex.auth.members.clients', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.client'));
});

Broadcast::channel('cortex.auth.members.auth_codes', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.auth_code'));
});

Broadcast::channel('cortex.auth.members.access_tokens', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.access_token'));
});
