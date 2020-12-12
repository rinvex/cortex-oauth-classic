<?php

declare(strict_types=1);

namespace Cortex\OAuth\Providers;

use Cortex\OAuth\Models\Tag;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Illuminate\Contracts\Events\Dispatcher;
use Cortex\OAuth\Console\Commands\SeedCommand;
use Cortex\OAuth\Console\Commands\InstallCommand;
use Cortex\OAuth\Console\Commands\MigrateCommand;
use Cortex\OAuth\Console\Commands\PublishCommand;
use Cortex\OAuth\Console\Commands\RollbackCommand;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        // Bind eloquent models to IoC container
        $this->app['config']['rinvex.oauth.models.tag'] === Tag::class
        || $this->app->alias('rinvex.oauth.tag', Tag::class);

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
    }
}
