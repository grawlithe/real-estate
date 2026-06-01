<?php

namespace App\Filament\Portal\Resources\Remittances;

use App\Filament\Portal\Resources\Remittances\Pages\ListRemittances;
use App\Filament\Portal\Resources\Remittances\Schemas\RemittanceForm;
use App\Filament\Portal\Resources\Remittances\Tables\RemittancesTable;
use App\Models\Remittance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class RemittanceResource extends Resource
{
    protected static ?string $model = Remittance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWallet;

    protected static string|UnitEnum|null $navigationGroup = 'My Portfolio';

    protected static ?string $navigationLabel = 'My Payouts';

    public static function form(Schema $schema): Schema
    {
        return RemittanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RemittancesTable::configure($table);
    }

    /**
     * Scope query to owner payouts.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user || ! $user->isOwner()) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where('owner_id', $user->id);
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->isOwner() ?? false;
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
            'index' => ListRemittances::route('/'),
        ];
    }
}
