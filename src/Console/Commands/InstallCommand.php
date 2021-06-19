<?php

declare(strict_types=1);

namespace Cortex\Oauth\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:install:oauth {--f|force : Force the operation to run when in production.} {--r|resource=* : Specify which resources to publish.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Cortex OAuth Module.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->alert($this->description);

        ! $this->option('resource') || $this->call('cortex:publish:oauth', ['--force' => $this->option('force'), '--resource' => $this->option('resource')]);

        $this->call('cortex:migrate:oauth', ['--force' => $this->option('force')]);
        $this->call('cortex:seed:oauth');

        // Create the encryption keys needed to generate secure access tokens
        $this->call('rinvex:oauth:keys', ['--force' => $this->option('force')]);

        // Create "personal access" and "password grant" clients which will be used to generate access tokens
        $this->call('rinvex:oauth:client', ['--personal_access' => true]);
        $this->call('rinvex:oauth:client', ['--password' => true]);
    }
}
