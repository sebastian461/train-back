<?php

namespace App\Filament\Widgets;

use App\Models\Travel;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAdminTravels extends BaseWidget
{

  protected static ?string $heading = 'Ultimos viajes';

  protected static ?int $sort = 4;

  protected int | string | array $columnSpan = 'full';

  public function table(Table $table): Table
  {
    return $table
      ->query(Travel::query())
      ->defaultSort('created_at', 'desc')
      ->columns([
        TextColumn::make('train.name')->label('Tren'),
        TextColumn::make('countryOrigin.name')->label('País origen'),
        TextColumn::make('cityOrigin.name')->label('Ciudad origen'),
        TextColumn::make('countryDestiny.name')->label('País destino'),
        TextColumn::make('cityDestiny.name')->label('Ciudad destino'),
        TextColumn::make('places')->label('Plazas'),
        TextColumn::make('status')->label('Estado')
          ->badge()
          ->color(fn (string $state): string => match ($state) {
            'wait' => 'warning',
            'in progress' => 'primary',
            'finalized' => 'success',
            'cancelled' => 'danger',
          }),

      ]);
  }
}
