<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Rinvex\Oauth\Http\Middleware\CheckScopes;
use Rinvex\Oauth\Http\Middleware\CheckForAnyScope;
use Illuminate\Database\Eloquent\Relations\Relation;
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

    // Add route middleware aliases on the fly
    Route::aliasMiddleware('scopes', CheckScopes::class);
    Route::aliasMiddleware('scope', CheckForAnyScope::class);
    Route::aliasMiddleware('client', CheckClientCredentials::class);
    Route::aliasMiddleware('clients', CheckClientCredentialsForAnyScope::class);

    // Map relations
    Relation::morphMap([
        'client' => config('rinvex.oauth.models.client'),
        'auth_code' => config('rinvex.oauth.models.auth_code'),
        'access_token' => config('rinvex.oauth.models.access_token'),
        'refresh_token' => config('rinvex.oauth.models.refresh_token'),
    ]);

    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->user()?->getAuthIdentifier() ?: $request->ip());
    });
};
