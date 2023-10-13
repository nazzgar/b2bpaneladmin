<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReturnmResource\Pages;
use App\Filament\Resources\ReturnmResource\RelationManagers;
use B2BPanel\SharedModels\ReturnCampaign;
use B2BPanel\SharedModels\Returnm;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReturnmResource extends Resource
{
    protected static ?string $model = Returnm::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

    protected static ?string $modelLabel = 'Zwrot';

    protected static ?string $pluralModelLabel = 'Zwroty';

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
                TextColumn::make('customeruser.email')->label('Użytkownik'),
                TextColumn::make('returncampaign.name')->label('Akcja zwrotów'),
                //TODO: add custom column with contractors logos, ref: https://filamentphp.com/docs/2.x/tables/columns/custom
            ])
            ->filters([
                Filter::make('is_current')->label('Pokaż zwroty tylko aktywnej akcji zwrotów')->query(function ($query) {
                    $current_return_campaign = ReturnCampaign::current();
                    return $query->where('return_campaign_id', $current_return_campaign->id);
                })->default()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListReturnms::route('/'),
            'create' => Pages\CreateReturnm::route('/create'),
            'view' => Pages\ViewReturnm::route('/{record}'),
            //'edit' => Pages\EditReturnm::route('/{record}/edit'),
        ];
    }
}
