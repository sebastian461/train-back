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

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Select::make('train_id')
          ->relationship('train', 'name')
          ->required()
          ->native(false),
        Select::make('country_origin')
          ->options(Country::all()->pluck('name', 'id'))
          ->searchable()
          ->preload()
          ->live()
          ->required(),
        Select::make('city_origin')
          ->searchable()
          ->preload()
          ->required()
          ->options(fn (Get $get): Collection => City::query()
            ->where('country_id', $get('country_origin'))
            ->pluck('name', 'id'))
          ->native(false),
        Select::make('country_destiny')
          ->options(Country::all()->pluck('name', 'id'))
          ->searchable()
          ->preload()
          ->required(),
        Select::make('city_destiny')
          ->searchable()
          ->preload()
          ->required()
          ->options(fn (Get $get): Collection => City::query()
            ->where('country_id', $get('country_destiny'))
            ->pluck('name', 'id'))
          ->native(false),
        TextInput::make('places')
          ->numeric()
          ->step(10)
          ->required(),
        DateTimePicker::make('date')
          ->seconds(false)
          ->native(false)
          ->minutesStep(15)
          ->minDate(now())
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('train.name'),
        TextColumn::make('countryOrigin.name'),
        TextColumn::make('cityOrigin.name'),
        TextColumn::make('countryDestiny.name'),
        TextColumn::make('cityDestiny.name'),
        TextColumn::make('places'),
        TextColumn::make('date'),
        TextColumn::make('status')
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
