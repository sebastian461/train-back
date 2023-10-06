<?php

namespace App\Filament\Resources\TrainResource\RelationManagers;

use App\Models\City;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class TravelRelationManager extends RelationManager
{
  protected static string $relationship = 'travel';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
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
          ->minutesStep(15)
          ->minDate(now())
          ->required()
          ->label('Fecha'),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('train')
      ->columns([
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
      ->headerActions([
        Tables\Actions\CreateAction::make(),
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }
}
