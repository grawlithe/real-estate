<?php

namespace App\Filament\Portal\Resources\Expenses;

use App\Filament\Portal\Resources\Expenses\Pages\ListExpenses;
use App\Filament\Portal\Resources\Expenses\Schemas\ExpenseForm;
use App\Filament\Portal\Resources\Expenses\Tables\ExpensesTable;
use App\Models\Expense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedReceiptPercent;

    protected static string|UnitEnum|null $navigationGroup = 'My Portfolio';

    protected static ?string $navigationLabel = 'Expense Ledger';

    public static function form(Schema $schema): Schema
    {
        return ExpenseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExpensesTable::configure($table);
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

        $ownedUnitIds = \App\Models\UnitOwner::where('user_id', $user->id)->pluck('unit_id')->toArray();
        return $query->whereIn('unit_id', $ownedUnitIds);
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
            'index' => ListExpenses::route('/'),
        ];
    }
}
