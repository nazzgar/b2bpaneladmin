<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerUserResource\Pages;
use App\Filament\Resources\CustomerUserResource\RelationManagers;
use B2BPanel\SharedModels\CustomerUser;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerUserResource extends Resource
{
    protected static ?string $model = CustomerUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $modelLabel = 'Użytkownik';

    protected static ?string $pluralModelLabel = 'Użytkownicy';

    /* TODO: create, update form, change password, login as actions */


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email'),
                TextInput::make('password')->label('Hasło')->password()->required()->disableAutocomplete()->confirmed(),
                TextInput::make('password_confirmation')->label('Potwierdź hasło')->password()->required()->disableAutocomplete()
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')->sortable(),
                TextColumn::make('created_at')->label('Data utworzenia')->sortable()
            ])
            ->filters([
                Filter::make('email')
                    ->form([
                        TextInput::make('email')->debounce('500ms')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['email'],
                            fn (Builder $query, $email): Builder => $query->where('email', 'like', $email . '%')
                        );
                    }),
                Filter::make('logo')
                    ->form([
                        TextInput::make('logo')->debounce('500ms')->label('Logo kontrahenta')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['logo'],
                            function ($query, $logo) {
                                $query->whereExists(function ($query) use ($logo) {
                                    $query->select(DB::raw(1))->from('contractor_customer_user')
                                        ->where('contractor_customer_user.logo', 'like', '%' . $logo . '%')
                                        ->whereColumn('contractor_customer_user.customer_user_id', 'customer_users.id');
                                });
                            }
                            //fn (Builder $query, $email): Builder => $query->where('email', 'like', $email . '%')
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
            RelationManagers\ContractorsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerUsers::route('/'),
            'create' => Pages\CreateCustomerUser::route('/create'),
            'edit' => Pages\EditCustomerUser::route('/{record}/edit'),
        ];
    }
}
