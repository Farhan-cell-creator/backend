<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArrayController extends Controller
{
public function arrayPractice()

{
    $employees = ["Ali", "Ahmed", "Usman", "Hamza"];
    // Print all employees
    foreach ($employees as $employee) {
        echo $employee . "<br>";
    }

    // Print first employee
    echo "First Employee: " . $employees[0] . "<br>";

    // Count employees
    echo "Total Employees: " . count($employees) . "<br>";

    // Add  new employee
    $employees[] = "Bilal";

    // Check if Ali exists
    if (in_array("Ali", $employees)) {
        echo "Ali exists<br>";
    }

    // Remove  last employee
    array_pop($employees);

    // Print employees 
    echo "<h3>Employees:</h3>";

    foreach ($employees as $employee) {
        echo $employee . "<br>";
    }

}
}
