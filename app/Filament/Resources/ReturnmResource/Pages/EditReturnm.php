<?php

namespace App\Filament\Resources\ReturnmResource\Pages;

use App\Filament\Resources\ReturnmResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReturnm extends EditRecord
{
    protected static string $resource = ReturnmResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
