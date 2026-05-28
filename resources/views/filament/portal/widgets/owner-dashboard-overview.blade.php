<x-filament-widgets::widget>
    <div class="space-y-6">
        <!-- Dashboard Header -->
        <div class="flex items-center justify-between border-b border-gray-800 pb-4">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-white">Owner Portfolio Analytics</h2>
                <p class="text-xs text-gray-400 mt-0.5">Real-time performance ledger for your owned and managed real estate units.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-sm">
                Owner Account Active
            </span>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- YTD Earnings Card -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500/15 via-teal-500/5 to-transparent border border-emerald-500/20 p-5 shadow-sm">
                <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-500/10 rounded-full blur-2xl -mr-6 -mt-6"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold uppercase tracking-wider text-emerald-400">YTD Revenue ({{ date('Y') }})</span>
                    <div class="p-1.5 bg-emerald-500/10 rounded-lg text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-black text-white tracking-tight">
                        ₱{{ number_format($earnings['ytd'], 2) }}
                    </div>
                    <span class="text-[10px] text-gray-400">Net payouts successfully transferred to your account</span>
                </div>
            </div>

            <!-- Current Month Earnings Card -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500/15 via-purple-500/5 to-transparent border border-indigo-500/20 p-5 shadow-sm">
                <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-500/10 rounded-full blur-2xl -mr-6 -mt-6"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold uppercase tracking-wider text-indigo-400">Monthly Remittance ({{ date('M') }})</span>
                    <div class="p-1.5 bg-indigo-500/10 rounded-lg text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-black text-white tracking-tight">
                        ₱{{ number_format($earnings['monthly'], 2) }}
                    </div>
                    <span class="text-[10px] text-gray-400">Remitted payout for the current billing period</span>
                </div>
            </div>

            <!-- Occupancy Card -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500/15 via-sky-500/5 to-transparent border border-blue-500/20 p-5 shadow-sm">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500/10 rounded-full blur-2xl -mr-6 -mt-6"></div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-400">Occupied Units</span>
                    <div class="p-1.5 bg-blue-500/10 rounded-lg text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-black text-white tracking-tight">{{ $portfolio['occupancy_rate'] }}%</span>
                        <span class="text-[10px] text-blue-400 font-semibold">{{ $portfolio['occupied_units'] }}/{{ $portfolio['total_units'] }} Units</span>
                    </div>
                    <!-- sleek progress bar -->
                    <div class="w-full bg-gray-800 rounded-full h-1 mt-1">
                        <div class="bg-gradient-to-r from-blue-400 to-sky-400 h-1 rounded-full" style="width: {{ $portfolio['occupancy_rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Remittance Logs -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 shadow-sm">
            <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Recent Payout Remittances
            </h3>
            
            <div class="overflow-x-auto rounded-lg border border-gray-800">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-gray-950 text-gray-400 uppercase tracking-wider border-b border-gray-800">
                            <th class="p-3">Property Unit</th>
                            <th class="p-3">Remittance Date</th>
                            <th class="p-3 text-right">Payout Amount</th>
                            <th class="p-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        @forelse($recentRemittances as $remit)
                            <tr class="hover:bg-gray-800/20 transition-colors">
                                <td class="p-3 font-semibold text-white">
                                    {{ $remit->unit?->property?->name ?? 'N/A' }} - Unit {{ $remit->unit?->unit_number ?? 'N/A' }}
                                </td>
                                <td class="p-3 text-gray-400 font-medium">
                                    {{ \Carbon\Carbon::parse($remit->remittance_date)->format('M d, Y') }}
                                </td>
                                <td class="p-3 text-right font-bold text-emerald-400">
                                    ₱{{ number_format($remit->amount, 2) }}
                                </td>
                                <td class="p-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wide border {{ $remit->status === 'transferred' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20' }}">
                                        {{ ucwords($remit->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-5 text-center text-gray-500 font-medium">No payouts remitted to your account yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
