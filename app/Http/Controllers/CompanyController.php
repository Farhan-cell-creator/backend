<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Yajra\DataTables\Facades\DataTables;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


class CompanyController extends Controller
{
    

//    public function read(Request $request)
// {
//     if ($request->ajax()) {

//         $data = Company::query();

//         return DataTables::of($data)
//             ->addIndexColumn()

//             ->addColumn('logo', function ($company) {

//                 if (!$company->logo) {
//                     return 'No Logo';
//                 }

//                 return '<img src="' .   $company->logo. '"
//                         width="60"
//                         height="60"
//                         style="object-fit: contain;">';
//             })

//             ->addColumn('action', function ($row) {

//                 return '
//                     <a href="' . route('company.edit', $row->id) . '"
//                        class="btn btn-sm btn-primary">
//                         Edit
//                     </a>

//                     <form action="' . route('company.delete') . '"
//                           method="POST"
//                           class="d-inline">

//                         ' . csrf_field() . '
//                         ' . method_field('DELETE') . '

//                         <input type="hidden"
//                                name="id"
//                                value="' . $company->id . '">

//                         <button type="submit"
//                                 class="btn btn-sm btn-danger"
//                                 onclick="return confirm(\'Are you sure?\')">
//                             Delete
//                         </button>
//                     </form>
//                 ';
//             })

//             ->rawColumns(['logo', 'action'])
//             ->make(true);
//     }

//     return view('company.view', [
//         'message' => 'Read data successfully'
//     ]);
// }

public function read(Request $request)
{
    if ($request->ajax()) {

        $data = Company::query();

        return DataTables::eloquent($data)
            ->addIndexColumn()

            ->addColumn('logo', function ($company) {

                if (!$company->logo) {
                    return 'No Logo';
                }

                return '<img src="' . $company->logo . '"
                        width="60"
                        height="60"
                        style="object-fit: contain;">';
            })

            ->addColumn('action', function ($company) {

                return '
                    <a href="' . route('company.edit', ['id' => $company->id]) . '"
                       class="btn btn-sm btn-primary">
                        Edit
                    </a>

                    <form action="' . route('company.delete') . '"
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

            ->rawColumns(['logo', 'action'])
            ->make(true);
    }

    return view('company.view');
}



// for aws s3 



//    public function create(Request $request)
// {
//     $validate = $request->validate([
//         'name' => ['required', 'string', 'max:255'],
//         'email' => ['required', 'email'],
//         'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
//     ]);

//     // Image ko S3 par upload karein
//     $logoPath = $request->file('logo')->store('company-logos', 's3');

//     // S3 image ka URL
//     $logoUrl = Storage::disk('s3')->url($logoPath);

//     // Logo URL ko data mein add karein
//     $validate['logo'] = $logoUrl;

//     // Company database mein save
//     $data = Company::create($validate);

//     return redirect()
//         ->route('company.index')
//         ->with('success', 'Record created successfully');
// }

public function create(Request $request)
{
    $validate = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email'],
        'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
    ]);

    $file = $request->file('logo');

    $fileName = 'company-logos/' . uniqid() . '.' . $file->getClientOriginalExtension();

    $bucket = env('BUCKET');

    $url = "https://firebasestorage.googleapis.com/v0/b/{$bucket}/o";

    $response = Http::withHeaders([
        'Content-Type' => $file->getMimeType(),
    ])->withBody(
        file_get_contents($file->getRealPath()),
        $file->getMimeType()
    )->post($url . '?uploadType=media&name=' . rawurlencode($fileName));

    if (!$response->successful()) {
        return back()
            ->withInput()
            ->with('error', 'Logo upload failed: ' . $response->body());
    }

    $logoUrl = "https://firebasestorage.googleapis.com/v0/b/{$bucket}/o/"
        . rawurlencode($fileName)
        . "?alt=media";

    $validate['logo'] = $logoUrl;

    Company::create($validate);

    return redirect()
        ->route('company.index')
        ->with('success', 'Record created successfully');
}

public function edit($id)
{
    $result = Company::where('id', $id)->firstOrFail();

    return view('company.update', [
        'message' => "Read data successfully",
        'result' => $result
    ]);
}

    public function update(Request $request,$id)
    {
      $validate = $request->validate([
        'name'=>['required','string','max:255'],
        'email'=>['required','email'],
        'logo'=>['required','url']
        ]);
        $check=Company::where('id', $id)->update($validate );

        if($check)
            {
                return redirect()->route('company.read');
            }
          return response()->json([
                    'message'=>' Record  not Update '
        
                ],404);  
    }
   public function delete(Request $request)
{
    $result = Company::where('id', $request->id)->delete();

    if ($result) {
        return redirect()
            ->route('company.read')
            ->with('message', 'Record deleted successfully');
    }

    return redirect()
        ->route('company.read')
        ->with('message', 'Record not deleted successfully');
}
}
