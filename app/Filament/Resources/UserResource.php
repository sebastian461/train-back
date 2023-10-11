<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
  protected static ?string $model = User::class;

  protected static ?string $navigationIcon = 'tabler-users';

  protected static ?string $navigationLabel = 'Usuarios';

  protected static ?string $modelLabel = 'Usuarios';

  protected static ?string $navigationGroup = 'Gestión de usuarios';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name')
          ->required()
          ->maxLength(255)
          ->label('Nombres'),
        TextInput::make('email')
          ->email()
          ->required()
          ->maxLength(255)
          ->label('Correo'),
        Forms\Components\TextInput::make('password')
          ->password()
          ->required()
          ->maxLength(255)
          ->hiddenOn('edit')
          ->label('Contraseña'),
        Select::make('roles')
          ->multiple()
          ->relationship('roles', 'name')
          ->preload()
          ->label('Roles')
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')
          ->searchable()
          ->label('Nombres'),
        TextColumn::make('email')
          ->searchable()
          ->label('Correo'),
        TextColumn::make('email_verified_at')
          ->dateTime()
          ->sortable()
          ->label('Verificación'),
        TextColumn::make('roles.name')
          ->sortable()
          ->label('Roles'),
        TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
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
      'index' => Pages\ListUsers::route('/'),
      'create' => Pages\CreateUser::route('/create'),
      'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
  }
}
