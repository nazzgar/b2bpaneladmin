<?php

namespace App\Filament\Resources\ReturnCampaignResource\Pages;

use App\Filament\Resources\ReturnCampaignResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReturnCampaigns extends ListRecords
{
    protected static string $resource = ReturnCampaignResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
