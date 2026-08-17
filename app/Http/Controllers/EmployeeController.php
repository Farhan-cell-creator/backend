<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $companies=Company::all();
        return view('employee.create',compact('companies'));
    }
    public function read()
    {
       $data= Employee::all();
       return view('employee.view',[
        'message'=>' read data successfully',
        'data'=> $data
       ]);
    //    return response()->json([
    //    'message'=>"Read data successfully",
    //    'data'=>$data
    //    ]);

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
        if($data)
            {
                  return redirect()->route('employee.index');
                //   return response()->json([
                //     'message'=>'create employee successfully',
                //     'data'=>$data
                //   ]);


            }
      

    }
    public function edit($id)
    {
        $result=Employee::where('id',$id)->firstOrfail();
        $company=Company::all();
        return view('employee.update',[
            'data'=>$result,
            'company'=>$company
        ]);
    }
     public function update (Request $request,$id)
     {
        $validate = $request->validate([
    'first_name' => ['required', 'string', 'max:255'],
    'last_name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'email',  Rule::unique('employees', 'email')->ignore($id)],
    'phone' => ['nullable', 'string', 'max:11'],
    'gender' => ['nullable', 'string'],
    'company_id' => ['required', 'integer', 'exists:companies,id'],
        ]);
        $result=Employee::where('id',$id)->update($validate);
        if($result)
            {
               return redirect()->route('employee.read');
            }
            return response()->json([
                'message'=>'Data is not updated'
               ],404);



     }
     public function delete(Request $request)
{
    $result=Employee::where('id',$request->id)->delete();
    if($result)
        {
           return redirect()->route('employee.read');
        }
        return response()->json([
                'message'=>'record is not deleted',
                 
            ],404);
    
}
}

