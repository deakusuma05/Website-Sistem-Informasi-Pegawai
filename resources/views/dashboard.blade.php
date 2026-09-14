@extends('layouts.app')

@section('title', 'Analytics Dashboard')
@section('header-title', 'Workforce Analytics Dashboard')
@section('header-subtitle', 'Real-time database metrics, demographics, and tenure visualization')

@section('content')
<div class="space-y-8">

    <!-- Top Greeting Banner with Isometric 3D Visual Accent -->
    <div class="p-6 sm:p-7 rounded-3xl bg-gradient-to-r from-[#0B132B] via-[#1C2541] to-[#0B132B] text-white shadow-xs relative overflow-hidden border border-slate-800/80">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-xl">
                <div class="flex items-center gap-2.5 mb-1.5">
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider {{ auth()->user()->isAdmin() ? 'bg-teal-400/20 text-teal-300 border border-teal-400/30' : 'bg-slate-700 text-slate-300' }}">
                        {{ auth()->user()->role }} Mode
                    </span>
                    <span class="text-xs text-slate-400">&bull; Live Database Synchronization</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white">
                    Welcome back, {{ auth()->user()->name }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 leading-relaxed">
                    Enterprise workforce intelligence powered by Laravel 12 & D3.js. High-precision 2D statistical visualization with real-time MySQL synchronization.
                </p>

                <div class="flex items-center gap-3 mt-4">
                    <a href="{{ route('employees.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-semibold border border-white/20 backdrop-blur-xs transition-all">
                        <svg class="w-4 h-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        <span>View Directory</span>
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('employees.create') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-slate-950 font-bold text-xs sm:text-sm shadow-lg shadow-teal-500/20 transition-all">
                            <svg class="w-4 h-4 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Add Employee</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Isometric 3D Analytics Storytelling Accent -->
            <div class="hidden md:flex items-center justify-center shrink-0">
                <div class="relative p-2 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs shadow-inner">
                    <svg class="w-32 h-28" viewBox="0 0 160 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Isometric Grid Base Platform -->
                        <path d="M80 130L145 92.5L80 55L15 92.5L80 130Z" fill="#080E21" fill-opacity="0.7"/>
                        <path d="M80 130L145 92.5V85L80 122.5V130Z" fill="#0D9488" fill-opacity="0.4"/>
                        <path d="M80 130L15 92.5V85L80 122.5V130Z" fill="#06B6D4" fill-opacity="0.3"/>
                        
                        <!-- Isometric Column 1 (Left Teal Block) -->
                        <g transform="translate(38, 52)">
                            <path d="M18 0L36 10.4L18 20.8L0 10.4L18 0Z" fill="#14B8A6"/>
                            <path d="M0 10.4L18 20.8V42L0 31.6V10.4Z" fill="#0F766E"/>
                            <path d="M18 20.8L36 10.4V31.6L18 42V20.8Z" fill="#0D9488"/>
                        </g>

                        <!-- Isometric Column 2 (Center Sky Pillar - Tallest) -->
                        <g transform="translate(62, 22)">
                            <path d="M18 0L36 10.4L18 20.8L0 10.4L18 0Z" fill="#38BDF8"/>
                            <path d="M0 10.4L18 20.8V68L0 57.6V10.4Z" fill="#0369A1"/>
                            <path d="M18 20.8L36 10.4V57.6L18 68V20.8Z" fill="#0284C7"/>
                        </g>

                        <!-- Isometric Column 3 (Right Cyan Block) -->
                        <g transform="translate(88, 44)">
                            <path d="M18 0L36 10.4L18 20.8L0 10.4L18 0Z" fill="#2DD4BF"/>
                            <path d="M0 10.4L18 20.8V48L0 37.6V10.4Z" fill="#115E59"/>
                            <path d="M18 20.8L36 10.4V37.6L18 48V20.8Z" fill="#0D9488"/>
                        </g>

                        <!-- Glowing Hologram Floating Particle Badges -->
                        <circle cx="80" cy="18" r="3" fill="#38BDF8"/>
                        <circle cx="56" cy="46" r="2.5" fill="#2DD4BF"/>
                        <circle cx="106" cy="40" r="2.5" fill="#5EEAD4"/>
                    </svg>
                    <span class="absolute bottom-1 right-2 text-[9px] font-mono text-teal-300/80 uppercase tracking-widest">D3 Live</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Top KPI Cards (Clean 2D with Soft Neumorphic Elevation) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- KPI 1: Total Employees -->
        <div class="soft-card soft-card-hover p-6 rounded-2xl relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Employees</p>
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1.5 tracking-tight">{{ $kpi['totalEmployees'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 border border-teal-100 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 stroke-[1.8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-500">
                <span class="inline-flex items-center gap-1 text-teal-700 font-semibold px-2 py-0.5 rounded-md bg-teal-50 border border-teal-100/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span> Synchronized
                </span>
                <span>in MySQL</span>
            </div>
        </div>

        <!-- KPI 2: Male Employees -->
        <div class="soft-card soft-card-hover p-6 rounded-2xl relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Male Employees</p>
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1.5 tracking-tight">{{ $kpi['maleEmployees'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 stroke-[1.8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2 text-xs text-slate-500">
                <span class="px-2 py-0.5 rounded-md font-bold bg-sky-100 text-sky-700 text-[11px]">
                    {{ $kpi['malePercentage'] }}%
                </span>
                <span>of total staff</span>
            </div>
        </div>

        <!-- KPI 3: Female Employees -->
        <div class="soft-card soft-card-hover p-6 rounded-2xl relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Female Employees</p>
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1.5 tracking-tight">{{ $kpi['femaleEmployees'] }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 stroke-[1.8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2 text-xs text-slate-500">
                <span class="px-2 py-0.5 rounded-md font-bold bg-rose-100 text-rose-700 text-[11px]">
                    {{ $kpi['femalePercentage'] }}%
                </span>
                <span>of total staff</span>
            </div>
        </div>

        <!-- KPI 4: Average Age -->
        <div class="soft-card soft-card-hover p-6 rounded-2xl relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Average Age</p>
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-1.5 tracking-tight">
                        {{ $kpi['averageAge'] }} <span class="text-base font-normal text-slate-400">yrs</span>
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 stroke-[1.8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2 text-xs text-slate-500">
                <span class="px-2 py-0.5 rounded-md font-bold bg-indigo-100 text-indigo-700 text-[11px]">
                    Avg Tenure: {{ $kpi['averageTenure'] }} yrs
                </span>
            </div>
        </div>

    </div>

    @if($kpi['totalEmployees'] === 0)
        <!-- Empty State with Isometric 3D Vault Illustration -->
        <div class="soft-card p-12 sm:p-16 rounded-3xl text-center">
            <div class="flex justify-center mb-5">
                <svg class="w-32 h-28" viewBox="0 0 160 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Isometric Pedestal Base -->
                    <path d="M80 120L135 88L80 56L25 88L80 120Z" fill="#E2E8F0"/>
                    <path d="M80 120L135 88V96L80 128V120Z" fill="#CBD5E1"/>
                    <path d="M80 120L25 88V96L80 128V120Z" fill="#94A3B8"/>
                    <!-- Empty Hologram Grid Ring -->
                    <ellipse cx="80" cy="86" rx="42" ry="22" stroke="#0D9488" stroke-width="2" stroke-dasharray="4 4" fill="#F0FDFA" fill-opacity="0.5"/>
                    <!-- Holographic Floating Empty Data Vault -->
                    <g transform="translate(56, 32)">
                        <path d="M24 0L48 13.8L24 27.6L0 13.8L24 0Z" fill="#CCFBF1" stroke="#0D9488" stroke-width="1.5"/>
                        <path d="M0 13.8L24 27.6V48L0 34.2V13.8Z" fill="#99F6E4" stroke="#0D9488" stroke-width="1.5"/>
                        <path d="M24 27.6L48 13.8V34.2L24 48V27.6Z" fill="#5EEAD4" stroke="#0D9488" stroke-width="1.5"/>
                        <!-- Inner Empty Slot -->
                        <path d="M24 8L38 16L24 24L10 16L24 8Z" fill="#0D9488" fill-opacity="0.3"/>
                    </g>
                    <!-- Floating subtle particles -->
                    <circle cx="48" cy="40" r="2" fill="#0D9488"/>
                    <circle cx="112" cy="48" r="2.5" fill="#06B6D4"/>
                    <circle cx="80" cy="24" r="1.5" fill="#14B8A6"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 tracking-tight">No Employee Data Available</h3>
            <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mt-1 mb-6">
                The database currently contains zero employee records. Add new employees to dynamically populate the real-time KPI metrics and D3.js visualization charts.
            </p>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('employees.create') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs sm:text-sm font-semibold shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add First Employee</span>
                </a>
            @else
                <p class="text-xs font-medium text-slate-400">Please sign in as an Administrator to register new employee records.</p>
            @endif
        </div>

    @else
        <!-- D3.JS 2D Data Visualization Grid (2x2 Balanced Grid - Readability First) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Chart 1: Gender Distribution (2D D3 Doughnut) -->
            <div class="soft-card p-6 rounded-2xl flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-cyan-500"></span>
                            <h3 class="text-sm font-bold text-slate-800 tracking-tight uppercase">Gender Distribution</h3>
                        </div>
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">
                            D3 Doughnut
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Comparison of male and female employee composition.</p>
                </div>

                <!-- 2D SVG Container -->
                <div id="chart-gender-distribution" class="my-4 min-h-[240px] flex items-center justify-center"></div>

                <!-- Interactive Legend -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-center gap-6 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#0284C7]"></span>
                        <span class="text-slate-600 font-medium">Laki-laki ({{ $kpi['maleEmployees'] }})</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#E11D48]"></span>
                        <span class="text-slate-600 font-medium">Perempuan ({{ $kpi['femaleEmployees'] }})</span>
                    </div>
                </div>
            </div>

            <!-- Chart 2: Education Distribution (2D D3 Bar Chart) -->
            <div class="soft-card p-6 rounded-2xl flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                            <h3 class="text-sm font-bold text-slate-800 tracking-tight uppercase">Education Distribution</h3>
                        </div>
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">
                            D3 Bar Chart
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Highest level of educational attainment across all staff.</p>
                </div>

                <!-- 2D SVG Container -->
                <div id="chart-education-distribution" class="my-4 min-h-[240px] flex items-center justify-center"></div>

                <!-- Legend / Notes -->
                <div class="pt-3 border-t border-slate-100 text-center text-xs text-slate-400">
                    Levels: SMA/SMK &bull; D3 &bull; S1 &bull; S2 &bull; S3
                </div>
            </div>

            <!-- Chart 3: Age Distribution (2D D3 Histogram) -->
            <div class="soft-card p-6 rounded-2xl flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                            <h3 class="text-sm font-bold text-slate-800 tracking-tight uppercase">Age Demographics</h3>
                        </div>
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">
                            D3 Histogram
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Employee age bracket segmentation (18–25 up to 56+ years).</p>
                </div>

                <!-- 2D SVG Container -->
                <div id="chart-age-distribution" class="my-4 min-h-[240px] flex items-center justify-center"></div>

                <div class="pt-3 border-t border-slate-100 text-center text-xs text-slate-400">
                    Average Workforce Age: <strong class="text-slate-700 font-bold">{{ $kpi['averageAge'] }} years</strong>
                </div>
            </div>

            <!-- Chart 4: Work Duration Distribution (2D D3 Bar Chart) -->
            <div class="soft-card p-6 rounded-2xl flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <h3 class="text-sm font-bold text-slate-800 tracking-tight uppercase">Work Duration (Tenure)</h3>
                        </div>
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">
                            D3 Bar Chart
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Years of service and experience brackets across the enterprise.</p>
                </div>

                <!-- 2D SVG Container -->
                <div id="chart-work-duration-distribution" class="my-4 min-h-[240px] flex items-center justify-center"></div>

                <div class="pt-3 border-t border-slate-100 text-center text-xs text-slate-400">
                    Mean Tenure: <strong class="text-slate-700 font-bold">{{ $kpi['averageTenure'] }} years</strong>
                </div>
            </div>

        </div>

        <!-- Recent Employees Table Preview (Flat, High Readability) -->
        <div class="soft-card p-6 rounded-2xl">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                    <h3 class="text-sm font-bold text-slate-800 tracking-tight uppercase">Recently Added Staff</h3>
                </div>
                <a href="{{ route('employees.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700 hover:underline">
                    View All {{ $kpi['totalEmployees'] }} Employees &rarr;
                </a>
            </div>

            <div class="overflow-x-auto mt-2">
                <table class="w-full text-left text-sm text-slate-600 divide-y divide-slate-100">
                    <thead class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-2">Employee</th>
                            <th class="py-3 px-2">Gender</th>
                            <th class="py-3 px-2">Education</th>
                            <th class="py-3 px-2">Age</th>
                            <th class="py-3 px-2">Experience</th>
                            <th class="py-3 px-2 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentEmployees as $emp)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 px-2 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs shrink-0 {{ $emp->gender === 'Laki-laki' ? 'bg-sky-100 text-sky-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ strtoupper(substr($emp->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800 text-xs sm:text-sm">{{ $emp->name }}</p>
                                            <p class="text-[11px] text-slate-400">{{ $emp->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-2 whitespace-nowrap text-xs">
                                    <span class="px-2 py-0.5 rounded-full {{ $emp->gender === 'Laki-laki' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                        {{ $emp->gender }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 whitespace-nowrap text-xs font-semibold text-slate-700">
                                    {{ $emp->education }}
                                </td>
                                <td class="py-3 px-2 whitespace-nowrap text-xs text-slate-600">
                                    {{ $emp->age }} yrs
                                </td>
                                <td class="py-3 px-2 whitespace-nowrap text-xs text-slate-600">
                                    {{ $emp->work_duration }} yrs
                                </td>
                                <td class="py-3 px-2 whitespace-nowrap text-right text-xs">
                                    <a href="{{ route('employees.show', $emp) }}" class="text-teal-600 hover:text-teal-700 font-semibold">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($charts ?? []);
        
        function renderCharts() {
            if (window.DashboardCharts && typeof window.DashboardCharts.initAllDashboardCharts === 'function') {
                window.DashboardCharts.initAllDashboardCharts(chartData);
            }
        }

        renderCharts();

        // Responsive re-render on resize
        let resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(renderCharts, 250);
        });
    });
</script>
@endpush
