@extends('layouts.app')

@section('title', 'Add New Employee')
@section('header-title', 'Add New Employee')
@section('header-subtitle', 'Register a new employee into the enterprise management system')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Back Action -->
    <div class="flex items-center justify-between">
        <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1.5">
                <li>
                    <a href="{{ route('employees.index') }}" class="hover:text-teal-600 transition-colors">Employees</a>
                </li>
                <li>
                    <span class="text-slate-400">/</span>
                </li>
                <li class="text-teal-600 font-semibold" aria-current="page">New Employee</li>
            </ol>
        </nav>

        <a href="{{ route('employees.index') }}" 
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-2xs transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to Directory</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="soft-card rounded-2xl overflow-hidden">
        
        <!-- Header Banner -->
        <div class="p-6 bg-gradient-to-r from-[#0B132B] to-[#1C2541] text-white flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl bg-teal-500/20 border border-teal-400/30 flex items-center justify-center text-teal-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-white tracking-tight">Employee Registration Form</h2>
                    <p class="text-xs text-slate-300">Fill in all required fields accurately for verification.</p>
                </div>
            </div>
            <span class="text-xs font-medium px-3 py-1 rounded-full bg-teal-400/20 text-teal-300 border border-teal-400/30 hidden sm:inline-block">
                Required fields marked *
            </span>
        </div>

        <!-- Form Body -->
        <form action="{{ route('employees.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf

            @if ($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-1 text-xs sm:text-sm">
                        <p class="font-bold text-rose-900">Submission Failed: {{ $errors->count() }} {{ Str::plural('error', $errors->count()) }} found</p>
                        <p class="text-rose-700 mt-0.5">Please review and correct the invalid fields highlighted in red below.</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <!-- Full Name -->
                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Full Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           placeholder="e.g. Budi Santoso" 
                           class="w-full px-4 py-2.5 bg-slate-50 border @error('name') border-rose-400 bg-rose-50/20 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Email Address <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}"
                           placeholder="budi@example.com" 
                           class="w-full px-4 py-2.5 bg-slate-50 border @error('email') border-rose-400 bg-rose-50/20 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                    @error('email')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Phone Number <span class="text-rose-500">*</span>
                    </label>
                    <input type="tel" 
                           name="phone" 
                           id="phone" 
                           value="{{ old('phone') }}"
                           placeholder="08123456789" 
                           class="w-full px-4 py-2.5 bg-slate-50 border @error('phone') border-rose-400 bg-rose-50/20 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                    <p class="mt-1 text-[11px] text-slate-400">Stores leading zero (e.g. 0812...)</p>
                    @error('phone')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Gender <span class="text-rose-500">*</span>
                    </label>
                    <select name="gender" 
                            id="gender" 
                            class="w-full px-4 py-2.5 bg-slate-50 border @error('gender') border-rose-400 bg-rose-50/20 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                        <option value="">Select Gender</option>
                        @foreach($genders as $g)
                            <option value="{{ $g }}" {{ old('gender') === $g ? 'selected' : '' }}>
                                {{ $g }}
                            </option>
                        @endforeach
                    </select>
                    @error('gender')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Education -->
                <div>
                    <label for="education" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Education Level <span class="text-rose-500">*</span>
                    </label>
                    <select name="education" 
                            id="education" 
                            class="w-full px-4 py-2.5 bg-slate-50 border @error('education') border-rose-400 bg-rose-50/20 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                        <option value="">Select Education</option>
                        @foreach($educations as $edu)
                            <option value="{{ $edu }}" {{ old('education') === $edu ? 'selected' : '' }}>
                                {{ $edu }}
                            </option>
                        @endforeach
                    </select>
                    @error('education')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Age -->
                <div>
                    <label for="age" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Age (Years) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                           name="age" 
                           id="age" 
                           min="18" 
                           max="100"
                           value="{{ old('age') }}"
                           placeholder="e.g. 28" 
                           class="w-full px-4 py-2.5 bg-slate-50 border @error('age') border-rose-400 bg-rose-50/20 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                    <p class="mt-1 text-[11px] text-slate-400">Allowed range: 18 - 100 years</p>
                    @error('age')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Work Duration -->
                <div>
                    <label for="work_duration" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Work Duration (Years) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                           name="work_duration" 
                           id="work_duration" 
                           min="0" 
                           value="{{ old('work_duration') }}"
                           placeholder="e.g. 3" 
                           class="w-full px-4 py-2.5 bg-slate-50 border @error('work_duration') border-rose-400 bg-rose-50/20 ring-2 ring-rose-200 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                    <p class="mt-1 text-[11px] text-slate-400">Total tenure (minimum 0 years)</p>
                    @error('work_duration')
                        <p class="mt-1.5 text-xs text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('employees.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold transition-all shadow-2xs">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white text-sm font-semibold shadow-sm shadow-teal-600/20 hover:shadow-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Save Employee</span>
                </button>
            </div>
        </form>

    </div>

</div>
@endsection

