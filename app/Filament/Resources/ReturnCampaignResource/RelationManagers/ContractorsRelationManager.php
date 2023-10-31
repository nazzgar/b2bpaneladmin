<?php

namespace App\Filament\Resources\ReturnCampaignResource\RelationManagers;

use B2BPanel\SharedModels\Contractor;
use B2BPanel\SharedModels\ReturnCampaign;
use B2BPanel\SharedModels\Services\ReturnLimitsService;
use B2BPanel\SharedModels\ValueObjects\ReturnLimit;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Contracts\HasRelationshipTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table as TablesTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Relation;
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
                Filter::make('logo')
                    ->form([
                        TextInput::make('logo')->label('Logo')->debounce('1000ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['logo'],
                            fn (Builder $query, $logo): Builder => $query->where('logo', 'like', '%' . $logo . '%')
                        );
                    }),
                Filter::make('nip')
                    ->form([
                        TextInput::make('nip')->label('Nip')->debounce('1000ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['nip'],
                            fn (Builder $query, $nip): Builder => $query->where('nip', 'like', '%' . $nip . '%')
                        );
                    }),
                Filter::make('nazwa')
                    ->form([
                        TextInput::make('nazwa')->label('Nazwa')->debounce('1000ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['nazwa'],
                            fn (Builder $query, $nazwa): Builder => $query->where('nazwa', 'like', '%' . $nazwa . '%')
                        );
                    }),
                Filter::make('has_return_limit')
                    ->form([
                        Select::make('has_return_limit')->label('Ma indywidualny limit')->options([
                            'Pokaż wszystko' => 'Pokaż wszystko', 'Tak' => 'Tak', 'Nie' => 'Nie'
                        ])->default('Pokaż wszystko')->disablePlaceholderSelection()
                    ])
                    ->query(function (Builder $query, ContractorsRelationManager $livewire, array $data) {
                        $return_campaign = $livewire->ownerRecord;

                        return match ($data['has_return_limit']) {
                            'Pokaż wszystko' => $query,
                            'Tak' => $query->whereHas('customerUsers', function ($query) use ($return_campaign) {
                                return $query->whereHas('returnLimit', function ($query) use ($return_campaign) {
                                    $query->whereBelongsTo($return_campaign);
                                });
                            }),
                            'Nie' => $query->whereHas('customerUsers', function ($query) use ($return_campaign) {
                                return $query->whereDoesntHave('returnLimit', function ($query) use ($return_campaign) {
                                    $query->whereBelongsTo($return_campaign);
                                });
                            })->orWhereDoesntHave('customerUsers'),
                        };

                        return $query->whereHas('customerUsers', function ($query) {
                            return $query->whereHas('returnLimit', function ($query) {
                                $query->whereBelongsTo(ReturnCampaign::find(9));
                            });
                        });
                    }),
            ], layout: Layout::AboveContent)
            ->headerActions([
                AttachAction::make()->label('Dołącz jednego')->color('primary'),
                Action::make('attach_all')->label('Dołącz wszystkich')->button()->requiresConfirmation()->action(function (ContractorsRelationManager $livewire) {
                    $livewire->ownerRecord->contractors()->syncWithoutDetaching(Contractor::all());
                }),
                Action::make('detach_all')->label('Odłącz wszystkich')->button()->color('danger')->requiresConfirmation()->action(function (ContractorsRelationManager $livewire) {
                    $livewire->ownerRecord->contractors()->sync([]);
                }),
                Action::make('attach_many')->label('Dołączanie wielu')->button()->form([
                    Textarea::make('logos')->placeholder('logo1,
logo2,
logo3...')->required()
                ])->action('attach_many'),
                Action::make('detach_many')->label('Odłączanie wielu')->button()->color('danger')->form([
                    Textarea::make('logos')->placeholder('logo1,
logo2,
logo3...')->required()
                ])->action('detach_many'),
            ])
            ->actions([
                Action::make('remove_return_limit')->label('Usuń limit')
                    ->action(function (Contractor $record, array $data, ReturnLimitsService $return_limits_service, ContractorsRelationManager $livewire) {
                        $return_limits_service->removeReturnLimit($record, $livewire->ownerRecord);
                    })->visible(function (Contractor $record, ReturnLimitsService $return_limits_service, ContractorsRelationManager $livewire) {
                        return $return_limits_service->checkIfReturnLimitExists($record, $livewire->ownerRecord);
                    })->color('danger'),
                Action::make('set_return_limit')->label('Ustaw limit')->modalSubheading('Ustawiony limit będzie aktywny u wszystkich użytkowników podpiętych do danego kontrahenta')
                    ->form([
                        TextInput::make('zabawki')->numeric()->minValue(0)->maxValue(1)->step(0.05),
                        TextInput::make('jezykowe')->numeric()->minValue(0)->maxValue(1)->step(0.05),
                        TextInput::make('jezykowe_oxford')->numeric()->minValue(0)->maxValue(1)->step(0.05),
                        TextInput::make('edukacyjne')->numeric()->minValue(0)->maxValue(1)->step(0.05),
                        TextInput::make('pozostale')->numeric()->minValue(0)->maxValue(1)->step(0.05)
                    ])->mountUsing(function (Forms\ComponentContainer $form, Contractor $record, ContractorsRelationManager $livewire) {

                        $return_limit = $record->customerUsers()->first()->returnLimit->firstWhere('return_campaign_id', $livewire->ownerRecord->id)?->limits;

                        $form->fill([
                            'zabawki' => $return_limit?->zabawki ?? 0,
                            'jezykowe' => $return_limit?->jezykowe ?? 0,
                            'jezykowe_oxford' => $return_limit?->jezykowe_oxford ?? 0,
                            'edukacyjne' => $return_limit?->edukacyjne ?? 0,
                            'pozostale' => $return_limit?->pozostale ?? 0
                        ]);
                    })->action(function (Contractor $record, array $data, ReturnLimitsService $return_limits_service, ContractorsRelationManager $livewire) {

                        $return_limit_value_object = new ReturnLimit(
                            $data['zabawki'],
                            $data['jezykowe'],
                            $data['jezykowe_oxford'],
                            $data['edukacyjne'],
                            $data['pozostale']
                        );

                        $return_limits_service->setReturnLimit($record, $livewire->ownerRecord, $return_limit_value_object);
                    }),

                Tables\Actions\DetachAction::make()->after(function (Contractor $record, ReturnLimitsService $return_limits_service, ContractorsRelationManager $livewire) {
                    $return_limits_service->removeReturnLimit($record, $livewire->ownerRecord);
                })
            ]);
    }

    protected function getTableQuery(): Builder | Relation
    {
        if (!$this instanceof HasRelationshipTable) {
            $livewireClass = static::class;

            throw new Exception("Class [{$livewireClass}] must define a [getTableQuery()] method.");
        }

        $relationship = $this->getRelationship();

        $query = $relationship->getQuery();

        if ($relationship instanceof HasManyThrough) {
            // https://github.com/laravel/framework/issues/4962
            $query->select($query->getModel()->getTable() . '.*');

            return $query;
        }

        if ($relationship instanceof BelongsToMany) {
            // https://github.com/laravel/framework/issues/4962
            if (!$this->allowsDuplicates()) {
                $this->selectPivotDataInQuery($query);
            }

            // https://github.com/filamentphp/filament/issues/2079
            $query->withCasts(
                app($relationship->getPivotClass())->getCasts(),
            );
        }
        /* Add eager loading to prevent 1 + n problem */
        $query->with('customerUsers', 'customerUsers.returnLimit');

        return $query;
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
