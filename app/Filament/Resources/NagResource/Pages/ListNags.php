<?php

namespace App\Filament\Resources\NagResource\Pages;

use App\Filament\Resources\NagResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNags extends ListRecords
{
    protected static string $resource = NagResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
