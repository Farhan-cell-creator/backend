<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //

     public function read()
    {
       $data= Company::all();
       return response()->json([
       'message'=>"Read data successfully",
       'data'=>$data
       ]);

    }
    public function create (Request $request)
    {
       $validate= $request->validate([
        'name'=>['required','string','max:255'],
        'email'=>['required','email'],
        'logo'=>['required','url']
    ]);
    $data=Company::create([$validate]);
    return response()->json([
     'message'=> 'record created Successfully',
     'data'=>$data
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
                return response()->json([
                    'message'=>'Update Record Successfully',
                    'data'=>$validate
                ],404);
            }
          return response()->json([
                    'message'=>' Record  not Update '
        
                ]);  
    }
    public function delete($id)
    {
        $result=Company::where('id',$id)->delete();
        if($result)
            {
                return response()->json([
                    'message'=>'Record  deleted Scuuessfully'
                ]);
            }
             return response()->json([
                    'message'=>'Record not  deleted '
                ],404);
    }
}
