<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            /* Action::make('login_as')->action(function () {
                Auth::login($this->record);
                
            }), */
            Action::make('change_password')
                ->label('Zmień hasło')
                ->form([
                    TextInput::make('password')->label('Nowe hasło')->password()->required()->disableAutocomplete()->confirmed(),
                    TextInput::make('password_confirmation')->label('Potwierdź nowe hasło')->password()->required()->disableAutocomplete()
                ])->action(function (array $data): void {
                    $this->record->update([
                        'password' => Hash::make($data['password'])
                    ]);
                    Notification::make()->title('Hasło zmienione')->success()->seconds(15)
                        ->send();
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
