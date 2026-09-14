<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the analytics dashboard with real KPI metrics and chart datasets.
     */
    public function index(): View
    {
        $totalEmployees = Employee::count();
        $maleEmployees = Employee::where('gender', 'Laki-laki')->count();
        $femaleEmployees = Employee::where('gender', 'Perempuan')->count();
        $avgAge = $totalEmployees > 0 ? round(Employee::avg('age'), 1) : 0;
        $avgTenure = $totalEmployees > 0 ? round(Employee::avg('work_duration'), 1) : 0;

        // Gender Distribution for D3 Doughnut Chart
        $genderData = [
            [
                'label' => 'Laki-laki',
                'count' => $maleEmployees,
                'percentage' => $totalEmployees > 0 ? round(($maleEmployees / $totalEmployees) * 100, 1) : 0,
                'color' => '#0284C7', // Sky 600
            ],
            [
                'label' => 'Perempuan',
                'count' => $femaleEmployees,
                'percentage' => $totalEmployees > 0 ? round(($femaleEmployees / $totalEmployees) * 100, 1) : 0,
                'color' => '#E11D48', // Rose 600
            ],
        ];

        // Education Distribution for D3 Bar Chart
        $educationCounts = Employee::selectRaw('education, count(*) as count')
            ->groupBy('education')
            ->pluck('count', 'education')
            ->toArray();

        $educationData = [];
        $educationColors = [
            'SMA/SMK' => '#64748B', // Slate 500
            'D3' => '#0D9488',      // Teal 600
            'S1' => '#2563EB',      // Blue 600
            'S2' => '#7C3AED',      // Violet 600
            'S3' => '#DB2777',      // Pink 600
        ];

        foreach (Employee::EDUCATIONS as $edu) {
            $count = $educationCounts[$edu] ?? 0;
            $educationData[] = [
                'label' => $edu,
                'count' => $count,
                'percentage' => $totalEmployees > 0 ? round(($count / $totalEmployees) * 100, 1) : 0,
                'color' => $educationColors[$edu] ?? '#0D9488',
            ];
        }

        // Age Distribution (18-25, 26-35, 36-45, 46-55, 56+)
        $ageBrackets = [
            ['label' => '18–25', 'min' => 18, 'max' => 25, 'color' => '#0D9488'],
            ['label' => '26–35', 'min' => 26, 'max' => 35, 'color' => '#0284C7'],
            ['label' => '36–45', 'min' => 36, 'max' => 45, 'color' => '#4F46E5'],
            ['label' => '46–55', 'min' => 46, 'max' => 55, 'color' => '#D97706'],
            ['label' => '56+',   'min' => 56, 'max' => 150, 'color' => '#9333EA'],
        ];

        $ageData = [];
        foreach ($ageBrackets as $b) {
            $count = Employee::whereBetween('age', [$b['min'], $b['max']])->count();
            $ageData[] = [
                'label' => $b['label'],
                'count' => $count,
                'percentage' => $totalEmployees > 0 ? round(($count / $totalEmployees) * 100, 1) : 0,
                'color' => $b['color'],
            ];
        }

        // Work Duration Distribution (<2 yrs, 2-5 yrs, 6-10 yrs, 11-15 yrs, 15+ yrs)
        $tenureBrackets = [
            ['label' => '< 2 yrs',   'min' => 0,  'max' => 1,   'color' => '#14B8A6'],
            ['label' => '2–5 yrs',   'min' => 2,  'max' => 5,   'color' => '#06B6D4'],
            ['label' => '6–10 yrs',  'min' => 6,  'max' => 10,  'color' => '#3B82F6'],
            ['label' => '11–15 yrs', 'min' => 11, 'max' => 15,  'color' => '#8B5CF6'],
            ['label' => '15+ yrs',   'min' => 16, 'max' => 100, 'color' => '#F43F5E'],
        ];

        $workDurationData = [];
        foreach ($tenureBrackets as $b) {
            $count = Employee::whereBetween('work_duration', [$b['min'], $b['max']])->count();
            $workDurationData[] = [
                'label' => $b['label'],
                'count' => $count,
                'percentage' => $totalEmployees > 0 ? round(($count / $totalEmployees) * 100, 1) : 0,
                'color' => $b['color'],
            ];
        }

        // Recent Employees for quick table preview
        $recentEmployees = Employee::latest()->take(5)->get();

        return view('dashboard', [
            'kpi' => [
                'totalEmployees' => $totalEmployees,
                'maleEmployees' => $maleEmployees,
                'femaleEmployees' => $femaleEmployees,
                'averageAge' => $avgAge,
                'averageTenure' => $avgTenure,
                'malePercentage' => $totalEmployees > 0 ? round(($maleEmployees / $totalEmployees) * 100) : 0,
                'femalePercentage' => $totalEmployees > 0 ? round(($femaleEmployees / $totalEmployees) * 100) : 0,
            ],
            'charts' => [
                'gender' => $genderData,
                'education' => $educationData,
                'age' => $ageData,
                'workDuration' => $workDurationData,
            ],
            'recentEmployees' => $recentEmployees,
        ]);
    }
}

