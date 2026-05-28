<?php

namespace App\Filament\Portal\Widgets;

use App\Models\Invoice;
use App\Models\Lease;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class TenantRentStatus extends Widget
{
    protected string $view = 'filament.portal.widgets.tenant-rent-status';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->isTenant() ?? false;
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

        // Get unpaid / overdue invoices
        $unpaidInvoices = Invoice::where('tenant_id', $user->id)
            ->whereIn('status', ['unpaid', 'overdue', 'partially_paid'])
            ->orderBy('due_date', 'asc')
            ->get();

        $rentBalance = $unpaidInvoices->sum(fn ($inv) => $inv->amount_due - $inv->amount_paid);
        $nextInvoice = $unpaidInvoices->first();
        $nextDueDate = $nextInvoice ? Carbon::parse($nextInvoice->due_date)->format('M d, Y') : 'No active due date';

        // Lease details
        $activeLease = Lease::where('tenant_id', $user->id)
            ->where('status', 'active')
            ->with('unit.property')
            ->first();

        $renewalAlert = false;
        $daysToRenewal = 0;
        if ($activeLease) {
            $endDate = Carbon::parse($activeLease->end_date);
            $daysToRenewal = Carbon::now()->diffInDays($endDate, false);
            if ($daysToRenewal >= 0 && $daysToRenewal <= 30) {
                $renewalAlert = true;
            }
        }

        return [
            'rentBalance' => $rentBalance,
            'nextDueDate' => $nextDueDate,
            'nextInvoice' => $nextInvoice,
            'lease' => $activeLease,
            'renewal' => [
                'alert' => $renewalAlert,
                'days' => $daysToRenewal,
                'end_date' => $activeLease ? Carbon::parse($activeLease->end_date)->format('M d, Y') : null,
            ],
            'unpaidInvoices' => $unpaidInvoices,
        ];
    }
}
