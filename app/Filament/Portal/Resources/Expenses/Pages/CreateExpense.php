<?php

namespace App\Filament\Portal\Resources\Expenses\Pages;

use App\Filament\Portal\Resources\Expenses\ExpenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;
}
