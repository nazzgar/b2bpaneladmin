<div class="space-y-4">

    @if (session()->has('message'))

    <div class="message message-error">

        {{ session('message') }}

    </div>

    @endif



    <form wire:submit.prevent="submit" class="space-y-8">
        <span>Podaj swój adres email powiązany z kontem. Na adres zostanie wysłany link do ustawienia nowego hasła.</span>

        {{ $this->form }}

        <x-filament::button type="submit" class="w-full">
            Wyślij link
        </x-filament::button>

    </form>

    <a href="{{route('filament.auth.login')}}" class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400">Logowanie</a>

</div>