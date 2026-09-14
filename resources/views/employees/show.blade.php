@extends('layouts.app')

@section('title', 'Employee Details - ' . $employee->name)
@section('header-title', 'Employee Details')
@section('header-subtitle', 'Comprehensive record and career profile overview')

@section('content')
<div x-data="{ 
    deleteModalOpen: false, 
    closeDeleteModal() {
        this.deleteModalOpen = false;
    }
}" class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Top Actions -->
    <div class="flex items-center justify-between">
        <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1.5">
                <li>
                    <a href="{{ route('employees.index') }}" class="hover:text-teal-600 transition-colors">Employees</a>
                </li>
                <li>
                    <span class="text-slate-400">/</span>
                </li>
                <li class="text-teal-600 font-semibold" aria-current="page">{{ $employee->name }}</li>
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

    <!-- Main Profile Card -->
    <div class="soft-card rounded-2xl overflow-hidden">
        
        <!-- Header Profile Banner -->
        <div class="p-6 sm:p-8 bg-gradient-to-r from-[#0B132B] via-[#1C2541] to-[#0B132B] text-white">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center font-extrabold text-xl shadow-lg shrink-0 {{ $employee->gender === 'Laki-laki' ? 'bg-sky-500/20 text-sky-300 border border-sky-400/30' : 'bg-rose-500/20 text-rose-300 border border-rose-400/30' }}">
                        {{ strtoupper(substr($employee->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h2 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">{{ $employee->name }}</h2>
                            <span class="text-xs px-2.5 py-0.5 rounded-full font-medium {{ $employee->gender === 'Laki-laki' ? 'bg-sky-400/20 text-sky-300' : 'bg-rose-400/20 text-rose-300' }}">
                                {{ $employee->gender }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-300 mt-1 flex items-center gap-3">
                            <span class="flex items-center gap-1 text-slate-300">
                                <svg class="w-3.5 h-3.5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $employee->email }}
                            </span>
                            <span class="text-slate-500">&bull;</span>
                            <span class="flex items-center gap-1 font-mono text-slate-300">
                                <svg class="w-3.5 h-3.5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $employee->phone }}
                            </span>
                        </p>
                    </div>
                </div>

                @if(auth()->user()?->isAdmin())
                    <!-- Action Buttons in Banner -->
                    <div class="flex items-center gap-2 self-end sm:self-center">
                        <a href="{{ route('employees.edit', $employee) }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold border border-white/20 backdrop-blur-xs transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit</span>
                        </a>
                        <button type="button" 
                                @click="deleteModalOpen = true"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 text-xs font-semibold border border-rose-400/30 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Delete</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Details Grid -->
        <div class="p-6 sm:p-8 space-y-6">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Metrics & Qualifications</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Education -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <p class="text-xs text-slate-500 font-medium">Education Level</p>
                    <p class="text-lg font-bold text-slate-800 mt-1">{{ $employee->education }}</p>
                    <span class="text-[11px] text-teal-600 font-medium">Verified Degree</span>
                </div>

                <!-- Age -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <p class="text-xs text-slate-500 font-medium">Current Age</p>
                    <p class="text-lg font-bold text-slate-800 mt-1">{{ $employee->age }} <span class="text-xs font-normal text-slate-400">years old</span></p>
                    <span class="text-[11px] text-slate-500 font-medium">Valid demographic data</span>
                </div>

                <!-- Work Duration -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <p class="text-xs text-slate-500 font-medium">Work Tenure</p>
                    <p class="text-lg font-bold text-slate-800 mt-1">{{ $employee->work_duration }} <span class="text-xs font-normal text-slate-400">years</span></p>
                    <span class="text-[11px] text-teal-600 font-medium">Experience recorded</span>
                </div>

                <!-- Gender -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <p class="text-xs text-slate-500 font-medium">Gender</p>
                    <p class="text-lg font-bold text-slate-800 mt-1">{{ $employee->gender }}</p>
                    <span class="text-[11px] text-slate-500 font-medium">Demographic record</span>
                </div>

            </div>

            <!-- Metadata Timestamps -->
            <div class="pt-6 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Record Created: <strong class="text-slate-700">{{ $employee->created_at->format('F d, Y \a\t H:i') }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Last Updated: <strong class="text-slate-700">{{ $employee->updated_at->format('F d, Y \a\t H:i') }}</strong></span>
                </div>
            </div>

        </div>

    </div>

    <!-- Alpine.js Delete Confirmation Modal -->
    <div x-show="deleteModalOpen" 
         x-cloak
         @keydown.escape.window="closeDeleteModal()"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true"
         style="display: none;">
        
        <div x-show="deleteModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
             @click="closeDeleteModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="deleteModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200">
                
                <div class="bg-white p-6 sm:p-7">
                    <div class="flex items-start gap-4">
                        <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 border border-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-0.5 text-left">
                            <h3 class="text-base font-bold leading-6 text-slate-900" id="modal-title">
                                Delete Employee?
                            </h3>
                            <div class="mt-2">
                                <p class="text-xs sm:text-sm text-slate-600">
                                    Are you sure you want to delete this employee? This action cannot be undone.
                                </p>
                                <div class="mt-2.5 px-3 py-2 bg-slate-100 rounded-xl text-xs font-semibold text-slate-800">
                                    <span class="text-slate-400 font-normal">Employee:</span> {{ $employee->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5 border-t border-slate-100">
                    <button type="button" 
                            @click="closeDeleteModal()" 
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-white px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-700 shadow-xs border border-slate-300 hover:bg-slate-50 focus:outline-hidden transition-all">
                        Cancel
                    </button>

                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-rose-600 px-4 py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs hover:bg-rose-700 focus:outline-hidden transition-all">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

