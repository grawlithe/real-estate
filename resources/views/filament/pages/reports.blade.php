<x-filament-panels::page>
    <div class="space-y-6">
        <!-- 1. Executive Analytics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- P&L Card -->
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500/10 via-purple-500/5 to-transparent border border-indigo-500/20 p-6 shadow-sm transition-all duration-300 hover:shadow-md hover:scale-[1.01]">
                <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl -mr-6 -mt-6"></div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold tracking-wider text-indigo-400 uppercase">Financial Health</span>
                    <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-400">
                        <svg class="w-6 h-6 shrink-0" width="24" height="24" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-2">
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Net Operating Profit</h3>
                    <div class="text-3xl font-extrabold text-white tracking-tight">
                        ₱{{ number_format($financials['net'], 2) }}
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-800 grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400 block mb-0.5">Gross Revenue</span>
                        <span class="font-bold text-emerald-400">₱{{ number_format($financials['revenue'], 2) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block mb-0.5">Total Expenses</span>
                        <span class="font-bold text-rose-400">₱{{ number_format($financials['expenses'], 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Occupancy Analytics Card -->
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500/10 via-teal-500/5 to-transparent border border-emerald-500/20 p-6 shadow-sm transition-all duration-300 hover:shadow-md hover:scale-[1.01]">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl -mr-6 -mt-6"></div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold tracking-wider text-emerald-400 uppercase">Portfolio
                        Occupancy</span>
                    <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400">
                        <svg class="w-6 h-6 shrink-0" width="24" height="24" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-2">
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Current Occupancy Rate</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-extrabold text-white tracking-tight">{{ $occupancy['rate'] }}%</span>
                        <span
                            class="text-xs text-emerald-400 font-semibold">{{ $occupancy['occupied'] }}/{{ $occupancy['total'] }}
                            Units</span>
                    </div>
                    <!-- Custom sleek progress bar -->
                    <div class="w-full bg-gray-800 rounded-full h-1.5 mt-2">
                        <div class="bg-gradient-to-r from-emerald-400 to-teal-400 h-1.5 rounded-full"
                            style="width: {{ $occupancy['rate'] }}%"></div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-800 grid grid-cols-3 gap-2 text-center text-xs">
                    <div>
                        <span class="text-gray-400 block mb-0.5">Vacant</span>
                        <span class="font-bold text-white">{{ $occupancy['vacant'] }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block mb-0.5">Occupied</span>
                        <span class="font-bold text-emerald-400">{{ $occupancy['occupied'] }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block mb-0.5">Maintenance</span>
                        <span class="font-bold text-amber-500">{{ $occupancy['maintenance'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Collection Efficiency Card -->
            <div
                class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500/10 via-orange-500/5 to-transparent border border-amber-500/20 p-6 shadow-sm transition-all duration-300 hover:shadow-md hover:scale-[1.01]">
                <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl -mr-6 -mt-6"></div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold tracking-wider text-amber-400 uppercase">Billing
                        Operations</span>
                    <div class="p-2 bg-amber-500/10 rounded-lg text-amber-400">
                        <svg class="w-6 h-6 shrink-0" width="24" height="24" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-2">
                    <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Collection Efficiency</h3>
                    <div class="flex items-baseline gap-2">
                        <span
                            class="text-3xl font-extrabold text-white tracking-tight">{{ $collection['efficiency'] }}%</span>
                        <span
                            class="text-xs text-amber-400 font-semibold">₱{{ number_format($collection['outstanding'], 2) }}
                            Outstanding</span>
                    </div>
                    <div class="w-full bg-gray-800 rounded-full h-1.5 mt-2">
                        <div class="bg-gradient-to-r from-amber-400 to-orange-400 h-1.5 rounded-full"
                            style="width: {{ $collection['efficiency'] }}%"></div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-800 grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400 block mb-0.5">Total Invoiced</span>
                        <span class="font-bold text-white">₱{{ number_format($collection['due'], 2) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block mb-0.5">Total Collected</span>
                        <span class="font-bold text-emerald-400">₱{{ number_format($collection['paid'], 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Aging Receivables Dashboard -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Aging Receivables Breakdown -->
            <div class="lg:col-span-1 bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-sm">
                <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0 text-indigo-400" width="20" height="20" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Receivables Aging Bracket
                </h3>

                <div class="space-y-4">
                    <!-- Bracket 1 -->
                    <div>
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="text-gray-400">1 - 30 Days Overdue</span>
                            <span class="font-semibold text-white">₱{{ number_format($aging['1_30'], 2) }}</span>
                        </div>
                        <div class="w-full bg-gray-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-amber-400 h-full rounded-full"
                                style="width: {{ $aging['total'] > 0 ? ($aging['1_30'] / $aging['total'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Bracket 2 -->
                    <div>
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="text-gray-400">31 - 60 Days Overdue</span>
                            <span class="font-semibold text-white">₱{{ number_format($aging['31_60'], 2) }}</span>
                        </div>
                        <div class="w-full bg-gray-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-orange-400 h-full rounded-full"
                                style="width: {{ $aging['total'] > 0 ? ($aging['31_60'] / $aging['total'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Bracket 3 -->
                    <div>
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="text-gray-400">61 - 90 Days Overdue</span>
                            <span class="font-semibold text-white">₱{{ number_format($aging['61_90'], 2) }}</span>
                        </div>
                        <div class="w-full bg-gray-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-rose-500 h-full rounded-full"
                                style="width: {{ $aging['total'] > 0 ? ($aging['61_90'] / $aging['total'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Bracket 4 -->
                    <div>
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="text-gray-400">91+ Days Overdue</span>
                            <span class="font-semibold text-white">₱{{ number_format($aging['91_plus'], 2) }}</span>
                        </div>
                        <div class="w-full bg-gray-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-red-600 h-full rounded-full"
                                style="width: {{ $aging['total'] > 0 ? ($aging['91_plus'] / $aging['total'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-800 flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-400">Total Delinquent</span>
                    <span class="text-lg font-black text-rose-500">₱{{ number_format($aging['total'], 2) }}</span>
                </div>
            </div>

            <!-- Overdue Invoices Ledger -->
            <div
                class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-sm overflow-hidden flex flex-col">
                <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0 text-rose-400" width="20" height="20" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    Top Aging Receivables
                </h3>

                <div class="overflow-x-auto rounded-lg border border-gray-800">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-950 text-gray-400 uppercase tracking-wider border-b border-gray-800">
                                <th class="p-3">Invoice</th>
                                <th class="p-3">Tenant</th>
                                <th class="p-3">Unit</th>
                                <th class="p-3">Due Date</th>
                                <th class="p-3 text-right">Balance</th>
                                <th class="p-3 text-center">Overdue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/50">
                            @forelse($agingDetails as $detail)
                                <tr class="hover:bg-gray-800/30 transition-colors">
                                    <td class="p-3 font-semibold text-white">{{ $detail['invoice_number'] }}</td>
                                    <td class="p-3 text-gray-300 font-medium">{{ $detail['tenant_name'] }}</td>
                                    <td class="p-3 text-gray-400">{{ $detail['unit'] }}</td>
                                    <td class="p-3 text-gray-400">{{ $detail['due_date'] }}</td>
                                    <td class="p-3 text-right font-bold text-rose-400">
                                        ₱{{ number_format($detail['amount'], 2) }}</td>
                                    <td class="p-3 text-center">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wide {{ $detail['days_overdue'] > 30 ? 'bg-red-500/10 text-red-400 border border-red-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20' }}">
                                            {{ number_format($detail['days_overdue']) }} days
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-500 font-medium">No aging receivables
                                        found. Great collection health!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 3. Unit-Level Profit & Loss Performance Table -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-sm overflow-hidden">
            <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0 text-indigo-400" width="20" height="20" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                Unit-Level Profitability Performance (YTD Ledger)
            </h3>

            <div class="overflow-x-auto rounded-lg border border-gray-800">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-gray-950 text-gray-400 uppercase tracking-wider border-b border-gray-800">
                            <th class="p-3">Property</th>
                            <th class="p-3 text-center">Unit</th>
                            <th class="p-3">Type</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-right text-emerald-400">Total Rent (Income)</th>
                            <th class="p-3 text-right text-rose-400">Total Expenses</th>
                            <th class="p-3 text-right text-indigo-400">Owner Payouts</th>
                            <th class="p-3 text-right">Net Operating Income</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        @forelse($unitsPerformance as $perf)
                            <tr class="hover:bg-gray-800/30 transition-colors">
                                <td class="p-3 font-semibold text-white">{{ $perf['property'] }}</td>
                                <td class="p-3 text-center font-bold text-gray-300">{{ $perf['unit_number'] }}</td>
                                <td class="p-3 text-gray-400 font-medium">{{ $perf['ownership_type'] }}</td>
                                <td class="p-3">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold tracking-wide border {{ $perf['status'] === 'Occupied' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : ($perf['status'] === 'Vacant' ? 'bg-gray-500/10 text-gray-400 border-gray-500/20' : 'bg-amber-500/10 text-amber-400 border-amber-500/20') }}">
                                        {{ $perf['status'] }}
                                    </span>
                                </td>
                                <td class="p-3 text-right font-bold text-emerald-400">
                                    ₱{{ number_format($perf['income'], 2) }}</td>
                                <td class="p-3 text-right font-bold text-rose-400">
                                    ₱{{ number_format($perf['expenses'], 2) }}</td>
                                <td class="p-3 text-right font-semibold text-indigo-400">
                                    ₱{{ number_format($perf['payouts'], 2) }}</td>
                                <td
                                    class="p-3 text-right font-black {{ $perf['net'] >= 0 ? 'text-emerald-400' : 'text-rose-500 bg-rose-500/5' }}">
                                    ₱{{ number_format($perf['net'], 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-6 text-center text-gray-500 font-medium">No property performance
                                    details found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>