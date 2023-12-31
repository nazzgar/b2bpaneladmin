<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BezPrawaZwrotuProductResource\Pages;
use App\Filament\Resources\BezPrawaZwrotuProductResource\RelationManagers;
use B2BPanel\SharedModels\BezPrawaZwrotuProduct;
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BezPrawaZwrotuProductResource extends Resource
{
    protected static ?string $model = BezPrawaZwrotuProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $modelLabel = 'Towar bez prawa zwrotu';

    protected static ?string $pluralModelLabel = 'Towary bez prawa zwrotu';

    protected static ?int $navigationSort = 3;

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
                TextColumn::make('symkar'),
                TextColumn::make('kodkres'),
                TextColumn::make('opis'),
                Tables\Columns\ToggleColumn::make('isZwrotne')
            ])
            ->filters([
                Filter::make('symkar')
                    ->form([
                        TextInput::make('symkar')->debounce('1000ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['symkar'],
                            fn (Builder $query, $symkar): Builder => $query->where('symkar', 'like', $symkar . '%')
                        );
                    }),
                Filter::make('kodkres')
                    ->form([
                        TextInput::make('kodkres')->debounce('1000ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['kodkres'],
                            fn (Builder $query, $kodkres): Builder => $query->where('kodkres', 'like', $kodkres . '%')
                        );
                    }),
                Tables\Filters\TernaryFilter::make('isZwrotne')
            ], layout: Layout::AboveContent,)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('make_returnable')
                    ->action(fn (Collection $records) => $records->each->makeReturnable())
                    ->requiresConfirmation()
                    ->label('Ustaw możliwość zwrotu')
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkAction::make('make_unreturnable')
                    ->action(fn (Collection $records) => $records->each->makeUnreturnable())
                    ->requiresConfirmation()
                    ->label('Cofnij możliwość zwrotu')
                    ->deselectRecordsAfterCompletion()
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
            'index' => Pages\ListBezPrawaZwrotuProducts::route('/'),
            'create' => Pages\CreateBezPrawaZwrotuProduct::route('/create'),
            'edit' => Pages\EditBezPrawaZwrotuProduct::route('/{record}/edit'),
        ];
    }
}
