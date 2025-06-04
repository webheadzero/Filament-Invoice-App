<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class InvoiceChart extends ChartWidget
{
    protected static ?string $heading = 'Invoice Statistics';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '300px';
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Invoice::select(
            DB::raw('MONTH(invoice_date) as month'),
            DB::raw('SUM(total_amount) as total')
        )
        ->whereYear('invoice_date', now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $months = [];
        $totals = [];

        // Initialize all months with zero
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('F', mktime(0, 0, 0, $i, 1));
            $totals[] = 0;
        }

        // Fill in actual data
        foreach ($data as $item) {
            $index = $item->month - 1;
            $totals[$index] = $item->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Invoice Amount',
                    'data' => $totals,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "Rp " + value.toLocaleString("id-ID"); }'
                    ]
                ]
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
} 