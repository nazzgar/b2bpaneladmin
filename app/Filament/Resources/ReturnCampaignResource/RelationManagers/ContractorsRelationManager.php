<?php

namespace App\Filament\Resources\ReturnCampaignResource\RelationManagers;

use B2BPanel\SharedModels\Contractor;
use B2BPanel\SharedModels\ReturnCampaign;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table as TablesTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

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
                AttachAction::make()->label('Dołącz jednego')->color('primary'),
                Action::make('attach_all')->label('Dołącz wszystkich')->button()->color('secondary')->requiresConfirmation()->action(function (ContractorsRelationManager $livewire) {
                    $livewire->ownerRecord->contractors()->syncWithoutDetaching(Contractor::all());
                }),
                Action::make('detach_all')->label('Odłącz wszystkich')->button()->color('secondary')->requiresConfirmation()->action(function (ContractorsRelationManager $livewire) {
                    $livewire->ownerRecord->contractors()->sync([]);
                }),
                Action::make('attach_many')->label('Dołączanie wielu')->button()->form([
                    Textarea::make('logos')->placeholder('logo1,
logo2,
logo3...')->required()
                ])->action('attach_many'),
                Action::make('detach_many')->label('Odłączanie wielu')->button()->form([
                    Textarea::make('logos')->placeholder('logo1,
logo2,
logo3...')->required()
                ])->action('detach_many'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }

    function attach_many(array $data, ContractorsRelationManager $livewire): void
    {
        $logos_array = $this->getLogos($data['logos']);

        $contractors = Contractor::whereIn('logo', $logos_array)->get();
        if (count($contractors) === 0) {
            return;
        }

        $livewire->ownerRecord->contractors()->syncWithoutDetaching($contractors);
    }

    function detach_many(array $data, ContractorsRelationManager $livewire): void
    {
        $logos_array = $this->getLogos($data['logos']);

        $contractors = Contractor::whereIn('logo', $logos_array)->get();
        if (count($contractors) === 0) {
            return;
        }

        $livewire->ownerRecord->contractors()->detach($contractors);
    }

    public function getLogos(string $data): array
    {
        return explode(PHP_EOL, $data);
    }
}
