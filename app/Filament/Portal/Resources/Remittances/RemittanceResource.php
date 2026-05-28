<?php

namespace App\Filament\Portal\Resources\Remittances;

use App\Filament\Portal\Resources\Remittances\Pages\CreateRemittance;
use App\Filament\Portal\Resources\Remittances\Pages\EditRemittance;
use App\Filament\Portal\Resources\Remittances\Pages\ListRemittances;
use App\Filament\Portal\Resources\Remittances\Schemas\RemittanceForm;
use App\Filament\Portal\Resources\Remittances\Tables\RemittancesTable;
use App\Models\Remittance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RemittanceResource extends Resource
{
    protected static ?string $model = Remittance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RemittanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RemittancesTable::configure($table);
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
            'create' => CreateRemittance::route('/create'),
            'edit' => EditRemittance::route('/{record}/edit'),
        ];
    }
}
