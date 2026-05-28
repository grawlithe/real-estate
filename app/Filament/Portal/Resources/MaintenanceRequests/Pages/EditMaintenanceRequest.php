<?php

namespace App\Filament\Portal\Resources\MaintenanceRequests\Pages;

use App\Filament\Portal\Resources\MaintenanceRequests\MaintenanceRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceRequest extends EditRecord
{
    protected static string $resource = MaintenanceRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
