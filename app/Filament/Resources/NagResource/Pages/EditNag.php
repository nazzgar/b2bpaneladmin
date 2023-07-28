<?php

namespace App\Filament\Resources\NagResource\Pages;

use App\Filament\Resources\NagResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNag extends EditRecord
{
    protected static string $resource = NagResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
