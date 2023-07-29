<?php

namespace App\Filament\Resources\BezPrawaZwrotuProductResource\Pages;

use App\Filament\Resources\BezPrawaZwrotuProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBezPrawaZwrotuProduct extends EditRecord
{
    protected static string $resource = BezPrawaZwrotuProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
