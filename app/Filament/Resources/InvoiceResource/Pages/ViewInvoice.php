<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Actions\Action;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Invoice Details')
                    ->schema([
                        TextEntry::make('invoice_number'),
                        TextEntry::make('invoice_date'),
                        TextEntry::make('total_amount'),
                        TextEntry::make('client.name'),
                    ]),
                Section::make('Invoice Items')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                TextEntry::make('description'),
                                TextEntry::make('quantity'),
                                TextEntry::make('unit_price'),
                                TextEntry::make('total_price'),
                            ])
                            ->columns(4),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('Print Invoice')
                ->icon('heroicon-o-printer')
                ->url(fn () => route('invoices.print', ['invoice' => $this->record]))
                ->openUrlInNewTab(),
        ];
    }
} 