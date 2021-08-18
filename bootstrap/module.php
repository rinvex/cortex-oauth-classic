<?php

declare(strict_types=1);

use Rinvex\Oauth\Http\Middleware\CheckScopes;
use Rinvex\Oauth\Http\Middleware\CheckForAnyScope;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Rinvex\Oauth\Http\Middleware\CreateFreshApiToken;
use Cortex\Foundation\Http\Middleware\SetAuthDefaults;
use Rinvex\Oauth\Http\Middleware\CheckClientCredentials;
use Rinvex\Oauth\Http\Middleware\CheckClientCredentialsForAnyScope;

return function () {
    // Bind route models and constrains
    Route::pattern('client', '[a-zA-Z0-9-_]+');
    Route::pattern('auth_code', '[a-zA-Z0-9-_]+');
    Route::pattern('access_token', '[a-zA-Z0-9-_]+');
    Route::pattern('refresh_token', '[a-zA-Z0-9-_]+');
    Route::model('client', config('rinvex.oauth.models.client'));
    Route::model('auth_code', config('rinvex.oauth.models.auth_code'));
    Route::model('access_token', config('rinvex.oauth.models.access_token'));
    Route::model('refresh_token', config('rinvex.oauth.models.refresh_token'));

    Route::middlewareGroup('api', [
        'throttle:api',
        SubstituteBindings::class,
        SetAuthDefaults::class,
    ]);

    // Append middleware to the 'web' middleware group
    Route::pushMiddlewareToGroup('web', CreateFreshApiToken::class);

    // Alias route middleware on the fly
    Route::aliasMiddleware('scopes', CheckScopes::class);
    Route::aliasMiddleware('scope', CheckForAnyScope::class);
    Route::aliasMiddleware('client', CheckClientCredentials::class);
    Route::aliasMiddleware('clients', CheckClientCredentialsForAnyScope::class);
};
