<?php

namespace App\Filament\Resources\ReturnmResource\Pages;

use App\Filament\Resources\ReturnmResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReturnms extends ListRecords
{
    protected static string $resource = ReturnmResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
