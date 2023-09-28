<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NagResource\Pages;
use App\Filament\Resources\NagResource\RelationManagers;
use B2BPanel\SharedModels\Nag;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class NagResource extends Resource
{
    protected static ?string $model = Nag::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Faktura';

    protected static ?string $pluralModelLabel = 'Faktury';

    protected static ?int $navigationSort = 2;


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
                TextColumn::make('numer')->disableClick(),
                CheckboxColumn::make('is_returnable')->label(new HtmlString('Czy wlicza się do </br> sumy wartości zwrotów'))->disabled(),
                TextColumn::make('opis')->wrap(),
                TextColumn::make('numerdok'),
                TextColumn::make('logo')->label('Logo odbiorcy'),
                TextColumn::make('logop')->label('Logo płatnika'),
                TextColumn::make('recipient.nazwa')->wrap()->label('Odbiorca'),
                TextColumn::make('payer.nazwa')->wrap()->label('Płatnik'),
            ])
            ->filters([
                Filter::make('numer')
                    ->form([
                        TextInput::make('numer')->debounce('1000ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['numer'],
                            fn (Builder $query, $numer): Builder => $query->where('numer', 'like', '%' . $numer . '%')
                        );
                    })->indicateUsing(function (array $data): ?string {
                        if (!$data['numer']) {
                            return null;
                        }
                        return "Numer: " . $data['numer'];
                    }),
                Filter::make('opis')
                    ->form([
                        TextInput::make('opis')->debounce('1000ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['opis'],
                            fn (Builder $query, $opis): Builder => $query->where('opis', 'like', '%' . $opis . '%')
                        );
                    })->indicateUsing(function (array $data): ?string {
                        if (!$data['opis']) {
                            return null;
                        }
                        return "Opis: " . $data['opis'];
                    }),
                Filter::make('logo')
                    ->form([
                        TextInput::make('logo')->label('Logo odbiorcy')->debounce('1000ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['logo'],
                            fn (Builder $query, $logo): Builder => $query->where('logo', 'like', '%' . $logo . '%')
                        );
                    })->indicateUsing(function (array $data): ?string {
                        if (!$data['logo']) {
                            return null;
                        }
                        return "Logo odbiorcy: " . $data['logo'];
                    }),
                Filter::make('logop')
                    ->form([
                        TextInput::make('logop')->label('Logo płatnika')->debounce('1000ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['logop'],
                            fn (Builder $query, $logop): Builder => $query->where('logop', 'like', '%' . $logop . '%')
                        );
                    })->indicateUsing(function (array $data): ?string {
                        if (!$data['logop']) {
                            return null;
                        }
                        return "Logo płatnika: " . $data['logop'];
                    }),
                TernaryFilter::make('is_returnable')->label('Czy wlicza się do sumy wartości zwrotów')
            ], layout: Layout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('make_returnable')->label('Wliczaj do wartości zwrotów')->requiresConfirmation()->action(fn (Collection $records) => $records->each->update(['is_returnable' => true])),
                BulkAction::make('make_unreturnable')->label('Nie wliczaj do wartości zwrotów')->requiresConfirmation()->action(fn (Collection $records) => $records->each->update(['is_returnable' => false]))
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LinsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNags::route('/'),
            'create' => Pages\CreateNag::route('/create'),
            'edit' => Pages\EditNag::route('/{record}/edit'),
            'view' => Pages\ViewNag::route('/{record}/view')
        ];
    }
}
