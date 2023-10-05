<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainResource\Pages;
use App\Filament\Resources\TrainResource\RelationManagers;
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

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name')->required(),
        Select::make('status')->options([
          'operational' => 'Operativo',
          'maintenance' => 'Mantenimiento',
          'out of service' => 'Fuera de servicio'
        ])
          ->required()
          ->native(false),
        Textarea::make('description'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name'),
        TextColumn::make('status'),
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
      'index' => Pages\ListTrains::route('/'),
      'create' => Pages\CreateTrain::route('/create'),
      'edit' => Pages\EditTrain::route('/{record}/edit'),
    ];
  }
}
