<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;

class AnalyticsController extends Controller
{
    //
    public function gender()
    {
        $male = Employee::where('gender', 'male')->count();
        $female = Employee::where('gender', 'female')->count();
        $companies = Company::withCount('employees')->get();
        return view('analytics.chart', compact('male', 'female', 'companies'));
    }
}
