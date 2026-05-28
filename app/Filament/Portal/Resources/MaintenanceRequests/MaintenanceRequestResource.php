<?php

namespace App\Filament\Portal\Resources\MaintenanceRequests;

use App\Filament\Portal\Resources\MaintenanceRequests\Pages\CreateMaintenanceRequest;
use App\Filament\Portal\Resources\MaintenanceRequests\Pages\ListMaintenanceRequests;
use App\Filament\Portal\Resources\MaintenanceRequests\Schemas\MaintenanceRequestForm;
use App\Filament\Portal\Resources\MaintenanceRequests\Tables\MaintenanceRequestsTable;
use App\Models\MaintenanceRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class MaintenanceRequestResource extends Resource
{
    protected static ?string $model = MaintenanceRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|UnitEnum|null $navigationGroup = 'Operations';

    protected static ?string $navigationLabel = 'Maintenance Tickets';

    public static function form(Schema $schema): Schema
    {
        return MaintenanceRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceRequestsTable::configure($table);
    }

    /**
     * Scope query based on role.
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
            return $query->whereIn('unit_id', $ownedUnitIds);
        }

        return $query->whereRaw('1 = 0');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isTenant() ?? false;
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
            'index' => ListMaintenanceRequests::route('/'),
            'create' => CreateMaintenanceRequest::route('/create'),
        ];
    }
}
