<x-filament-widgets::widget>
    <div class="space-y-6">
        <!-- Dashboard Header -->
        <div class="flex items-center justify-between border-b border-gray-800 pb-4">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-white">Tenant Dashboard Overview</h2>
                <p class="text-xs text-gray-400 mt-0.5">Welcome! Track your active lease terms, monthly statements, and submit repair requests.</p>
            </div>
            @if($lease)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 shadow-sm">
                    {{ $lease->unit?->property?->name ?? 'Property' }} - Unit {{ $lease->unit?->unit_number ?? 'N/A' }}
                </span>
            @endif
        </div>

        <!-- Renewal Notice Alert -->
        @if($renewal['alert'])
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-amber-500/15 via-orange-500/10 to-transparent border border-amber-500/30 p-4 flex items-start gap-3 shadow-sm">
                <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl -mr-6 -mt-6"></div>
                <div class="p-2 bg-amber-500/10 rounded-lg text-amber-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-white text-sm">Lease Ending Soon!</h4>
                    <p class="text-xs text-gray-300 mt-0.5">Your lease is expiring on <span class="font-bold text-amber-400">{{ $renewal['end_date'] }}</span> (in <span class="font-extrabold text-amber-400">{{ $renewal['days'] }} days</span>). Please contact your Property Manager to coordinate a lease renewal or move-out schedule.</p>
                </div>
            </div>
        @endif

        <!-- Tenant Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Rent Balance Card -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-500/15 via-pink-500/5 to-transparent border border-rose-500/20 p-5 shadow-sm md:col-span-2">
                <div class="absolute top-0 right-0 w-24 h-24 bg-rose-500/10 rounded-full blur-2xl -mr-6 -mt-6"></div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-rose-400 block">Total Outstanding Balance</span>
                        <p class="text-xs text-gray-400 mt-0.5">Total unpaid invoice statements for your active lease contract</p>
                    </div>
                    <div class="p-2 bg-rose-500/10 rounded-lg text-rose-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="text-3xl font-black text-white tracking-tight">
                        ₱{{ number_format($rentBalance, 2) }}
                    </div>
                    @if($rentBalance > 0)
                        <a href="{{ route('filament.portal.resources.invoices.index') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-sm hover:opacity-90 active:scale-[0.98] transition-all">
                            Pay Statement Now
                            <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @else
                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-sm">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Account Settled
                        </span>
                    @endif
                </div>
            </div>

            <!-- Next Due Date Card -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500/15 via-blue-500/5 to-transparent border border-indigo-500/20 p-5 shadow-sm">
                <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-500/10 rounded-full blur-2xl -mr-6 -mt-6"></div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold uppercase tracking-wider text-indigo-400">Next Payment Due</span>
                    <div class="p-1.5 bg-indigo-500/10 rounded-lg text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-xl font-black text-white tracking-tight">
                        {{ $nextDueDate }}
                    </div>
                    @if($nextInvoice)
                        <span class="text-[10px] text-rose-400 font-bold block">{{ $nextInvoice->invoice_number }} (₱{{ number_format($nextInvoice->amount_due - $nextInvoice->amount_paid, 2) }})</span>
                    @else
                        <span class="text-[10px] text-gray-400 block">No pending invoices due.</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pending Invoices list -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 shadow-sm">
            <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Outstanding Billing Invoice Ledger
            </h3>
            
            <div class="overflow-x-auto rounded-lg border border-gray-800">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-gray-950 text-gray-400 uppercase tracking-wider border-b border-gray-800">
                            <th class="p-3">Invoice Statement</th>
                            <th class="p-3">Due Date</th>
                            <th class="p-3 text-right">Invoiced Amount</th>
                            <th class="p-3 text-right">Amount Paid</th>
                            <th class="p-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        @forelse($unpaidInvoices as $inv)
                            <tr class="hover:bg-gray-800/20 transition-colors">
                                <td class="p-3 font-semibold text-white">
                                    {{ $inv->invoice_number }}
                                </td>
                                <td class="p-3 text-gray-400 font-medium">
                                    {{ \Carbon\Carbon::parse($inv->due_date)->format('M d, Y') }}
                                </td>
                                <td class="p-3 text-right text-gray-300 font-semibold">
                                    ₱{{ number_format($inv->amount_due, 2) }}
                                </td>
                                <td class="p-3 text-right text-gray-400">
                                    ₱{{ number_format($inv->amount_paid, 2) }}
                                </td>
                                <td class="p-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wide border {{ $inv->status === 'overdue' ? 'bg-red-500/10 text-red-400 border-red-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20' }}">
                                        {{ ucwords($inv->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-5 text-center text-gray-500 font-medium">No outstanding invoices. You are fully paid up! Thank you!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
