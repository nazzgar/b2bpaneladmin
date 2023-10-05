<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReturnCampaignResource\Pages;
use App\Filament\Resources\ReturnCampaignResource\RelationManagers;
use App\Rules\ReturnCampaignDate;
use B2BPanel\SharedModels\ReturnCampaign;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
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

class ReturnCampaignResource extends Resource
{
    protected static ?string $model = ReturnCampaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

    protected static ?string $modelLabel = 'Akcja zwrotów';

    protected static ?string $pluralModelLabel = 'Akcje zwrotów';

    public static function form(Form $form): Form
    {
        //TODO: validation, date_start < date_end
        return $form
            ->schema([
                Grid::make(3)->schema([
                    TextInput::make('name')->label('Nazwa')->required(),
                    DatePicker::make('date_start')->minDate(now()->toDateString())->rules([new ReturnCampaignDate()])->displayFormat('d-m-Y')->label('Data początkowa')->required(),
                    DatePicker::make('date_end')->afterOrEqual('date_start')->rules([new ReturnCampaignDate()])->minDate(now()->toDateString())->displayFormat('d-m-Y')->label('Data końcowa')->required(),
                ]),
                Section::make('Domyślne limity')
                    ->description('Wartości w zakresie 0 - 1, gdzie 0 to 0% a 1 to 100%')
                    ->schema([
                        TextInput::make('zabawki')->numeric()->minValue(0)->maxValue(1)->step(0.05)->default(0),
                        TextInput::make('jezykowe')->numeric()->minValue(0)->maxValue(1)->step(0.05)->default(0),
                        TextInput::make('jezykowe_oxford')->numeric()->minValue(0)->maxValue(1)->step(0.05)->default(0),
                        TextInput::make('edukacyjne')->numeric()->minValue(0)->maxValue(1)->step(0.05)->default(0),
                        TextInput::make('pozostale')->numeric()->minValue(0)->maxValue(1)->step(0.05)->default(0)
                    ])
                    ->columns(5)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nazwa'),
                TextColumn::make('date_start')->date('d-m-Y')->sortable()->label('Data początkowa'),
                TextColumn::make('date_end')->date('d-m-Y')->sortable()->label('Data końcowa')
            ])
            ->filters([
                Filter::make('name')
                    ->form([
                        TextInput::make('name')->label('Nazwa')->debounce('1000ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['name'],
                            fn (Builder $query, $name): Builder => $query->where('name', 'like', '%' . $name . '%')
                        );
                    }),

            ], layout: Layout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListReturnCampaigns::route('/'),
            'create' => Pages\CreateReturnCampaign::route('/create'),
            'edit' => Pages\EditReturnCampaign::route('/{record}/edit'),
        ];
    }
}
