<div class="space-y-4">

    @if (session()->has('message'))

    <div class="message message-error">

        {{ session('message') }}

    </div>

    @endif

    <form wire:submit.prevent="submit" class="space-y-8">
        {{ $this->form }}

        <x-filament::button type="submit" form="submit" class="w-full">
            {{ __('filament::login.buttons.submit.label') }}
        </x-filament::button>
    </form>

    <a href="{{route('forgot-password')}}" class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400">Przypomnij hasło</a>
</div>