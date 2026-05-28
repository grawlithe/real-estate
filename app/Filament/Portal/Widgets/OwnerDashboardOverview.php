<?php

namespace App\Filament\Portal\Widgets;

use App\Models\Expense;
use App\Models\Remittance;
use App\Models\Unit;
use App\Models\UnitOwner;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class OwnerDashboardOverview extends Widget
{
    protected string $view = 'filament.portal.widgets.owner-dashboard-overview';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->isOwner() ?? false;
    }

    /**
     * Get the data for the widget.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $user = auth()->user();
        if (! $user) {
            return [];
        }

        // Get owned unit IDs
        $ownedUnitIds = UnitOwner::where('user_id', $user->id)->pluck('unit_id')->toArray();

        // 1. Total Units owned & Statuses
        $totalUnitsCount = count($ownedUnitIds);
        $units = Unit::whereIn('id', $ownedUnitIds)->get();
        $occupiedUnitsCount = $units->where('status', 'occupied')->count();
        $occupancyRate = $totalUnitsCount > 0 ? round(($occupiedUnitsCount / $totalUnitsCount) * 100, 1) : 0;

        // 2. YTD Income (Sum of processed remittances)
        $ytdRemittances = Remittance::where('owner_id', $user->id)
            ->where('status', 'transferred')
            ->whereYear('remittance_date', Carbon::now()->year)
            ->sum('amount');

        // 3. Current Month Income (This month's remittances)
        $monthlyRemittances = Remittance::where('owner_id', $user->id)
            ->where('status', 'transferred')
            ->whereMonth('remittance_date', Carbon::now()->month)
            ->whereYear('remittance_date', Carbon::now()->year)
            ->sum('amount');

        // 4. Expenses related to owned units
        $totalExpenses = Expense::whereIn('unit_id', $ownedUnitIds)->sum('amount');

        // 5. Recent payouts
        $recentRemittances = Remittance::where('owner_id', $user->id)
            ->with('unit.property')
            ->latest('remittance_date')
            ->limit(5)
            ->get();

        return [
            'portfolio' => [
                'total_units' => $totalUnitsCount,
                'occupied_units' => $occupiedUnitsCount,
                'occupancy_rate' => $occupancyRate,
            ],
            'earnings' => [
                'ytd' => $ytdRemittances,
                'monthly' => $monthlyRemittances,
                'expenses' => $totalExpenses,
            ],
            'recentRemittances' => $recentRemittances,
        ];
    }
}
