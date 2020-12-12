<?php

declare(strict_types=1);

namespace Cortex\OAuth\Console\Commands;

use Rinvex\OAuth\Console\Commands\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:migrate:oauth {--f|force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Cortex OAuth Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();

        $path = config('cortex.oauth.autoload_migrations') ?
            'app/cortex/oauth/database/migrations' :
            'database/migrations/cortex/oauth';

        if (file_exists($path)) {
            $this->call('migrate', [
                '--step' => true,
                '--path' => $path,
                '--force' => $this->option('force'),
            ]);
        } else {
            $this->warn('No migrations found! Consider publish them first: <fg=green>php artisan cortex:publish:oauth</>');
        }

        $this->line('');
    }
}
