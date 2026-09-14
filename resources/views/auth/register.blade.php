<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-full bg-[#0B132B]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Create Account - Employee Management & Analytics</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased text-slate-800 bg-[#0B132B] flex flex-col justify-center py-6 sm:py-10 px-4 sm:px-6 lg:px-8 relative overflow-y-auto overflow-x-hidden">

    <!-- Background Glow Accents -->
    <div class="absolute top-1/4 -left-48 w-96 h-96 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 -right-48 w-96 h-96 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="my-auto w-full max-w-5xl mx-auto relative z-10 my-4 sm:my-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 rounded-3xl overflow-hidden shadow-2xl border border-slate-800/80 bg-[#080E21]">
            
            <!-- Left Branding & Isometric Visual Showcase (Desktop/Laptop lg+) -->
            <div class="hidden lg:flex lg:col-span-5 p-6 sm:p-8 lg:p-10 flex-col justify-between bg-gradient-to-br from-[#0B132B] to-[#1C2541] border-r border-slate-800/80 text-white relative">
                <div>
                    <!-- Logo & Brand Header -->
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-teal-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-teal-500/20 shrink-0">
                            <svg class="w-6 h-6 text-slate-950 stroke-[2.2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-bold tracking-tight text-white flex items-center gap-1">
                                Pegawai<span class="text-teal-400 font-extrabold">Hub</span>
                            </span>
                            <span class="text-[10px] font-semibold tracking-wider uppercase text-teal-300/70 block">Enterprise Portal</span>
                        </div>
                    </div>

                    <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white mt-3 leading-tight">
                        Employee Management & Analytics
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 mt-2.5 leading-relaxed">
                        Sistem Informasi Manajemen Data Kepegawaian berbasis Laravel dengan role-based authorization, validasi data, CRUD, dan visualisasi statistik.
                    </p>

                    <!-- Developer Identity -->
                    <div class="mt-5 p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-teal-300">Developed by</p>
                        <p class="text-base font-extrabold text-white tracking-tight mt-0.5">Dea Kusuma Ningrum</p>
                        <p class="text-xs font-mono font-medium text-cyan-300/90 mt-0.5 tracking-wide">23082010048</p>
                    </div>

                    <!-- Role Specs Info -->
                    <div class="mt-5 space-y-2.5 text-xs">
                        <div class="p-3 rounded-xl bg-teal-500/10 border border-teal-500/20">
                            <div class="font-bold text-teal-300 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                                <span>Administrator Role</span>
                            </div>
                            <p class="text-[11px] text-slate-300 mt-0.5">Full access to create, edit, update, delete employees, and inspect analytics.</p>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700/80">
                            <div class="font-bold text-slate-200 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                <span>Standard User Role</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Authorized to explore the analytics dashboard and search the staff directory.</p>
                        </div>
                    </div>
                </div>

                <!-- Isometric 3D Onboarding Graphic -->
                <div class="my-6 flex justify-center">
                    <svg class="w-44 h-36 max-h-36 w-auto" viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Isometric Base -->
                        <path d="M100 150L180 105L100 60L20 105L100 150Z" fill="#060C1E" fill-opacity="0.8"/>
                        <path d="M100 150L180 105V113L100 158V150Z" fill="#0D9488" fill-opacity="0.3"/>
                        <path d="M100 150L20 105V113L100 158V150Z" fill="#06B6D4" fill-opacity="0.2"/>

                        <!-- User Avatar Node (Isometric Center) -->
                        <g transform="translate(75, 40)">
                            <path d="M25 0L50 14.4L25 28.8L0 14.4L25 0Z" fill="#2DD4BF"/>
                            <path d="M0 14.4L25 28.8V60L0 45.6V14.4Z" fill="#0F766E"/>
                            <path d="M25 28.8L50 14.4V45.6L25 60V28.8Z" fill="#0D9488"/>

                            <!-- User Symbol on top face -->
                            <circle cx="25" cy="12" r="4" fill="#080E21"/>
                            <path d="M18 20C18 16 32 16 32 20" stroke="#080E21" stroke-width="2"/>
                        </g>

                        <!-- Keycard / Badge Floating Element -->
                        <g transform="translate(130, 70)">
                            <polygon points="12,0 24,7 24,19 12,26 0,19 0,7" fill="#38BDF8" stroke="#0284C7" stroke-width="1.5"/>
                            <circle cx="12" cy="13" r="3" fill="#FFFFFF"/>
                        </g>
                    </svg>
                </div>

                <div class="text-xs font-mono text-slate-400 border-t border-slate-800/80 pt-4 mt-6 flex items-center justify-between">
                    <span>Employee Management & Analytics</span>
                    <span class="text-teal-400 font-bold">2026</span>
                </div>
            </div>

            <!-- Right Registration Form (Clean, Soft Neumorphic) -->
            <div class="lg:col-span-7 bg-white p-6 sm:p-8 lg:p-10 flex flex-col justify-center">
                
                <div class="mb-5">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Register Account</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Select a role and enter your details to get started</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('register.attempt') }}" method="POST" class="space-y-3.5">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Full Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               required 
                               autocomplete="name"
                               placeholder="e.g. Jane Doe" 
                               class="soft-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden">
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Email Address <span class="text-rose-500">*</span>
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

                    <!-- Role Selection -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Account Role <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer border rounded-xl p-3 flex flex-col items-center justify-center text-center transition-all bg-slate-50 hover:bg-slate-100 border-slate-200 has-checked:border-teal-500 has-checked:bg-teal-50/50 has-checked:ring-2 has-checked:ring-teal-500/20">
                                <input type="radio" name="role" value="admin" class="sr-only" {{ old('role') === 'admin' ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-slate-900 block">Administrator</span>
                                <span class="text-[10px] text-slate-500 mt-0.5">Full CRUD Privileges</span>
                            </label>
                            <label class="cursor-pointer border rounded-xl p-3 flex flex-col items-center justify-center text-center transition-all bg-slate-50 hover:bg-slate-100 border-slate-200 has-checked:border-teal-500 has-checked:bg-teal-50/50 has-checked:ring-2 has-checked:ring-teal-500/20">
                                <input type="radio" name="role" value="user" class="sr-only" {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                                <span class="text-xs font-bold text-slate-900 block">Standard User</span>
                                <span class="text-[10px] text-slate-500 mt-0.5">Dashboard & Directory Only</span>
                            </label>
                        </div>
                    </div>

                    <!-- Password Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Password <span class="text-rose-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Min. 8 chars" 
                                   class="soft-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Confirm <span class="text-rose-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Re-type password" 
                                   class="soft-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit" 
                                class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white text-sm font-semibold shadow-md shadow-teal-600/20 hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span>Complete Registration</span>
                        </button>
                    </div>
                </form>

                <!-- Footer: Link to Login -->
                <div class="mt-6 text-center text-xs text-slate-500">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-bold text-teal-600 hover:text-teal-700 hover:underline">
                        Sign in here
                    </a>
                </div>

            </div>
        </div>

    </div>

</body>
</html>
