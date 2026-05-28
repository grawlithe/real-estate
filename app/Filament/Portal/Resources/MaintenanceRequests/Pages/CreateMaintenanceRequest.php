<?php

namespace App\Filament\Portal\Resources\MaintenanceRequests\Pages;

use App\Filament\Portal\Resources\MaintenanceRequests\MaintenanceRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceRequest extends CreateRecord
{
    protected static string $resource = MaintenanceRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tenant_id'] = auth()->id();
        $data['status'] = 'pending';

        return $data;
    }
}
