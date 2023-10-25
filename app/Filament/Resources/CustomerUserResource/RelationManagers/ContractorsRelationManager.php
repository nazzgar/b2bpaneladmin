<?php

namespace App\Filament\Resources\CustomerUserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractorsRelationManager extends RelationManager
{
    protected static string $relationship = 'contractors';

    protected static ?string $recordTitleAttribute = 'logo';

    protected static ?string $modelLabel = 'Kontrahent';

    protected static ?string $pluralModelLabel = 'Kontrahenci';

    protected static ?string $title = 'Kontrahenci';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('logo')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('logo'),
                Tables\Columns\TextColumn::make('nazwa'),
                Tables\Columns\TextColumn::make('nip')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
