<?php

namespace Bastinald\Malzahar\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Doctrine\DBAL\Schema\Comparator;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;

class MigrateCommand extends Command
{
    /**
     * Command signature.
     * 
     * @var string
     */
    protected $signature = 'malz:migrate {--f} {--s} {--fs}';

    /**
     * Execute the given command.
     * 
     * @return int
     */
    public function handle(): int
    {
        $this->handleTraditionalMigrations();
        $this->handleAutomaticMigrations();

        if ($this->option('s') || $this->option('fs')) {
            $this->seed();
        }

        return 0;
    }

    /**
     * Run any traditional Laravel migrations.
     * 
     * @return void
     */
    public function handleTraditionalMigrations(): void
    {
        $command = 'migrate';

        if ($this->option('f') || $this->option('fs')) {
            $command .= ':fresh';
        }

        Artisan::call($command . ' --force');
    }

    /**
     * Parse through existing models and run auto-migrations.
     * 
     * @return void
     */
    public function handleAutomaticMigrations(): void
    {
        $path = is_dir(app_path('Models')) ? app_path('Models') : app_path();
        $namespace = app()->getNamespace();

        foreach ((new Finder)->in($path) as $model) {
            $model = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($model->getRealPath(), realpath(app_path()) . DIRECTORY_SEPARATOR)
                );

            if (method_exists($model, 'migration')) {
                $this->migrate($model);
            }
        }

        $this->info('Migration complete!');
    }

    /**
     * Run auto-migration from model class.
     * 
     * @param  string $model
     * @return void
     */
    public function migrate(string $model): void
    {
        $model = app($model);
        $modelTable = $model->getTable();

        if (Schema::hasTable($modelTable)) {
            $tempTable = 'temp_' . $modelTable;

            Schema::dropIfExists($tempTable);
            Schema::create($tempTable, function (Blueprint $table) use ($model) {
                $model->migration($table);
            });

            $schemaManager = $model->getConnection()->getDoctrineSchemaManager();
            $modelTableDetails = $schemaManager->listTableDetails($modelTable);
            $tempTableDetails = $schemaManager->listTableDetails($tempTable);
            $tableDiff = (new Comparator)->diffTable($modelTableDetails, $tempTableDetails);

            if ($tableDiff) {
                $schemaManager->alterTable($tableDiff);
            }

            Schema::drop($tempTable);
        } else {
            Schema::create($modelTable, function (Blueprint $table) use ($model) {
                $model->migration($table);
            });
        }
    }

    /**
     * Seed the database from existing seeder files.
     * 
     * @return void
     */
    public function seed(): void
    {
        $command = 'db:seed --force';

        Artisan::call($command);

        $this->info('Seeding complete!');
    }
}
