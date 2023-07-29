<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractorResource\Pages;
use App\Filament\Resources\ContractorResource\RelationManagers;
use B2BPanel\SharedModels\Contractor;
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

class ContractorResource extends Resource
{
    protected static ?string $model = Contractor::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Kontrahent';

    protected static ?string $pluralModelLabel = 'Kontrahenci';

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
                TextColumn::make('logo'),
                TextColumn::make('nazwa'),
                TextColumn::make('nip'),
                TextColumn::make('regon')
            ])
            ->filters([
                Filter::make('logo')
                    ->form([
                        TextInput::make('logo')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['logo'],
                            fn (Builder $query, $logo): Builder => $query->where('logo', 'like', $logo . '%')
                        );
                    }),
                Filter::make('nazwa')
                    ->form([
                        TextInput::make('nazwa')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['nazwa'],
                            fn (Builder $query, $nazwa): Builder => $query->where('nazwa', 'like', $nazwa . '%')
                        );
                    }),
                Filter::make('nip')
                    ->form([
                        TextInput::make('nip')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['nip'],
                            fn (Builder $query, $nip): Builder => $query->where('nip', 'like', $nip . '%')
                        );
                    }),
                Filter::make('regon')
                    ->form([
                        TextInput::make('regon')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['regon'],
                            fn (Builder $query, $regon): Builder => $query->where('regon', 'like', $regon . '%')
                        );
                    })
            ], layout: Layout::AboveContent,)
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
            'index' => Pages\ListContractors::route('/'),
            'create' => Pages\CreateContractor::route('/create'),
            'edit' => Pages\EditContractor::route('/{record}/edit'),
        ];
    }
}
