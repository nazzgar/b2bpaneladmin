<?php

namespace App\Filament\Resources\NagResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LinsRelationManager extends RelationManager
{
    protected static string $relationship = 'lins';

    protected static ?string $recordTitleAttribute = 'lp';

    protected static ?string $modelLabel = 'Linijka';

    protected static ?string $pluralModelLabel = 'Linijki';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('lp')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lp'),
                Tables\Columns\TextColumn::make('kodkres'),
                Tables\Columns\TextColumn::make('symkar'),
                Tables\Columns\TextColumn::make('ilosc'),
                Tables\Columns\TextColumn::make('stawka'),
                Tables\Columns\TextColumn::make('cena_netto'),
                Tables\Columns\TextColumn::make('cena_netto_po_rabacie'),
                Tables\Columns\TextColumn::make('cena_brutto'),
                Tables\Columns\TextColumn::make('cena_brutto_po_rabacie'),
                Tables\Columns\TextColumn::make('opis'),
                Tables\Columns\TextColumn::make('netto_suma'),
                Tables\Columns\TextColumn::make('brutto_suma'),
                Tables\Columns\TextColumn::make('vat_suma'),
                Tables\Columns\TextColumn::make('PD_typoferty')->label('Typ oferty'),
                Tables\Columns\TextColumn::make('publisher.opis')->label('Wydawnictwo'),



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
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
