<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $new_data = [
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
        ];

        return $new_data;
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email'),
            TextInput::make('name')->label('Nazwa'),
            TextInput::make('password')->label('Hasło')->password()->required()->disableAutocomplete()->confirmed(),
            TextInput::make('password_confirmation')->label('Potwierdź hasło')->password()->required()->disableAutocomplete()
        ];
    }
}
