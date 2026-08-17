<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function read()
    {
       $data= Employee::all();
       return response()->json([
       'message'=>"Read data successfully",
       'data'=>$data
       ]);

    }
    public function create (Request $request)
    {
        
    $validate = $request->validate([
    'first_name' => ['required', 'string', 'max:255'],
    'last_name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'email', 'unique:employees,email'],
    'phone' => ['nullable', 'string', 'max:11'],
    'gender' => ['nullable', 'string'],
    'company_id' => ['required', 'integer', 'exists:companies,id'],
]);
        $data=Employee::create($validate);
        return response()->json([
            'message'=>'Data Save successfully',
            'data'=>$data
        ]);

    }
     public function update (Request $request,$id)
     {
        $validate = $request->validate([
    'first_name' => ['required', 'string', 'max:255'],
    'last_name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'email', Rule::unique('employees', 'email')->ignore($id)],
    'phone' => ['nullable', 'string', 'max:11'],
    'gender' => ['nullable', 'string'],
    'company_id' => ['required', 'integer', 'exists:companies,id'],
        ]);
        $result=Employee::where('id',$id)->update($validate);
        if($result)
            {
               return response()->json([
                'message'=>'Update Data Successfully',
                 'data'=>$validate
               ]);
            }
            return response()->json([
                'message'=>'Data is not updated'
               ],404);



     }
     public function Delete($id)
{
    $result=Employee::where('id',$id)->delete();
    if($result)
        {
           return response()->json([
                'message'=>'record is deleted successfully',
                 
            ]);
        }
        return response()->json([
                'message'=>'record is not deleted',
                 
            ],404);
    
}
}

