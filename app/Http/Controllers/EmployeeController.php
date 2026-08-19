<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Mail\EmployeeCreate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $companies=Company::all();
        return view('employee.create',compact('companies'));
    }
   
    


public function read(Request $request)
{
    if ($request->ajax()) {

        $data = Employee::query();

        return DataTables::of($data)
         ->addColumn('action', function ($company) {

                return '
                    <a href="' . route('employee.edit', ['id' => $company->id]) . '"
                       class="btn btn-sm btn-primary">
                        Edit
                    </a>

                    <form action="' . route('employee.delete') . '"
                          method="POST"
                          class="d-inline">

                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '

                        <input type="hidden"
                               name="id"
                               value="' . $company->id . '">

                        <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm(\'Are you sure?\')">
                            Delete
                        </button>
                    </form>
                ';
            })
            ->make(true);
    }

    return view('employee.view');
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
                $result=Company::where('id',$validate['company_id'])->firstOrFail();
Mail::to($result->email)
    ->send(new EmployeeCreate($data));
                  return redirect()->route('employee.index');
               


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

