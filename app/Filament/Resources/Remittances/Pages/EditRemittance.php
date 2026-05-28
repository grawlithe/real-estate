<?php

namespace App\Filament\Resources\Remittances\Pages;

use App\Filament\Resources\Remittances\RemittanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRemittance extends EditRecord
{
    protected static string $resource = RemittanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
