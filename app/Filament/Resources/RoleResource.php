<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RoleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Filament\Resources\RoleResource\RelationManagers\PermissionsRelationManager;

class RoleResource extends Resource
{
  protected static ?string $model = Role::class;

  protected static ?string $navigationIcon = 'tabler-user-check';

  protected static ?string $navigationLabel = 'Roles';

  protected static ?string $modelLabel = 'Roles';

  protected static ?string $navigationGroup = 'Gestión de usuarios';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name')
          ->required()
          ->label('Nombre'),
        Select::make('guard_name')
          ->options(['web' => 'web', 'api' => 'api'])
          ->required()
          ->native(false),
        Select::make('permissions')
          ->multiple()
          ->relationship('permissions', 'name')
          ->preload()
          ->searchable()
          ->native(false)
          ->label('Permisos')
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('id')->label('ID'),
        TextColumn::make('name')->label('Rol'),
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
      PermissionsRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListRoles::route('/'),
      'create' => Pages\CreateRole::route('/create'),
      'edit' => Pages\EditRole::route('/{record}/edit'),
    ];
  }
}
