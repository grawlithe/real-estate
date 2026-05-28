<?php

namespace App\Filament\Portal\Resources\Remittances\Pages;

use App\Filament\Portal\Resources\Remittances\RemittanceResource;
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
