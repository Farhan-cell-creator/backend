<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CredentialController extends Controller
{
    //
    public function index()
    {
        return view('credential.create');
    }

    public function create(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'string'],
            'value' => ['required', 'string'],
        ]);
        $result = Credential::Create($validate);
        if (! $result) {
            return response()->json([
                'message' => 'Record is not Created Successfully',
                'success' => false,
            ], 400);
        }

        return redirect()->route('credential.index');

    }

    public function read(Request $request)
    {
        if ($request->ajax()) {

            $data = Credential::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($credential) {

                    return '
                    <a href="'.route('credential.edit', $credential->id).'"
                       class="btn btn-primary btn-sm">
                        Edit
                    </a>

                    <form action="'.route('credential.delete').'"
                          method="POST"
                          style="display:inline-block">

                        '.csrf_field().'
                        '.method_field('DELETE').'

                        <input type="hidden"
                               name="id"
                               value="'.$credential->id.'">

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm(\'Are you sure?\')">
                            Delete
                        </button>

                    </form>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('credential.read');
    }

    public function edit($id)
    {
        $data = Credential::where('id', $id)->first();

        return view('credential.update', compact('data'));

    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => ['required', 'string'],
            'value' => ['required', 'string'],
        ]);

        Credential::where('id', $id)->update(
            [
                'name' => $validate['name'],
                'value' => $validate['value'],
            ]
        );

        return redirect()->route('credential.read');
    }

    public function delete(Request $request)
    {
        $result = Credential::where('id', $request->id)->delete();
        if (! $result) {
            return response()->json([
                'message' => 'Record Not deleted',
                'success' => false,
            ], 400);
        }

        return redirect()->route('credential.read');
    }
}
