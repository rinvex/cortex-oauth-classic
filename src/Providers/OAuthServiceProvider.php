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
use Cortex\OAuth\Console\Commands\SeedCommand;
use Cortex\OAuth\Console\Commands\InstallCommand;
use Cortex\OAuth\Console\Commands\MigrateCommand;
use Cortex\OAuth\Console\Commands\PublishCommand;
use Cortex\OAuth\Console\Commands\RollbackCommand;
use Rinvex\OAuth\Http\Middleware\CheckForAnyScope;
use Illuminate\Database\Eloquent\Relations\Relation;
use Rinvex\OAuth\Http\Middleware\CreateFreshApiToken;
use Rinvex\OAuth\Http\Middleware\CheckClientCredentials;
use Rinvex\OAuth\Http\Middleware\CheckClientCredentialsForAnyScope;

class OAuthServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        SeedCommand::class => 'command.cortex.oauth.seed',
        InstallCommand::class => 'command.cortex.oauth.install',
        MigrateCommand::class => 'command.cortex.oauth.migrate',
        PublishCommand::class => 'command.cortex.oauth.publish',
        RollbackCommand::class => 'command.cortex.oauth.rollback',
    ];

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register(): void
    {
        // Register console commands
        $this->registerCommands($this->commands);
    }

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
            \Cortex\Foundation\Http\Middleware\SetAuthDefaults::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
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
