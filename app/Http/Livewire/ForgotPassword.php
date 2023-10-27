<?php

namespace App\Http\Livewire;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component implements HasForms
{
    use InteractsWithForms;

    public $email = '';

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')->label('Email')->email()->required()
        ];
    }

    public function submit(): void
    {
        $status = Password::sendResetLink($this->form->getState());

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('message', 'Link do ustawienia nowego hasła został wysłany');
            redirect(route('filament.auth.login'));
        } else {
            session()->flash('message', 'Błąd. Proszę odświeżyć strone i spróbować ponownie');
        }
    }

    public function render()
    {
        return view('livewire.forgot-password')->layout('filament::components.layouts.card', [
            'title' => 'Przypomnij hasło',
        ]);
    }
}
