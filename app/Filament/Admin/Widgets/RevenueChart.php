<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class RevenueChartWidget extends ChartWidget
{
    protected ?string $heading = 'Pendapatan Bulanan';
    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        $data = Trend::query(
            Payment::where('is_confirmed', true)
        )
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
