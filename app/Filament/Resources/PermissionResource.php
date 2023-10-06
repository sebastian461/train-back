<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;

class PermissionResource extends Resource
{
  protected static ?string $model = Permission::class;

  protected static ?string $navigationIcon = 'tabler-license';

  protected static ?string $navigationLabel = 'Permisos';

  protected static ?string $modelLabel = 'Permisos';

  protected static ?string $navigationGroup = 'Gestión de usuarios';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name')
          ->required()
          ->label('Nombre'),
        Select::make('guard_name')
          ->required()
          ->options(['web' => 'web', 'api' => 'api'])
          ->native(false),
        Select::make('roles')
          ->multiple()
          ->relationship('roles', 'name')
          ->preload()
          ->searchable()
          ->native(false)
          ->label('Roles')
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('id')->label('ID'),
        TextColumn::make('name')->label('Permiso'),
        TextColumn::make('guard_name')->label('Guard'),
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
      'index' => Pages\ListPermissions::route('/'),
      'create' => Pages\CreatePermission::route('/create'),
      'edit' => Pages\EditPermission::route('/{record}/edit'),
    ];
  }
}
