<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainResource\Pages;
use App\Filament\Resources\TrainResource\RelationManagers;
use App\Filament\Resources\TrainResource\RelationManagers\TravelRelationManager;
use App\Models\Train;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainResource extends Resource
{
  protected static ?string $model = Train::class;

  protected static ?string $navigationIcon = 'tabler-train';

  protected static ?string $navigationLabel = 'Trenes';

  protected static ?string $modelLabel = 'Trenes';

  protected static ?string $navigationGroup = 'Gestión de trenes y viajes';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name')->required()->label('Nombre'),
        Select::make('status')->options([
          'operational' => 'Operativo',
          'maintenance' => 'Mantenimiento',
          'out of service' => 'Fuera de servicio'
        ])
          ->required()
          ->native(false)
          ->label('Estado'),
        Textarea::make('description')->label('Descripción'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')->label('Nombre'),
        TextColumn::make('status')->label('Estado'),
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
      TravelRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListTrains::route('/'),
      'create' => Pages\CreateTrain::route('/create'),
      'edit' => Pages\EditTrain::route('/{record}/edit'),
    ];
  }
}
