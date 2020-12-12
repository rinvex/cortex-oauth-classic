<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;

// @TODO: Add missing channels and make sure it's used
Broadcast::channel('cortex.clients.index', function (Authorizable $user) {
    return $user->can('list', app('rinvex.oauth.client'));
}, ['guards' => ['admin']]);
