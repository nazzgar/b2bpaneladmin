<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerUserResource\Pages;
use App\Filament\Resources\CustomerUserResource\RelationManagers;
use B2BPanel\SharedModels\CustomerUser;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerUserResource extends Resource
{
    protected static ?string $model = CustomerUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'Użytkownik';

    protected static ?string $pluralModelLabel = 'Użytkownicy';

    /* TODO: create, update form, change password, login as actions */

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ContractorsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerUsers::route('/'),
            'create' => Pages\CreateCustomerUser::route('/create'),
            'edit' => Pages\EditCustomerUser::route('/{record}/edit'),
        ];
    }
}
