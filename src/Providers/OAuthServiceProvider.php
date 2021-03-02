<?php

declare(strict_types=1);

namespace Cortex\OAuth\Providers;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\RateLimiter;
use Rinvex\OAuth\Http\Middleware\CheckScopes;
use Rinvex\OAuth\Http\Middleware\CheckForAnyScope;
use Illuminate\Database\Eloquent\Relations\Relation;
use Rinvex\OAuth\Http\Middleware\CreateFreshApiToken;
use Rinvex\OAuth\Http\Middleware\CheckClientCredentials;
use Rinvex\OAuth\Http\Middleware\CheckClientCredentialsForAnyScope;

class OAuthServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router, Dispatcher $dispatcher): void
    {
        // Bind route models and constrains
        $router->pattern('client', '[a-zA-Z0-9-_]+');
        $router->pattern('auth_code', '[a-zA-Z0-9-_]+');
        $router->pattern('access_token', '[a-zA-Z0-9-_]+');
        $router->pattern('refresh_token', '[a-zA-Z0-9-_]+');
        $router->model('client', config('rinvex.oauth.models.client'));
        $router->model('auth_code', config('rinvex.oauth.models.auth_code'));
        $router->model('access_token', config('rinvex.oauth.models.access_token'));
        $router->model('refresh_token', config('rinvex.oauth.models.refresh_token'));

        // Map relations
        Relation::morphMap([
            'client' => config('rinvex.oauth.models.client'),
            'auth_code' => config('rinvex.oauth.models.auth_code'),
            'access_token' => config('rinvex.oauth.models.access_token'),
            'refresh_token' => config('rinvex.oauth.models.refresh_token'),
        ]);

        $this->configureRateLimiting();
        $router->middlewareGroup('api', [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Cortex\Foundation\Http\Middleware\SetAuthDefaults::class,
        ]);

        // Append middleware to the 'web' middlware group
        $router->pushMiddlewareToGroup('web', CreateFreshApiToken::class);

        // Alias route middleware on the fly
        $router->aliasMiddleware('scopes', CheckScopes::class);
        $router->aliasMiddleware('scope', CheckForAnyScope::class);
        $router->aliasMiddleware('client', CheckClientCredentials::class);
        $router->aliasMiddleware('clients', CheckClientCredentialsForAnyScope::class);
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->getAuthIdentifier() ?: $request->ip());
        });
    }
}
