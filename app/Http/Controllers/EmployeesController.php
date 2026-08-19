<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
class EmployeesController extends Controller
{
    //
    public function get()
    {
        $data=Employee::all();
        return response()->json([
            'message'=>'read data successfully',
            'data'=>$data
        ]);
    }
    public function index(Request $request)
    {
        $id=$request->query('id');
        $data=Employee::where('id',$id)->first();
        if($data)
            {
                 return response()->json([
       'message'=>'read data successfully',
       'data'=>$data
        ]);

            }
            return response()->json([
       'message'=>'employee not found',
       'data'=>null
        ]);

       
    }
    public function delete(Request $request)
    {
        $id=$request->query('id');
        $data=Employee::where('id',$id)->delete();
        if($data)
            {
                 return response()->json([
       'message'=>'delete data successfully'
      
        ],200);

            }
            return response()->json([
       'message'=>'employee not found'
       
        ],404);
    }
    

       
    
}
