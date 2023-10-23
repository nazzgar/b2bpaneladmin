<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use B2BPanel\SharedModels\Announcement;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $modelLabel = 'Komunikat';

    protected static ?string $pluralModelLabel = 'Komunikaty';

    /* protected static ?int $navigationSort = 3; */

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->name('Tytuł'),
                DateTimePicker::make('start_showing_at')->name('Pokazuj od')->default(now()),
                DateTimePicker::make('stop_showing_at')->name('Pokazuj do'),
                RichEditor::make('content')->name('Treść'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Tytuł'),
                TextColumn::make('start_showing_at')->label('Wyświetlane od'),
                TextColumn::make('stop_showing_at')->label('Wyświetlane do'),
                IconColumn::make('is_visible')
                    ->boolean()->label('Czy widoczne')->alignCenter()
            ])
            ->filters([
                Filter::make('is_visible')
                    ->query(fn (Builder $query): Builder => $query->where('start_showing_at', '<=', now())->where('stop_showing_at', '>=', now())->orWhere('stop_showing_at', null))
                    ->toggle()
                    ->label('Pokaż tylko widoczne')
                    ->default()
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
