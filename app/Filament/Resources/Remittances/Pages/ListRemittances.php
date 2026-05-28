<?php

namespace App\Filament\Resources\Remittances\Pages;

use App\Filament\Resources\Remittances\RemittanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRemittances extends ListRecords
{
    protected static string $resource = RemittanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
