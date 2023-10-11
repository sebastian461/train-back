<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TravelResource\Pages;
use App\Filament\Resources\TravelResource\RelationManagers;
use App\Models\City;
use App\Models\Country;
use App\Models\Travel;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class TravelResource extends Resource
{
  protected static ?string $model = Travel::class;

  protected static ?string $navigationIcon = 'tabler-map-2';

  protected static ?string $navigationLabel = 'Viajes';

  protected static ?string $modelLabel = 'Viajes';

  protected static ?string $navigationGroup = 'Gestión de trenes y viajes';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Select::make('train_id')
          ->relationship('train', 'name')
          ->required()
          ->native(false)
          ->label('Tren'),
        Select::make('country_origin')
          ->options(Country::all()->pluck('name', 'id'))
          ->searchable()
          ->preload()
          ->live()
          ->required()
          ->label('País origen'),
        Select::make('city_origin')
          ->searchable()
          ->preload()
          ->required()
          ->options(fn (Get $get): Collection => City::query()
            ->where('country_id', $get('country_origin'))
            ->pluck('name', 'id'))
          ->native(false)
          ->label('Ciudad origen'),
        Select::make('country_destiny')
          ->options(Country::all()->pluck('name', 'id'))
          ->searchable()
          ->preload()
          ->required()
          ->label('País destino'),
        Select::make('city_destiny')
          ->searchable()
          ->preload()
          ->required()
          ->options(fn (Get $get): Collection => City::query()
            ->where('country_id', $get('country_destiny'))
            ->pluck('name', 'id'))
          ->native(false)
          ->label('Ciudad destino'),
        TextInput::make('places')
          ->numeric()
          ->step(10)
          ->required()
          ->label('Plazas'),
        DateTimePicker::make('date')
          ->seconds(false)
          ->native(false)
          ->minDate(now())
          ->required()
          ->label('Fecha')
          ->hiddenOn('edit'),
        Select::make('status')
          ->required()
          ->options([
            'wait' => 'En espera',
            'in progress' => 'En progreso',
            'finalized' => 'Finalizado',
            'cancelled' => 'Cancelado'
          ])
          ->searchable()
          ->native(false)
          ->hiddenOn('create')
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('train.name')->label('Tren'),
        TextColumn::make('countryOrigin.name')->label('País origen'),
        TextColumn::make('cityOrigin.name')->label('Ciudad origen'),
        TextColumn::make('countryDestiny.name')->label('País destino'),
        TextColumn::make('cityDestiny.name')->label('Ciudad destino'),
        TextColumn::make('places')->label('Plazas'),
        TextColumn::make('date')->label('Fecha'),
        TextColumn::make('status')->label('Estado')
          ->badge()
          ->color(fn (string $state): string => match ($state) {
            'wait' => 'warning',
            'in progress' => 'primary',
            'finalized' => 'success',
            'cancelled' => 'danger',
          }),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListTravel::route('/'),
      'create' => Pages\CreateTravel::route('/create'),
      'edit' => Pages\EditTravel::route('/{record}/edit'),
    ];
  }
}
