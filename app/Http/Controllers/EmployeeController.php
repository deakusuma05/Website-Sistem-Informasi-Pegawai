<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees with search and filtering.
     */
    public function index(Request $request): View
    {
        $query = Employee::query();

        // Search by name, email, or phone
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by gender
        if ($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }

        // Filter by education
        if ($education = $request->input('education')) {
            $query->where('education', $education);
        }

        $employees = $query->latest()->paginate(10)->withQueryString();

        return view('employees.index', [
            'employees' => $employees,
            'genders' => Employee::GENDERS,
            'educations' => Employee::EDUCATIONS,
            'filters' => [
                'search' => $request->input('search', ''),
                'gender' => $request->input('gender', ''),
                'education' => $request->input('education', ''),
            ],
        ]);
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create(): View
    {
        abort_if(!auth()->user()?->isAdmin(), 403, 'Unauthorized action. Only administrators can create employees.');

        return view('employees.create', [
            'genders' => Employee::GENDERS,
            'educations' => Employee::EDUCATIONS,
        ]);
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        abort_if(!auth()->user()?->isAdmin(), 403, 'Unauthorized action. Only administrators can create employees.');

        Employee::create($request->validated());

        return redirect()->route('employees.index')
            ->with('success', 'Employee added successfully.');
    }

    /**
     * Display the specified employee details.
     */
    public function show(Employee $employee): View
    {
        return view('employees.show', [
            'employee' => $employee,
        ]);
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee): View
    {
        abort_if(!auth()->user()?->isAdmin(), 403, 'Unauthorized action. Only administrators can edit employees.');

        return view('employees.edit', [
            'employee' => $employee,
            'genders' => Employee::GENDERS,
            'educations' => Employee::EDUCATIONS,
        ]);
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        abort_if(!auth()->user()?->isAdmin(), 403, 'Unauthorized action. Only administrators can update employees.');

        $employee->update($request->validated());

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        abort_if(!auth()->user()?->isAdmin(), 403, 'Unauthorized action. Only administrators can delete employees.');

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}

