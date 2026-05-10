<?php

namespace Mtr\MiniCrm\Console\Commands;

use Illuminate\Console\Command;
use Mtr\MiniCrm\Database\Seeders\MiniCrmSeeder;

class InstallCommand extends Command
{
    protected $signature = 'minicrm:install {--fresh : Drop & migrate} {--seed : Seed data}';

    protected $description = 'Install Mini CRM package';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('Installing Mini CRM...');

        if ($this->option('fresh')) {
            $this->call('migrate:fresh');
        } else {
            $this->call('migrate');
        }

        if ($this->option('seed')) {
            $this->call('db:seed', ['--class' => MiniCrmSeeder::class]);
        }

        $this->info('Mini CRM installed successfully!');
    }
}