<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use Filament\Widgets\ChartWidget;

class LeadsChart extends ChartWidget
{
    protected ?string $heading = 'Leads reçus (6 derniers mois)';

    protected static ?int $sort = -4;

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn (int $monthsAgo) => now()->subMonths($monthsAgo));

        $counts = $months->map(fn ($month) => Lead::whereMonth('created_at', $month->month)
            ->whereYear('created_at', $month->year)
            ->count());

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => $counts->values()->all(),
                    'borderColor' => '#1589AA',
                    'backgroundColor' => 'rgba(21, 137, 170, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => $months->map(fn ($month) => $month->translatedFormat('M Y'))->all(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
