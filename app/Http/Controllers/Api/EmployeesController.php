<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeesController extends Controller
{
    //
    public function getAllEmployee()
    {
        $data = Employee::all();

        return response()->json([
            'message' => 'read data successfully',
            'success' => 'true',
            'data' => $data,
        ], 200);
    }

    public function getEmployeeById(Request $request)
    {
        $id = $request->query('id');
        $data = Employee::where('id', $id)->first();
        if ($data) {
            return response()->json([
                'message' => 'read data successfully',
                'success' => 'true',
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'message' => 'employee not found',
            'success' => 'false',
            'data' => null,
        ], 404);
    }

    public function deleteEmployeeById(Request $request)
    {
        $id = $request->query('id');
        $data = Employee::where('id', $id)->delete();
        if ($data) {
            return response()->json([
                'message' => 'delete data successfully',
                'success'=>'true'

            ], 200);

        }

        return response()->json([
            'message' => 'employee not found',
            'success'=>'false'

        ], 404);
    }
}
