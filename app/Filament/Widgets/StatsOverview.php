<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Lead;
use App\Models\Realisation;
use App\Models\Service;
use App\Models\Temoignage;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -5;

    protected function getStats(): array
    {
        $leadsCeMois = Lead::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return [
            Stat::make('Total leads', Lead::count())
                ->description($leadsCeMois.' reçus ce mois-ci')
                ->color('primary'),
            Stat::make('Leads convertis', Lead::where('statut', 'converti')->count())
                ->color('primary'),
            Stat::make('Services actifs', Service::actif()->count())
                ->color('primary'),
            Stat::make('Réalisations publiées', Realisation::publie()->count())
                ->color('primary'),
            Stat::make('Articles publiés', Article::publie()->count())
                ->color('primary'),
            Stat::make('Témoignages actifs', Temoignage::actif()->count())
                ->color('primary'),
        ];
    }
}
