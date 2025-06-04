<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

class BackupManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-server';
    protected static ?string $navigationLabel = 'Backup Manager';
    protected static ?string $title = 'Database Backup Manager';
    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.backup-manager';

    public function getViewData(): array
    {
        $backups = collect(Storage::files('backups'))
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'size' => Storage::size($file),
                    'date' => Storage::lastModified($file),
                ];
            })
            ->sortByDesc('date')
            ->values();

        return [
            'backups' => $backups,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backup')
                ->label('Create Backup')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    Artisan::call('db:backup');
                    Notification::make()
                        ->title('Backup created successfully')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function downloadBackup($filename)
    {
        return Storage::download('backups/' . $filename);
    }

    public function deleteBackup($filename)
    {
        Storage::delete('backups/' . $filename);
        Notification::make()
            ->title('Backup deleted successfully')
            ->success()
            ->send();
    }

    public function restoreBackup($filename)
    {
        Artisan::call('db:restore', ['filename' => $filename]);
        Notification::make()
            ->title('Database restored successfully')
            ->success()
            ->send();
    }
} 