<?php

namespace App\Http\Controllers;

use App\Mail\EmployeeCreate;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        // Fetch Company Data
         $user=auth()->user();
         if($user->hasRole('company_user'))
            {
                $companies = Company::where('id',$user->company_id)->get();
            }
             if($user->hasRole('super_admin'))
            {
               $companies = Company::all();
            }
        

        return view('employee.create', compact('companies'));
    }

    public function read(Request $request)
    {
        
        // Handle Ajax request
        if ($request->ajax()) {
            $user = auth()->user();

            $data = Employee::query();
            // Company user -> only own company employees
        if ($user->hasRole('company_user')) {

            $data->where('company_id', $user->company_id);
        }

    
            // Filter  employee  Starting Date
            if ($request->filled('from_date')) {
                $data->whereDate('created_at', '>=', $request->from_date);
            }
             // Filter  employee  Ending Date
            if ($request->filled('to_date')) {
                $data->whereDate('created_at', '<=', $request->to_date);
            }
            // Return Employee  Data
            return DataTables::of($data)
                ->addColumn('action', function ($company) {

                    return '
                    <a href="'.route('employee.edit', ['id' => $company->id]).'"
                       class="btn btn-sm btn-primary">
                        Edit
                    </a>

                    <form action="'.route('employee.delete').'"
                          method="POST"
                          class="d-inline">

                        '.csrf_field().'
                        '.method_field('DELETE').'

                        <input type="hidden"
                               name="id"
                               value="'.$company->id.'">

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

    public function create(Request $request)
    {
    //Validate Input  
        $validate = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'phone' => ['nullable', 'string', 'max:11'],
            'gender' => ['nullable', 'string'],
            'company_id' => ['required', 'integer', 'exists:companies,id'],
        ]);
        // Create Employee
        $data = Employee::create($validate);
        if ($data) {
            // Find Newly Created Employee Company
            $result = Company::where('id', $validate['company_id'])->firstOrFail();
            // Send Employee Creation Mail to Company
            Mail::to($result->email)
                ->send(new EmployeeCreate($data));

            return redirect()->route('employee.index');

        }

    }

    public function edit($id)
    {
        // Find Employee By Id
        $result = Employee::where('id', $id)->firstOrfail();
        // Fetch Company for DropDown
        $company = Company::all();

        return view('employee.update', [
            'data' => $result,
            'company' => $company,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate Input
        $validate = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email',  Rule::unique('employees', 'email')->ignore($id)],
            'phone' => ['nullable', 'string', 'max:11'],
            'gender' => ['nullable', 'string'],
            'company_id' => ['required', 'integer', 'exists:companies,id'],
        ]);
        // Find Employee by Id
        $result = Employee::where('id', $id)->update($validate);
        if ($result) {
            return redirect()->route('employee.read');
        }

        return response()->json([
            'message' => 'Data is not updated',
        ], 404);

    }

    public function delete(Request $request)
    {
        // Fetch Employee By Id
        $result = Employee::where('id', $request->id)->delete();
        if ($result) {
            return redirect()->route('employee.read');
        }

        return response()->json([
            'message' => 'record is not deleted',

        ], 404);

    }
}
