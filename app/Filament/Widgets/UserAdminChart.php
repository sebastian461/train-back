<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class UserAdminChart extends ChartWidget
{
  protected static ?string $heading = 'Usuarios';

  protected static string $color = 'info';

  protected function getData(): array
  {
    $data = Trend::model(User::class)
      ->between(
        start: now()->startOfMonth(),
        end: now()->endOfMonth(),
      )
      ->perDay()
      ->count();

    return [
      'datasets' => [
        [
          'label' => 'Usuarios',
          'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
        ],
      ],
      'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
  }

  protected function getType(): string
  {
    return 'line';
  }
}
