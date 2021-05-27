<?php

namespace Bastinald\Malzahar\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'malz:install';

    public function handle()
    {
        (new Filesystem)->copyDirectory(
            __DIR__ . '/../../resources/stubs/install',
            base_path(),
        );

        Artisan::call('malz:migrate --fs');

        exec('npm install');
        exec('npm run dev');

        $this->info('Malzahar installed!');
    }
}
