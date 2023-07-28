<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NagResource\Pages;
use App\Filament\Resources\NagResource\RelationManagers;
use B2BPanel\SharedModels\Nag;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NagResource extends Resource
{
    protected static ?string $model = Nag::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rd'),
                TextColumn::make('numer'),
                TextColumn::make('opis'),
                TextColumn::make('logo'),
                TextColumn::make('logop'),
                TextColumn::make('recipient.nazwa')->wrap()->label('Odbiorca'),
                TextColumn::make('payer.nazwa')->wrap()->label('Płatnik'),

            ])
            ->filters([
                Filter::make('numer')
                    ->form([
                        TextInput::make('numer')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['numer'],
                            fn (Builder $query, $numer): Builder => $query->where('numer', 'like', '%' . $numer . '%')
                        );
                    }),
                Filter::make('opis')
                    ->form([
                        TextInput::make('opis')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['opis'],
                            fn (Builder $query, $opis): Builder => $query->where('opis', 'like', '%' . $opis . '%')
                        );
                    }),
            ], layout: Layout::AboveContent)
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNags::route('/'),
            'create' => Pages\CreateNag::route('/create'),
            'edit' => Pages\EditNag::route('/{record}/edit'),
        ];
    }
}
