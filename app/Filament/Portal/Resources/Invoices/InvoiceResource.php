<?php

namespace App\Filament\Portal\Resources\Invoices;

use App\Filament\Portal\Resources\Invoices\Pages\ListInvoices;
use App\Filament\Portal\Resources\Invoices\Schemas\InvoiceForm;
use App\Filament\Portal\Resources\Invoices\Tables\InvoicesTable;
use App\Models\Invoice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static string|UnitEnum|null $navigationGroup = 'My Financials';

    protected static ?string $navigationLabel = 'My Invoices';

    public static function form(Schema $schema): Schema
    {
        return InvoiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvoicesTable::configure($table);
    }

    /**
     * Scope query to active user.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->isTenant()) {
            return $query->where('tenant_id', $user->id);
        }

        if ($user->isOwner()) {
            $ownedUnitIds = \App\Models\UnitOwner::where('user_id', $user->id)->pluck('unit_id')->toArray();
            return $query->whereHas('lease', fn ($q) => $q->whereIn('unit_id', $ownedUnitIds));
        }

        return $query->whereRaw('1 = 0');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvoices::route('/'),
        ];
    }
}
