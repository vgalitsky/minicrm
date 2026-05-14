<?php

namespace Mtr\MiniCrm\Console\Commands;

use Illuminate\Console\Command;
use Mtr\MiniCrm\Database\Seeders\MiniCrmSeeder;
use Mtr\MiniCrm\MiniCrmServiceProvider;

class InstallCommand extends Command
{
    protected $signature = 'minicrm:install
        {--seed : Seed data}
        {--publish : Publish config, views, and assets}';

    protected $description = 'Install Mini CRM package';

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->info('Installing Mini CRM...');

        if ($this->option('publish')) {
            $this->call('vendor:publish',
                [
                    '--provider' => MiniCrmServiceProvider::class, 
                    '--tag' => 'minicrm-config'
                ]
            );

            $this->call('vendor:publish',
                [
                    '--provider' => MiniCrmServiceProvider::class, 
                    '--tag' => 'minicrm-assets'
                ]
            );
        }

        $this->call('migrate');

        if ($this->option('seed')) {
            $this->call('db:seed', ['--class' => MiniCrmSeeder::class]);
        }

        $this->info('Mini CRM installed successfully!');

        return self::SUCCESS;
    }
}