<?php

namespace App\Filament\Widgets;

use App\Models\Travel;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TravelAdminChart extends ChartWidget
{
  protected static ?string $heading = 'Viajes';

  protected static string $color = 'info';

  protected function getData(): array
  {
    $data = Trend::model(Travel::class)
      ->between(
        start: now()->startOfMonth(),
        end: now()->endOfMonth(),
      )
      ->perDay()
      ->count();

    return [
      'datasets' => [
        [
          'label' => 'Viajes',
          'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
        ],
      ],
      'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
  }

  protected function getType(): string
  {
    return 'bar';
  }
}
