<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Apex Estate Suite - Property Management Platform</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col font-sans selection:bg-indigo-500 selection:text-white antialiased overflow-x-hidden">
        <!-- Ambient background glow -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-[40%] -left-[20%] w-[80%] h-[80%] rounded-full bg-gradient-to-br from-indigo-500/10 to-transparent blur-3xl"></div>
            <div class="absolute -bottom-[40%] -right-[20%] w-[80%] h-[80%] rounded-full bg-gradient-to-br from-emerald-500/10 to-transparent blur-3xl"></div>
        </div>

        <div class="relative z-10 flex-1 flex flex-col max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <!-- Header -->
            <header class="flex items-center justify-between border-b border-slate-800 pb-6 mb-12">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-emerald-500 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-xl tracking-tight bg-gradient-to-r from-indigo-400 to-emerald-400 bg-clip-text text-transparent">Apex Estate Suite</span>
                        <span class="block text-xs text-slate-400 font-medium">Enterprise Property Management</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">v2.0</span>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 flex flex-col justify-center my-auto">
                <!-- Hero Section -->
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                        The Modern Standard for <br class="hidden sm:inline">
                        <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-emerald-400 bg-clip-text text-transparent">Real Estate Operations</span>
                    </h1>
                    <p class="text-lg md:text-xl text-slate-300 leading-relaxed">
                        An integrated ecosystem connecting property administrators, managers, accountants, owners, and tenants. Streamline lease workflows, track financial transactions, manage maintenance tickets, and coordinate remittances in one powerful suite.
                    </p>
                </div>

                <!-- Portal Cards -->
                <div class="grid md:grid-cols-2 gap-8 lg:gap-12 max-w-5xl mx-auto w-full">
                    <!-- Admin Panel Card -->
                    <div class="group relative bg-slate-900/60 backdrop-blur-xl rounded-2xl border border-slate-800 hover:border-indigo-500/50 p-6 md:p-8 transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-500/10 flex flex-col justify-between">
                        <!-- Card Border Highlight -->
                        <div class="absolute -inset-px rounded-2xl bg-gradient-to-br from-indigo-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

                        <div class="relative z-10">
                            <!-- Icon / Badge -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="w-12 h-12 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400 group-hover:bg-indigo-500/20 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-300 border border-indigo-500/20 uppercase tracking-wider">Internal Operations</span>
                            </div>

                            <h2 class="text-2xl font-bold mb-2 text-white">Apex Estate Operations</h2>
                            <p class="text-slate-400 text-sm mb-6">Full suite property management for admins, property managers, agents, and accountants.</p>

                            <!-- Features List -->
                            <ul class="space-y-3 mb-8 text-sm text-slate-300">
                                <li class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Interactive Properties & Units Directory</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Lease & Security Deposit Management</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Automated Invoicing & Remittances</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>KYC Status Audits & Lease Approvals</span>
                                </li>
                            </ul>
                        </div>

                        <div class="relative z-10 mt-auto">
                            <!-- Action Button -->
                            <a href="/admin" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white font-semibold rounded-xl transition-all duration-200 transform group-hover:scale-[1.02] shadow-lg shadow-indigo-600/30">
                                <span>Launch Admin Panel</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>

                            <!-- Developer Accounts -->
                            <div class="mt-6 border-t border-slate-800/80 pt-4">
                                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Review Accounts (Password: password)</span>
                                <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-300">
                                    <div class="bg-slate-950/60 p-2 rounded-lg border border-slate-800">
                                        <span class="block font-semibold text-indigo-400">Super Admin</span>
                                        <code class="select-all block truncate">admin@realestate.test</code>
                                    </div>
                                    <div class="bg-slate-950/60 p-2 rounded-lg border border-slate-800">
                                        <span class="block font-semibold text-indigo-400">Property Manager</span>
                                        <code class="select-all block truncate">manager@realestate.test</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Client Panel Card -->
                    <div class="group relative bg-slate-900/60 backdrop-blur-xl rounded-2xl border border-slate-800 hover:border-emerald-500/50 p-6 md:p-8 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10 flex flex-col justify-between">
                        <!-- Card Border Highlight -->
                        <div class="absolute -inset-px rounded-2xl bg-gradient-to-br from-emerald-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

                        <div class="relative z-10">
                            <!-- Icon / Badge -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="w-12 h-12 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500/20 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 uppercase tracking-wider">Client Access</span>
                            </div>

                            <h2 class="text-2xl font-bold mb-2 text-white">Apex Client Portal</h2>
                            <p class="text-slate-400 text-sm mb-6">Self-service dashboard portal designed specifically for property tenants and owners.</p>

                            <!-- Features List -->
                            <ul class="space-y-3 mb-8 text-sm text-slate-300">
                                <li class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Billing History & Tenant Invoice Payments</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Remittance Summaries & Reports for Owners</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Create & Track Maintenance Request Tickets</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span>Digital Lease Agreement Repository</span>
                                </li>
                            </ul>
                        </div>

                        <div class="relative z-10 mt-auto">
                            <!-- Action Button -->
                            <a href="/portal" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 text-white font-semibold rounded-xl transition-all duration-200 transform group-hover:scale-[1.02] shadow-lg shadow-emerald-600/30">
                                <span>Launch Client Portal</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>

                            <!-- Developer Accounts -->
                            <div class="mt-6 border-t border-slate-800/80 pt-4">
                                <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Review Accounts (Password: password)</span>
                                <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-300">
                                    <div class="bg-slate-950/60 p-2 rounded-lg border border-slate-800">
                                        <span class="block font-semibold text-emerald-400">Owner (Enrique)</span>
                                        <code class="select-all block truncate">owner1@realestate.test</code>
                                    </div>
                                    <div class="bg-slate-950/60 p-2 rounded-lg border border-slate-800">
                                        <span class="block font-semibold text-emerald-400">Tenant (Juan)</span>
                                        <code class="select-all block truncate">tenant1@realestate.test</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="mt-16 pt-8 border-t border-slate-800 text-center text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} Apex Estate Suite. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <span>PHP v{{ PHP_VERSION }}</span>
                    <span>&bull;</span>
                    <span>Laravel v{{ app()->version() }}</span>
                </div>
            </footer>
        </div>
    </body>
</html>
