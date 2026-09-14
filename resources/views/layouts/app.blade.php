<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pegawai App') }} - @yield('title', 'Employee Management')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
    </style>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full antialiased text-slate-800 bg-[#F8FAFC] overflow-x-hidden"
      x-data="{ 
          sidebarOpen: false, 
          sidebarCollapsed: localStorage.getItem('sidebar_collapsed') === 'true',
          toggleSidebar() {
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('sidebar_collapsed', this.sidebarCollapsed);
          }
      }">

    <!-- ========================================== -->
    <!-- MOBILE OFF-CANVAS BACKDROP                -->
    <!-- ========================================== -->
    <div x-show="sidebarOpen" 
         x-cloak
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden"
         @click="sidebarOpen = false"
         @keydown.escape.window="sidebarOpen = false"></div>

    <!-- ========================================== -->
    <!-- FIXED DESKTOP & MOBILE SIDEBAR NAVIGATION   -->
    <!-- ========================================== -->
    <aside :class="{
               'translate-x-0': sidebarOpen,
               '-translate-x-full lg:translate-x-0': !sidebarOpen,
               'lg:w-68': !sidebarCollapsed,
               'lg:w-20': sidebarCollapsed
           }"
           class="fixed inset-y-0 left-0 z-50 bg-[#0B132B] text-slate-200 border-r border-slate-800/80 transition-all duration-300 ease-in-out flex flex-col justify-between shadow-2xl lg:shadow-none w-72 h-screen overflow-y-auto overflow-x-hidden">
        
        <div>
            <!-- Brand Header -->
            <div class="h-20 flex items-center justify-between px-4 border-b border-slate-800/70 bg-[#080E21]/70 transition-all duration-300">
                
                <!-- Logo and Name -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group overflow-hidden">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-teal-500/20 group-hover:scale-105 transition-transform shrink-0">
                        <svg class="w-6 h-6 text-slate-950 stroke-[2.2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div x-show="!sidebarCollapsed" x-transition class="overflow-hidden whitespace-nowrap">
                        <span class="text-base font-bold tracking-tight text-white flex items-center gap-1">
                            Pegawai<span class="text-teal-400 font-extrabold">Hub</span>
                        </span>
                        <span class="text-[10px] font-semibold tracking-wider uppercase text-teal-300/70 block">Enterprise Portal</span>
                    </div>
                </a>

                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false" 
                        aria-label="Close Mobile Navigation"
                        class="lg:hidden p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Desktop Collapse Button inside Header (Visible when Expanded) -->
                <button @click="toggleSidebar()" 
                        x-show="!sidebarCollapsed"
                        aria-label="Collapse Sidebar"
                        title="Collapse Sidebar"
                        class="hidden lg:flex p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/80 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <!-- Expand button inside collapsed sidebar -->
            <div x-show="sidebarCollapsed" class="hidden lg:flex justify-center py-2 border-b border-slate-800/40">
                <button @click="toggleSidebar()" 
                        aria-label="Expand Sidebar"
                        title="Expand Sidebar"
                        class="p-2 rounded-xl text-slate-400 hover:text-teal-300 hover:bg-slate-800/80 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="px-3 py-5 space-y-1.5">
                <p x-show="!sidebarCollapsed" class="px-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase mb-2">Navigation</p>
                
                <!-- 1. Dashboard -->
                <a href="{{ route('dashboard') }}"
                   title="Dashboard & Analytics"
                   :class="{ 'justify-center': sidebarCollapsed }"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-teal-500/15 text-teal-300 border border-teal-500/30 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-teal-400' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Dashboard</span>
                    <span x-show="!sidebarCollapsed" class="ml-auto text-[10px] font-semibold px-2 py-0.5 rounded-full {{ request()->routeIs('dashboard') ? 'bg-teal-400/20 text-teal-300' : 'bg-slate-800 text-slate-400' }}">
                        D3
                    </span>
                </a>

                <!-- 2. Employees Directory -->
                <a href="{{ route('employees.index') }}"
                   title="Employees Directory"
                   :class="{ 'justify-center': sidebarCollapsed }"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('employees.*') && !request()->routeIs('employees.create') ? 'bg-teal-500/15 text-teal-300 border border-teal-500/30 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                    <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employees.*') && !request()->routeIs('employees.create') ? 'text-teal-400' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Employees</span>
                    <span x-show="!sidebarCollapsed" class="ml-auto text-[10px] font-semibold px-2 py-0.5 rounded-full {{ request()->routeIs('employees.*') ? 'bg-teal-400/20 text-teal-300' : 'bg-slate-800 text-slate-400' }}">
                        CRUD
                    </span>
                </a>

                {{-- 3. Add Employee (Admin Only) --}}
                @if(auth()->user()?->isAdmin())
                    <a href="{{ route('employees.create') }}"
                       title="Add New Employee"
                       :class="{ 'justify-center': sidebarCollapsed }"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('employees.create') ? 'bg-teal-500/15 text-teal-300 border border-teal-500/30 shadow-xs' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employees.create') ? 'text-teal-400' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span x-show="!sidebarCollapsed" class="truncate">Add Employee</span>
                        <span x-show="!sidebarCollapsed" class="ml-auto text-[9px] uppercase font-bold tracking-wider px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 border border-amber-500/30">
                            Admin
                        </span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Sidebar Footer / User Profile & Logout -->
        <div class="p-3 border-t border-slate-800/80 bg-[#080E21]/60">
            @auth
                <!-- Expanded Profile Card -->
                <div x-show="!sidebarCollapsed" class="flex items-center gap-2.5 px-2 py-2 mb-2">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shadow-xs shrink-0 {{ auth()->user()->isAdmin() ? 'bg-teal-500/20 text-teal-300 border border-teal-400/30' : 'bg-slate-800 text-slate-300 border border-slate-700' }}">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-slate-200 truncate">{{ auth()->user()->name }}</p>
                        <span class="inline-flex items-center px-1.5 py-0.2 text-[9px] font-bold uppercase tracking-wider rounded-md {{ auth()->user()->isAdmin() ? 'bg-teal-400/20 text-teal-300' : 'bg-slate-800 text-slate-400' }}">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>

                <!-- Collapsed Profile Initials Badge -->
                <div x-show="sidebarCollapsed" class="flex justify-center mb-2" title="{{ auth()->user()->name }} ({{ auth()->user()->role }})">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shadow-xs {{ auth()->user()->isAdmin() ? 'bg-teal-500/20 text-teal-300 border border-teal-400/30' : 'bg-slate-800 text-slate-300 border border-slate-700' }}">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                </div>

                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            title="Sign Out"
                            class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold text-rose-400 hover:text-rose-300 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 transition-all">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span x-show="!sidebarCollapsed">Sign Out</span>
                    </button>
                </form>
            @endauth
        </div>
    </aside>

    <!-- ========================================== -->
    <!-- MAIN INDEPENDENTLY SCROLLABLE CONTENT AREA  -->
    <!-- ========================================== -->
    <div :class="{
             'lg:pl-68': !sidebarCollapsed,
             'lg:pl-20': sidebarCollapsed
         }"
         class="min-h-screen flex flex-col justify-between transition-all duration-300 ease-in-out">
        
        <!-- Sticky Top Header -->
        <header class="h-20 bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-8 shadow-xs">
            <div class="flex items-center gap-3 sm:gap-4">
                
                <!-- Mobile Hamburger Button -->
                <button @click="sidebarOpen = true" 
                        aria-label="Open Mobile Navigation"
                        class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:outline-hidden transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Desktop Quick Toggle Button in Header -->
                <button @click="toggleSidebar()" 
                        aria-label="Toggle Sidebar Expansion"
                        title="Toggle Sidebar"
                        class="hidden lg:flex p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h10M4 18h16" />
                    </svg>
                </button>

                <div>
                    <h1 class="text-base sm:text-xl font-bold text-slate-900 tracking-tight">@yield('header-title', 'Employee Management')</h1>
                    <p class="text-xs text-slate-500 hidden sm:block">@yield('header-subtitle', 'University Course Project Demo')</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <!-- User Role Indicator Pill -->
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full {{ auth()->user()->isAdmin() ? 'bg-teal-50 border border-teal-200/80 text-teal-800' : 'bg-slate-100 border border-slate-200 text-slate-700' }} text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full {{ auth()->user()->isAdmin() ? 'bg-teal-500' : 'bg-slate-400' }}"></span>
                        <span>{{ ucfirst(auth()->user()->role) }}: {{ auth()->user()->name }}</span>
                    </div>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('employees.create') }}" 
                           class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-xl bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white text-xs sm:text-sm font-semibold shadow-sm shadow-teal-600/20 hover:shadow-md transition-all duration-200">
                            <svg class="w-4 h-4 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span class="hidden sm:inline">New Employee</span>
                            <span class="sm:hidden">Add</span>
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                title="Sign Out"
                                aria-label="Sign Out"
                                class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-all">
                        Sign In
                    </a>
                @endauth
            </div>
        </header>

        <!-- Main Body Container (Scrolls independently) -->
        <main class="flex-1 p-4 sm:p-8 max-w-7xl w-full mx-auto">
            
            <!-- Flash Notification: Success -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition 
                     class="mb-6 rounded-2xl bg-emerald-50/90 border border-emerald-200/80 p-4 text-emerald-800 shadow-xs flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-emerald-900">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Flash Notification: Error -->
            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition 
                     class="mb-6 rounded-2xl bg-rose-50/90 border border-rose-200/80 p-4 text-rose-800 shadow-xs flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-rose-900">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Content Slot -->
            @yield('content')

        </main>

        <!-- App Footer -->
        <footer class="py-6 px-8 text-center text-xs text-slate-400 border-t border-slate-200/60 bg-white/50">
            &copy; {{ date('Y') }} PegawaiApp — Academic Demonstration System. Built with Laravel 12, Tailwind CSS & D3.js.
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
