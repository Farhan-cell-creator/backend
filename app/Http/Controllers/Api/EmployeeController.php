<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    //
    public function get()
    {
        $data = Employee::all();

        return response()->json([
            'message' => 'read data successfully',
            'success' => 'true',
            'data' => $data,
        ], 200);
    }

    public function index(Request $request)
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

    public function delete(Request $request)
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
