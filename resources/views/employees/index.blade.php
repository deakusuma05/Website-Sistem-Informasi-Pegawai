@extends('layouts.app')

@section('title', 'Employee Directory')
@section('header-title', 'Employee Directory')
@section('header-subtitle', 'View, search, filter, and manage all employee records')

@section('content')
<div x-data="{ 
    deleteModalOpen: false, 
    employeeToDelete: { id: null, name: '' },
    openDeleteModal(id, name) {
        this.employeeToDelete = { id, name };
        this.deleteModalOpen = true;
    },
    closeDeleteModal() {
        this.deleteModalOpen = false;
        this.employeeToDelete = { id: null, name: '' };
    }
}" class="space-y-6">

    <!-- Top Action & Search Bar -->
    <div class="soft-card rounded-2xl p-5 transition-all">
        <form method="GET" action="{{ route('employees.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5 items-center">
            
            <!-- Search Input -->
            <div class="lg:col-span-5 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $filters['search'] ?? '' }}"
                       placeholder="Search name, email, or phone..." 
                       class="soft-input w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-hidden">
            </div>

            <!-- Gender Filter -->
            <div class="lg:col-span-3">
                <select name="gender" 
                        class="soft-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 focus:outline-hidden">
                    <option value="">All Genders</option>
                    @foreach ($genders as $g)
                        <option value="{{ $g }}" {{ ($filters['gender'] ?? '') === $g ? 'selected' : '' }}>
                            {{ $g }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Education Filter -->
            <div class="lg:col-span-2">
                <select name="education" 
                        class="soft-input w-full px-3.5 py-2.5 rounded-xl text-sm text-slate-700 focus:outline-hidden">
                    <option value="">All Educations</option>
                    @foreach ($educations as $edu)
                        <option value="{{ $edu }}" {{ ($filters['education'] ?? '') === $edu ? 'selected' : '' }}>
                            {{ $edu }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit" 
                        class="flex-1 px-4 py-2.5 bg-[#0B132B] hover:bg-slate-800 text-white rounded-xl text-sm font-medium transition-all shadow-xs flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter</span>
                </button>

                @if(!empty($filters['search']) || !empty($filters['gender']) || !empty($filters['education']))
                    <a href="{{ route('employees.index') }}" 
                       title="Reset Filters"
                       class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm transition-all flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Employee Table Card -->
    <div class="soft-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                <h2 class="text-sm font-bold text-slate-800 tracking-tight uppercase">Employee Records</h2>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-slate-200/80 text-slate-700 font-semibold">
                    {{ $employees->total() }} Total
                </span>
            </div>

            <div class="text-xs text-slate-400">
                Showing {{ $employees->firstItem() ?? 0 }} - {{ $employees->lastItem() ?? 0 }} of {{ $employees->total() }}
            </div>
        </div>

        @if($employees->count() > 0)
            <!-- Desktop / Tablet Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 divide-y divide-slate-100">
                    <thead class="bg-slate-50/80 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-3.5">Employee</th>
                            <th scope="col" class="px-6 py-3.5">Gender</th>
                            <th scope="col" class="px-6 py-3.5">Education</th>
                            <th scope="col" class="px-6 py-3.5">Age</th>
                            <th scope="col" class="px-6 py-3.5">Experience</th>
                            <th scope="col" class="px-6 py-3.5">Contact</th>
                            <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($employees as $emp)
                            <tr class="hover:bg-teal-50/30 transition-colors group">
                                <!-- Name & Email -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shadow-xs shrink-0 {{ $emp->gender === 'Laki-laki' ? 'bg-sky-100 text-sky-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ strtoupper(substr($emp->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('employees.show', $emp) }}" class="font-semibold text-slate-900 hover:text-teal-600 transition-colors">
                                                {{ $emp->name }}
                                            </a>
                                            <p class="text-xs text-slate-400">{{ $emp->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Gender -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($emp->gender === 'Laki-laki')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-sky-50 text-sky-700 border border-sky-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                            Laki-laki
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Perempuan
                                        </span>
                                    @endif
                                </td>

                                <!-- Education -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700">
                                        {{ $emp->education }}
                                    </span>
                                </td>

                                <!-- Age -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    <span class="font-semibold">{{ $emp->age }}</span>
                                    <span class="text-xs text-slate-400">yrs</span>
                                </td>

                                <!-- Work Duration -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                    <span class="font-semibold">{{ $emp->work_duration }}</span>
                                    <span class="text-xs text-slate-400">yrs</span>
                                </td>

                                <!-- Contact Info -->
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="font-mono">{{ $emp->phone }}</span>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                                    <div class="flex items-center justify-end gap-1">
                                        <!-- View Details -->
                                        <a href="{{ route('employees.show', $emp) }}" 
                                           title="View Details"
                                           class="p-2 rounded-lg text-slate-400 hover:text-teal-600 hover:bg-teal-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        @if(auth()->user()?->isAdmin())
                                            <!-- Edit (Admin Only) -->
                                            <a href="{{ route('employees.edit', $emp) }}" 
                                               title="Edit Employee"
                                               class="p-2 rounded-lg text-slate-400 hover:text-cyan-600 hover:bg-cyan-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Delete (Triggers Confirmation Modal) -->
                                            <button type="button" 
                                                    @click="openDeleteModal('{{ $emp->id }}', '{{ addslashes($emp->name) }}')"
                                                    title="Delete Employee"
                                                    class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40">
                {{ $employees->links() }}
            </div>

        @else
            <!-- Empty State with Isometric Visual -->
            <div class="py-16 px-6 text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-24 h-20" viewBox="0 0 120 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M60 90L105 65L60 40L15 65L60 90Z" fill="#F1F5F9"/>
                        <path d="M60 90L105 65V70L60 95V90Z" fill="#CBD5E1"/>
                        <path d="M60 90L15 65V70L60 95V90Z" fill="#94A3B8"/>
                        <!-- Isometric Document Stack -->
                        <g transform="translate(42, 28)">
                            <path d="M18 0L36 10L18 20L0 10L18 0Z" fill="#E2E8F0" stroke="#0D9488" stroke-width="1.2"/>
                            <path d="M0 10L18 20V26L0 16V10Z" fill="#CBD5E1"/>
                            <path d="M18 20L36 10V16L18 26V20Z" fill="#94A3B8"/>
                        </g>
                        <circle cx="60" cy="30" r="1.5" fill="#0D9488"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800 tracking-tight">No employees found</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-6">
                    @if(!empty($filters['search']) || !empty($filters['gender']) || !empty($filters['education']))
                        No employee records matched your filter criteria. Try clearing search filters.
                    @else
                        No employees have been recorded yet in the system. Get started by adding your first employee.
                    @endif
                </p>
                <div class="flex items-center justify-center gap-3">
                    @if(!empty($filters['search']) || !empty($filters['gender']) || !empty($filters['education']))
                        <a href="{{ route('employees.index') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all">
                            Clear Filters
                        </a>
                    @endif
                    <a href="{{ route('employees.create') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add New Employee</span>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Alpine.js Delete Confirmation Modal -->
    <div x-show="deleteModalOpen" 
         x-cloak
         @keydown.escape.window="closeDeleteModal()"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true"
         style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="deleteModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
             @click="closeDeleteModal()"></div>

        <!-- Modal Dialog Box -->
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
                                    <span class="text-slate-400 font-normal">Employee:</span> <span x-text="employeeToDelete.name"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5 border-t border-slate-100">
                    <button type="button" 
                            @click="closeDeleteModal()" 
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-white px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-700 shadow-xs border border-slate-300 hover:bg-slate-50 focus:outline-hidden transition-all">
                        Cancel
                    </button>

                    <form :action="'{{ url('employees') }}/' + employeeToDelete.id" method="POST" class="inline">
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

