<?php

declare(strict_types=1);

namespace Cortex\OAuth\Console\Commands;

use Illuminate\Console\Command;

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

        $this->call('db:seed', ['--class' => 'CortexTagsSeeder']);

        $this->line('');
    }
}
