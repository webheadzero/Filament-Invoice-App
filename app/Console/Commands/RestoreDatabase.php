<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RestoreDatabase extends Command
{
    protected $signature = 'db:restore {filename}';
    protected $description = 'Restore the database from a backup file';

    public function handle()
    {
        $filename = $this->argument('filename');
        $path = storage_path('app/backups/' . $filename);

        if (!file_exists($path)) {
            $this->error('Backup file not found!');
            return;
        }

        $command = sprintf(
            'mysql -u%s -p%s %s < %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            $path
        );

        $returnVar = NULL;
        $output = NULL;

        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->info('Database restore completed successfully!');
        } else {
            $this->error('Database restore failed!');
        }
    }
} 