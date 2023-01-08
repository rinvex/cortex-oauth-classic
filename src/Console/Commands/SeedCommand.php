<?php

declare(strict_types=1);

namespace Cortex\Oauth\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Cortex\Oauth\Database\Seeders\CortexOAuthSeeder;

#[AsCommand(name: 'cortex:seed:oauth')]
class SeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:oauth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Cortex OAuth Data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->alert($this->description);

        $this->call('db:seed', ['--class' => CortexOAuthSeeder::class]);

        $this->line('');
    }
}
