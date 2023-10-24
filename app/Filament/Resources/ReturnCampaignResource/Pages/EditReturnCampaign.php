<?php

namespace App\Filament\Resources\ReturnCampaignResource\Pages;

use App\Filament\Resources\ReturnCampaignResource;
use B2BPanel\SharedModels\ValueObjects\ReturnLimit;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditReturnCampaign extends EditRecord
{
    protected static string $resource = ReturnCampaignResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /* https://filamentphp.com/docs/2.x/admin/resources/editing-records#customizing-data-before-filling-the-form */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $main = Arr::only($data, ['name', 'date_start', 'date_end', 'invoices_from', 'invoices_to']);

        $return_limit_value_object = new ReturnLimit(
            $data['zabawki'],
            $data['jezykowe'],
            $data['jezykowe_oxford'],
            $data['edukacyjne'],
            $data['pozostale']
        );

        $record->update(
            array_merge(
                $main,
                [
                    'limits' => $return_limit_value_object
                ]
            )
        );

        return $record;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return array_merge(
            $data,
            [
                'zabawki' => $data['limits']->zabawki,
                'jezykowe' => $data['limits']->jezykowe,
                'jezykowe_oxford' => $data['limits']->jezykowe_oxford,
                'edukacyjne' => $data['limits']->edukacyjne,
                'pozostale' => $data['limits']->pozostale,
            ]
        );
    }
}
