<?php

namespace App\Filament\Portal\Resources\Invoices\Pages;

use App\Filament\Portal\Resources\Invoices\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;
}
