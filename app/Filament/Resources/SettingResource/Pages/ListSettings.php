<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        $setting = \App\Models\Setting::first();
        if ($setting) {
            redirect()->to(SettingResource::getUrl('edit', ['record' => $setting]));
        } else {
            redirect()->to(SettingResource::getUrl('create'));
        }
    }
}
