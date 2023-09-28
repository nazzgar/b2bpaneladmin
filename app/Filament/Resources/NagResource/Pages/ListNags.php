<?php

namespace App\Filament\Resources\NagResource\Pages;

use App\Filament\Resources\NagResource;
use B2BPanel\SharedModels\Nag;
use Closure;
use Filament\Forms\Components\Textarea;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListNags extends ListRecords
{
    protected static string $resource = NagResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('Import faktur do liczenia do sumy')
                ->form([
                    Textarea::make('numery')->placeholder('numer1 
numer2
numer3...')->required()
                ])
                ->action('make_nags_returnable'),
            Action::make('Import faktur do wyłączenia liczenia do sumy')
                ->form([
                    Textarea::make('numery')->placeholder('numer1 
numer2
numer3...')->required()
                ])
                ->action('make_nags_unreturnable'),
        ];
    }

    public function make_nags_returnable(array $data): void
    {
        $nag_numbers_array = $this->getNagNumbers($data['numery']);

        Nag::whereIn('numer', $nag_numbers_array)->update(['is_returnable' => true]);
    }

    public function make_nags_unreturnable(array $data): void
    {
        $nag_numbers_array = $this->getNagNumbers($data['numery']);

        Nag::whereIn('numer', $nag_numbers_array)->update(['is_returnable' => false]);
    }

    public function getNagNumbers(string $data): array
    {
        return explode(PHP_EOL, $data);
    }


    //TODO: disable clickable rows. This doesnt work:
    protected function getTableRecordActionUsing(): ?Closure
    {
        return function () {
            return null;
        };
    }
}
