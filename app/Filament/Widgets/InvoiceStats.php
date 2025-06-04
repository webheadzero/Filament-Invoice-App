<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InvoiceStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalInvoices = Invoice::count();
        $totalAmount = Invoice::sum('total_amount');
        $averageAmount = $totalInvoices > 0 ? $totalAmount / $totalInvoices : 0;

        return [
            Stat::make('Total Invoices', $totalInvoices)
                ->description('Total number of invoices')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            
            Stat::make('Total Amount', 'Rp ' . number_format($totalAmount, 0, ',', '.'))
                ->description('Total amount of all invoices')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('primary'),
            
            Stat::make('Average Amount', 'Rp ' . number_format($averageAmount, 0, ',', '.'))
                ->description('Average amount per invoice')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('warning'),
        ];
    }
} 