<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class EagerController extends Controller
{
    //
    
    public function show()
    {
        // using Lazy Loading
        $companies = Company::get();
        foreach ($companies as $company) {
            echo 'Company: '.$company->name.'<br>';
            foreach ($company->employees as $employee) {
                echo 'Employee: '.$employee->first_name.'<br>';
                foreach ($employee->tasks as $task) {
                    echo 'Task: '.$task->title.'<br>';
                }
            }
            echo '<hr>';
        }
        // using Eager Loading
        //  $companies = Company::with('employees.tasks')->get();
        // foreach ($companies as $company) {
        //     echo 'Company: '.$company->name.'<br>';
        //     foreach ($company->employees as $employee) {
        //         echo 'Employee: '.$employee->first_name.'<br>';
        //         foreach ($employee->tasks as $task) {
        //             echo 'Task: '.$task->title.'<br>';
        //         }
        //     }
        //     echo '<hr>';
        // }
    }
}
