<?php

namespace App\Filament\Resources\ReturnCampaignResource\Pages;

use App\Filament\Resources\ReturnCampaignResource;
use B2BPanel\SharedModels\ReturnCampaign;
use B2BPanel\SharedModels\ReturnLimit as ReturnLimitModel;
use B2BPanel\SharedModels\ValueObjects\ReturnLimit;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CreateReturnCampaign extends CreateRecord
{
    protected static string $resource = ReturnCampaignResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $main = Arr::only($data, ['name', 'date_start', 'date_end', 'invoices_from', 'invoices_to']);

        $return_limit_value_object = new ReturnLimit(
            $data['zabawki'],
            $data['jezykowe'],
            $data['jezykowe_oxford'],
            $data['edukacyjne'],
            $data['pozostale']
        );

        return ReturnCampaign::create(
            array_merge(
                $main,
                [
                    'limits' => $return_limit_value_object
                ]
            )
        );
    }
}
