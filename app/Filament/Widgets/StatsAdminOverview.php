<?php

namespace App\Filament\Widgets;

use App\Models\Train;
use App\Models\Travel;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
  protected function getStats(): array
  {
    return [
      Stat::make('Usuarios', User::query()->count())
        ->description('Todos los usuarios')
        ->descriptionIcon('tabler-users')
        ->color('success'),
      Stat::make('Viajes', Travel::query()->count())
        ->description('Todos los viajes')
        ->descriptionIcon('tabler-map-2')
        ->color('success'),
      Stat::make('Trenes', Train::query()->count())
        ->description('Todos los trenes')
        ->descriptionIcon('tabler-train')
        ->color('success'),
    ];
  }
}
