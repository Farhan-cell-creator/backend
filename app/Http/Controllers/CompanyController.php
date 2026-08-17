<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;


class CompanyController extends Controller
{
    //

     public function read()
    {
       $data= Company::all();
       return view('company.view',[
         'message'=>"Read data successfully",
       'data'=>$data
       ]);
       

    }
    public function create(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'logo' => ['required', 'url'],
        ]);

        $data = Company::create($validate);

        return redirect()
            ->route('company.index')
            ->with('success', 'Record created successfully');
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
                return response()->json([
                    'message'=>'Update Record Successfully',
                    'data'=>$validate
                ],404);
            }
          return response()->json([
                    'message'=>' Record  not Update '
        
                ]);  
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
