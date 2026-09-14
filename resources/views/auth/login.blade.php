<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-full bg-[#0B132B]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign In - Employee Management & Analytics</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased text-slate-800 bg-[#0B132B] flex flex-col justify-center py-6 sm:py-10 px-4 sm:px-6 lg:px-8 relative overflow-y-auto overflow-x-hidden"
      x-data="{
          fillCredentials(email, pwd) {
              document.getElementById('email').value = email;
              document.getElementById('password').value = pwd;
          }
      }">

    <!-- Background Glow Accents -->
    <div class="absolute top-1/4 -left-48 w-96 h-96 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 -right-48 w-96 h-96 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="my-auto w-full max-w-5xl mx-auto relative z-10 my-4 sm:my-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 rounded-3xl overflow-hidden shadow-2xl border border-slate-800/80 bg-[#080E21]">
            
            <!-- Left Branding, Developer Identity & Feature Highlights -->
            <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 flex flex-col justify-between bg-gradient-to-br from-[#0B132B] to-[#1C2541] border-b lg:border-b-0 lg:border-r border-slate-800/80 text-white relative">
                <div>
                    <!-- Logo & Brand Header -->
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-teal-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-teal-500/20 shrink-0">
                            <svg class="w-6 h-6 text-slate-950 stroke-[2.2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-bold tracking-tight text-white flex items-center gap-1">
                                Pegawai<span class="text-teal-400 font-extrabold">Hub</span>
                            </span>
                            <span class="text-[10px] font-semibold tracking-wider uppercase text-teal-300/70 block">Enterprise Portal</span>
                        </div>
                    </div>

                    <!-- Main Title -->
                    <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mt-3 leading-tight">
                        Employee Management & Analytics
                    </h1>

                    <!-- Description -->
                    <p class="text-xs sm:text-sm text-slate-300 mt-2.5 leading-relaxed">
                        Sistem Informasi Manajemen Data Kepegawaian berbasis Laravel dengan role-based authorization, validasi data, CRUD, dan visualisasi statistik.
                    </p>

                    <!-- Developer Identity (Clearly indicates developer/creator, prominent name, smaller student ID) -->
                    <div class="mt-6 p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-teal-300">Developed by</p>
                        <p class="text-base sm:text-lg font-extrabold text-white tracking-tight mt-0.5">Dea Kusuma Ningrum</p>
                        <p class="text-xs font-mono font-medium text-cyan-300/90 mt-0.5 tracking-wide">23082010048</p>
                    </div>

                    <!-- Feature Highlights -->
                    <div class="mt-6 space-y-2.5 text-xs text-slate-200">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Feature Highlights</p>
                        <div class="flex items-center gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-teal-400 shrink-0"></span>
                            <span>Employee Data Management</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shrink-0"></span>
                            <span>Role-Based Authorization</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shrink-0"></span>
                            <span>CRUD & Data Validation</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 shrink-0"></span>
                            <span>Interactive D3.js Analytics</span>
                        </div>
                    </div>
                </div>

                <!-- Isometric 3D Enterprise Architecture Accent (Decorative Only) -->
                <div class="my-6 hidden sm:flex justify-center">
                    <svg class="w-44 h-36 max-h-36 w-auto" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Isometric Grid Floor -->
                        <path d="M120 190L220 135L120 80L20 135L120 190Z" fill="#060C1E" fill-opacity="0.8"/>
                        <path d="M120 190L220 135V145L120 200V190Z" fill="#0D9488" fill-opacity="0.3"/>
                        <path d="M120 190L20 135V145L120 200V190Z" fill="#06B6D4" fill-opacity="0.2"/>

                        <!-- Central Isometric Hub -->
                        <g transform="translate(90, 50)">
                            <path d="M30 0L60 17.3L30 34.6L0 17.3L30 0Z" fill="#14B8A6"/>
                            <path d="M0 17.3L30 34.6V75L0 57.7V17.3Z" fill="#0F766E"/>
                            <path d="M30 34.6L60 17.3V57.7L30 75V34.6Z" fill="#0D9488"/>
                            
                            <!-- Server Rack Status Lines -->
                            <line x1="8" y1="36" x2="24" y2="45" stroke="#5EEAD4" stroke-width="2"/>
                            <line x1="8" y1="46" x2="24" y2="55" stroke="#5EEAD4" stroke-width="2"/>
                            <line x1="36" y1="45" x2="52" y2="36" stroke="#38BDF8" stroke-width="2"/>
                            <line x1="36" y1="55" x2="52" y2="46" stroke="#38BDF8" stroke-width="2"/>
                        </g>

                        <!-- Isometric Satellite Node Left -->
                        <g transform="translate(40, 95)">
                            <path d="M20 0L40 11.5L20 23L0 11.5L20 0Z" fill="#38BDF8"/>
                            <path d="M0 11.5L20 23V42L0 30.5V11.5Z" fill="#0369A1"/>
                            <path d="M20 23L40 11.5V30.5L20 42V23Z" fill="#0284C7"/>
                        </g>

                        <!-- Isometric Satellite Node Right -->
                        <g transform="translate(145, 95)">
                            <path d="M20 0L40 11.5L20 23L0 11.5L20 0Z" fill="#2DD4BF"/>
                            <path d="M0 11.5L20 23V42L0 30.5V11.5Z" fill="#115E59"/>
                            <path d="M20 23L40 11.5V30.5L20 42V23Z" fill="#0D9488"/>
                        </g>

                        <!-- Holographic Floating Security Badge -->
                        <g transform="translate(105, 18)">
                            <polygon points="15,0 30,8 30,22 15,30 0,22 0,8" fill="#1E293B" stroke="#2DD4BF" stroke-width="2"/>
                            <path d="M15 6L23 11V18C23 23 15 26 15 26C15 26 7 23 7 18V11L15 6Z" fill="#0D9488"/>
                        </g>

                        <!-- Paths -->
                        <path d="M60 106L90 85" stroke="#38BDF8" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.8"/>
                        <path d="M150 85L165 106" stroke="#2DD4BF" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.8"/>
                    </svg>
                </div>

                <!-- Bottom Text: 2026 -->
                <div class="text-xs font-mono text-slate-400 border-t border-slate-800/80 pt-4 mt-6 flex items-center justify-between">
                    <span>Employee Management & Analytics</span>
                    <span class="text-teal-400 font-bold">2026</span>
                </div>
            </div>

            <!-- Right Authentication Form Panel (Clean, Soft Neumorphic) -->
            <div class="lg:col-span-7 bg-white p-6 sm:p-8 lg:p-10 flex flex-col justify-center">
                
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Welcome Back</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Sign In to Your Account to access the platform</p>
                </div>

                <!-- Flash Status Feedback -->
                @if (session('success'))
                    <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login.attempt') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Email Address
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}"
                               required 
                               autocomplete="email"
                               placeholder="name@example.com" 
                               class="soft-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Password
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="••••••••" 
                               class="soft-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden">
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-teal-600 focus:ring-teal-500 border-slate-300">
                            <span>Remember me on this browser</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white text-sm font-semibold shadow-md shadow-teal-600/20 hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Sign In</span>
                        </button>
                    </div>
                </form>

                <!-- Quick Demo Credentials Selector for Lecturer / Evaluator -->
                <div class="mt-6 pt-5 border-t border-slate-100">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center mb-2.5">
                        Demo Credentials (Click to Auto-fill)
                    </p>
                    <div class="grid grid-cols-2 gap-2.5 text-xs">
                        <button type="button" 
                                @click="fillCredentials('admin@example.com', 'password')"
                                class="p-2.5 rounded-xl bg-teal-50/80 hover:bg-teal-100 text-teal-900 border border-teal-200/80 transition-colors text-left group cursor-pointer">
                            <span class="font-bold block text-teal-800 flex items-center justify-between">
                                <span>Admin Role</span>
                                <span class="text-[10px] bg-teal-200 text-teal-900 px-1.5 py-0.2 rounded font-mono">CRUD</span>
                            </span>
                            <span class="text-[11px] text-teal-600 truncate block mt-0.5">admin@example.com</span>
                        </button>

                        <button type="button" 
                                @click="fillCredentials('user@example.com', 'password')"
                                class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200 transition-colors text-left group cursor-pointer">
                            <span class="font-bold block text-slate-700 flex items-center justify-between">
                                <span>User Role</span>
                                <span class="text-[10px] bg-slate-300 text-slate-800 px-1.5 py-0.2 rounded font-mono">Read</span>
                            </span>
                            <span class="text-[11px] text-slate-500 truncate block mt-0.5">user@example.com</span>
                        </button>
                    </div>
                </div>

                <!-- Footer Link to Register -->
                <div class="mt-6 text-center text-xs text-slate-500">
                    Need a new account? 
                    <a href="{{ route('register') }}" class="font-bold text-teal-600 hover:text-teal-700 hover:underline">
                        Create new account
                    </a>
                </div>

            </div>
        </div>

    </div>

</body>
</html>
