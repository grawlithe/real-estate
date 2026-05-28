<?php

namespace App\Filament\Pages;

use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Unit;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Reports extends Page
{
    protected string $view = 'filament.pages.reports';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Financials';

    protected static ?string $navigationLabel = 'Business Reports';

    /**
     * Get the view data for the page.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        // 1. Occupancy Analytics
        $totalUnits = Unit::count();
        $occupiedUnits = Unit::where('status', 'occupied')->count();
        $vacantUnits = Unit::where('status', 'vacant')->count();
        $maintenanceUnits = Unit::where('status', 'under_maintenance')->count();
        $occupancyRate = $totalUnits > 0 ? round(($occupiedUnits / $totalUnits) * 100, 1) : 0;

        // 2. Collection Efficiency Analytics
        $totalAmountDue = Invoice::sum('amount_due');
        $totalAmountPaid = Invoice::sum('amount_paid');
        $collectionEfficiency = $totalAmountDue > 0 ? round(($totalAmountPaid / $totalAmountDue) * 100, 1) : 0;
        $totalOutstanding = $totalAmountDue - $totalAmountPaid;

        // 3. Profit & Loss Metrics
        $totalRevenue = Payment::where('status', 'approved')->sum('amount');
        $totalExpenses = Expense::sum('amount');
        $netProfit = $totalRevenue - $totalExpenses;

        // 4. Aging Receivables Calculation
        $overdueInvoices = Invoice::whereIn('status', ['unpaid', 'overdue'])
            ->with(['tenant', 'lease.unit.property'])
            ->get();

        $aging = [
            '1_30' => 0.00,
            '31_60' => 0.00,
            '61_90' => 0.00,
            '91_plus' => 0.00,
            'total' => 0.00,
        ];

        $agingDetails = [];

        foreach ($overdueInvoices as $invoice) {
            $dueDate = Carbon::parse($invoice->due_date);
            $daysOverdue = $dueDate->diffInDays(Carbon::now(), false);
            $remaining = max(0.00, $invoice->amount_due - $invoice->amount_paid);

            if ($daysOverdue > 0 && $remaining > 0) {
                $aging['total'] += $remaining;
                if ($daysOverdue <= 30) {
                    $aging['1_30'] += $remaining;
                } elseif ($daysOverdue <= 60) {
                    $aging['31_60'] += $remaining;
                } elseif ($daysOverdue <= 90) {
                    $aging['61_90'] += $remaining;
                } else {
                    $aging['91_plus'] += $remaining;
                }

                $agingDetails[] = [
                    'invoice_number' => $invoice->invoice_number,
                    'tenant_name' => $invoice->tenant?->name ?? 'N/A',
                    'unit' => ($invoice->lease?->unit?->property?->name ?? 'N/A') . ' - ' . ($invoice->lease?->unit?->unit_number ?? 'N/A'),
                    'due_date' => $dueDate->format('M d, Y'),
                    'amount' => $remaining,
                    'days_overdue' => $daysOverdue,
                ];
            }
        }

        // Sort aging details by most overdue
        usort($agingDetails, fn ($a, $b) => $b['days_overdue'] <=> $a['days_overdue']);

        // 5. Unit Level Profitability performance
        $unitsPerformance = Unit::with(['property', 'expenses', 'leases.invoices', 'remittances'])->get()
            ->map(function (Unit $unit) {
                $rentIncome = $unit->leases->flatMap(fn ($l) => $l->invoices)->where('status', 'paid')->sum('amount_paid');
                $expenses = $unit->expenses->sum('amount');
                $payouts = $unit->remittances->sum('amount');
                return [
                    'property' => $unit->property?->name ?? 'N/A',
                    'unit_number' => $unit->unit_number,
                    'ownership_type' => ucwords(str_replace('_', ' ', $unit->ownership_type)),
                    'status' => ucwords(str_replace('_', ' ', $unit->status)),
                    'income' => $rentIncome,
                    'expenses' => $expenses,
                    'payouts' => $payouts,
                    'net' => $rentIncome - $expenses,
                ];
            });

        return [
            'occupancy' => [
                'total' => $totalUnits,
                'occupied' => $occupiedUnits,
                'vacant' => $vacantUnits,
                'maintenance' => $maintenanceUnits,
                'rate' => $occupancyRate,
            ],
            'collection' => [
                'due' => $totalAmountDue,
                'paid' => $totalAmountPaid,
                'efficiency' => $collectionEfficiency,
                'outstanding' => $totalOutstanding,
            ],
            'financials' => [
                'revenue' => $totalRevenue,
                'expenses' => $totalExpenses,
                'net' => $netProfit,
            ],
            'aging' => $aging,
            'agingDetails' => array_slice($agingDetails, 0, 10), // Top 10 aging invoices
            'unitsPerformance' => $unitsPerformance,
        ];
    }
}
