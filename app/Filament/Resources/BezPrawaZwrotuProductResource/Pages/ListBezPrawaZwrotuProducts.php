<?php

namespace App\Filament\Resources\BezPrawaZwrotuProductResource\Pages;

use App\Filament\Resources\BezPrawaZwrotuProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBezPrawaZwrotuProducts extends ListRecords
{
    protected static string $resource = BezPrawaZwrotuProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
