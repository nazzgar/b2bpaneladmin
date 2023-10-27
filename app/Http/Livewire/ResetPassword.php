<?php

namespace App\Http\Livewire;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Illuminate\Support\Str;

class ResetPassword extends Component implements HasForms
{
    use InteractsWithForms;

    public $email = '';

    public string $token;

    public function mount(string $token): void
    {
        request()->whenHas('email', function (string $email) {
            $this->email = $email;
        });

        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->token = $token;

        $this->form->fill([
            'email' => $this->email
        ]);
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')->label('Email')->email()->required(),
            TextInput::make('password')->label('Hasło')->password()->required()->confirmed(),
            TextInput::make('password_confirmation')->label('Powtórz hasło')->password()->required()
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        $data = array_merge($data, ['token' => $this->token]);

        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );


        if ($status === Password::PASSWORD_RESET) {
            session()->flash('message', 'Hasło zmienione');
            redirect(route('filament.auth.login'));
        } else {
            session()->flash('message', 'Błąd. Proszę spróbować ponownie');
        }
    }

    public function render()
    {
        return view('livewire.reset-password')->layout('filament::components.layouts.card', [
            'title' => 'Ustaw nowe hasło',
        ]);
    }
}
