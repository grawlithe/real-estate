<?php

namespace App\Filament\Portal\Resources\Units;

use App\Filament\Portal\Resources\Units\Pages\ListUnits;
use App\Filament\Portal\Resources\Units\Schemas\UnitForm;
use App\Filament\Portal\Resources\Units\Tables\UnitsTable;
use App\Models\Unit;
use App\Models\UnitOwner;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static string|UnitEnum|null $navigationGroup = 'My Portfolio';

    protected static ?string $navigationLabel = 'My Units';

    public static function form(Schema $schema): Schema
    {
        return UnitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnitsTable::configure($table);
    }

    /**
     * Scope query to owner's units.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user || ! $user->isOwner()) {
            return $query->whereRaw('1 = 0');
        }

        $ownedUnitIds = UnitOwner::where('user_id', $user->id)->pluck('unit_id')->toArray();

        return $query->whereIn('id', $ownedUnitIds);
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
            'index' => ListUnits::route('/'),
        ];
    }
}
