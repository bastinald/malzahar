<?php

namespace Bastinald\Malzahar\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    /**
     * Command signature.
     * 
     * @var string
     */
    protected $signature = 'malz:install';

    /**
     * Execute the given command.
     * 
     * @return int
     */
    public function handle(): int
    {
        (new Filesystem)->copyDirectory(
            __DIR__ . '/../../resources/stubs/install',
            base_path(),
        );

        Artisan::call('malz:migrate --fs');

        exec('npm install');
        exec('npm run dev');

        $this->info('Malzahar installed!');

        return 0;
    }
}
