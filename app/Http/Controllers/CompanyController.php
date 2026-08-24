<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function read(Request $request)
    {
        // Handle Ajax Request
        if ($request->ajax()) {

            $data = Company::query();
            // Filter Company By Starting Date
            if ($request->filled('from_date')) {
                $data->whereDate('created_at', '>=', $request->from_date);
            }
            // Filter Company By Ending Date
            if ($request->filled('to_date')) {
                $data->whereDate('created_at', '<=', $request->to_date);
            }

            // Return Company Data
            return DataTables::eloquent($data)
                ->addIndexColumn()

                ->addColumn('logo', function ($company) {

                    if (! $company->logo) {
                        return 'No Logo';
                    }

                    return '<img src="'.$company->logo.'"
                        width="60"
                        height="60"
                        style="object-fit: contain;">';
                })

                ->addColumn('action', function ($company) {

                    return '
                    <a href="'.route('company.edit', ['id' => $company->id]).'"
                       class="btn btn-sm btn-primary">
                        Edit
                    </a>

                    <form action="'.route('company.delete').'"
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

                ->rawColumns(['logo', 'action'])
                ->make(true);
        }

        return view('company.view');
    }

    public function create(Request $request)
    {
        // Validate Input
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:companies,email'],
            'password' => ['required', 'string', 'min:5', 'max:12'],
            'user_name' => ['required', 'string', 'max:20'],
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

        ]);

        $file = $request->file('logo');

        // Create a File Unique Name
        $fileName = 'company-logos/'.uniqid().'.'.$file->getClientOriginalExtension();

        $bucket = env('BUCKET');

        $url = "https://firebasestorage.googleapis.com/v0/b/{$bucket}/o";
        // Send File to Firebase
        $response = Http::withHeaders([
            'Content-Type' => $file->getMimeType(),
        ])->withBody(
            file_get_contents($file->getRealPath()),
            $file->getMimeType()
        )->post($url.'?uploadType=media&name='.rawurlencode($fileName));
        // Handle Firebase Response
        if (! $response->successful()) {
            return back()
                ->withInput()
                ->with('error', 'Logo upload failed: '.$response->body());
        }

        $logoUrl = "https://firebasestorage.googleapis.com/v0/b/{$bucket}/o/"
            .rawurlencode($fileName)
            .'?alt=media';

        $validate['logo'] = $logoUrl;
        // Create Company

        $company = Company::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'logo' => $validate['logo'],
        ]);
        $user = User::create([
            'name' => $validate['user_name'],
            'email' => $validate['email'],
            'password' => $validate['password'],
            'company_id' => $company->id,

        ]);
        $user->assignRole('company_user');

        return redirect()
            ->route('company.index')
            ->with('success', 'Record created successfully');
    }

    public function edit($id)
    {
        // Find Company by Id
        $result = Company::where('id', $id)->firstOrFail();
        $user=User::where('company_id',$result->id)->first();

        return view('company.update', [
            'message' => 'Read data successfully',
            'result' => $result,
             'user'=>$user,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate Input
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['nullable', 'string', 'min:5', 'max:12'],
            'user_name' => ['required', 'string', 'max:20'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        //    Find Company By Id
        $company = Company::find($id);

        if (! $company) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        if ($request->filled('password')) {
            $validate['password'] = Hash::make($request->password);
        } else {
            unset($validate['password']);
        }
        //    Check Logo Field
        if ($request->hasFile('logo')) {

            if ($company->logo) {
                // Delete Logo
                $this->deleteFromFirebase($company->logo);
            }

            $file = $request->file('logo');
            //   Create  File Name
            $fileName = 'company-logos/'.uniqid().'.'
                .$file->getClientOriginalExtension();
            //   Bucket Name
            $bucket = env('BUCKET');
            // Create Bucket Url

            $url = "https://firebasestorage.googleapis.com/v0/b/{$bucket}/o";
            // Upload  File From Firebase
            $response = Http::withHeaders([
                'Content-Type' => $file->getMimeType(),
            ])->withBody(
                file_get_contents($file->getRealPath()),
                $file->getMimeType()
            )->post(
                $url.'?uploadType=media&name='.rawurlencode($fileName)
            );

            // Handle Firebase Response
            if (! $response->successful()) {
                return back()
                    ->withInput()
                    ->with('error', 'Logo upload failed: '.$response->body());
            }

            $logoUrl = "https://firebasestorage.googleapis.com/v0/b/{$bucket}/o/"
                .rawurlencode($fileName)
                .'?alt=media';

            $validate['logo'] = $logoUrl;
        } else {

            unset($validate['logo']);
        }
       $user= User::where('company_id',$company->id)->first();

    if ($user) {

        $user->name = $validate['user_name'];
        $user->email=$validate['email'];

        // Password only update when entered
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
    }

    // Remove User fields before updating Company
    unset($validate['user_name']);
    unset($validate['password']);

        $company->update($validate);

        return redirect()
            ->route('company.read')
            ->with('message', 'Record updated successfully');
    }

    private function deleteFromFirebase($logoUrl)
    {
        if (! $logoUrl) {
            return false;
        }

        $bucket = env('BUCKET');

        $prefix = "https://firebasestorage.googleapis.com/v0/b/{$bucket}/o/";

        if (! str_contains($logoUrl, $prefix)) {
            return false;
        }

        // Extract File Name
        $fileName = str_replace($prefix, '', $logoUrl);

        // Remove Query Parameter
        $fileName = explode('?', $fileName)[0];

        $fileName = rawurldecode($fileName);

        $deleteUrl = "https://firebasestorage.googleapis.com/v0/b/{$bucket}/o/"
            .rawurlencode($fileName);

        $response = Http::delete($deleteUrl);

        return $response->successful();
    }

    public function delete(Request $request)
    {
        $company = Company::find($request->id);

        if (! $company) {
            return redirect()
                ->route('company.read')
                ->with('message', 'Record not found');
        }

        if ($company->logo) {
            $this->deleteFromFirebase($company->logo);
        }

        $result = $company->delete();

        if ($result) {
            return redirect()
                ->route('company.read')
                ->with('message', 'Record deleted successfully');
        }

        return redirect()
            ->route('company.read')
            ->with('message', 'Record not deleted successfully');
    }
    public function companyDetail()
    {
         $user = auth()->user();

    if ($user->hasRole('company_user')) {

        $company = Company::where('id', $user->company_id)->first();

    } elseif ($user->hasRole('employee')) {

        $employee = Employee::findOrFail($user->employee_id);

        $company = Company::findOrFail($employee->company_id);
    }

    return view('company.companyDetail', compact('company'));
    }
}
