<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        $employees = Employee::where('company_id', $user->company_id)->get();

        return view('task.create', compact('employees'));

    }

    public function createTask(Request $request)
    {
        $user = auth()->user();
        $validate = $request->validate([
            'title' => ['required', 'string', 'max:30'],
            'description' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string'],

            'employee_id' => ['required', 'integer', 'exists:employees,id'],
        ]);
        $validate['user_id'] = $user->id;
        $data = Task::create($validate);

        return view('task.view');

    }

    public function readTask(Request $request)
{
    if ($request->ajax()) {

        $user = auth()->user();

        $data = Task::query();

        // Company user -> apne created tasks
        if ($user->hasRole('company_user')) {
            $data->where('user_id', $user->id);
        }

        // Employee -> sirf apne assigned tasks
        if ($user->hasRole('employee')) {
            $data->where('employee_id', $user->employee_id);
        }

     
        if ($request->filled('from_date')) {
            $data->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        // To date
        if ($request->filled('to_date')) {
            $data->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
        }

        return DataTables::of($data)

            ->addColumn('action', function ($task) {

                $action = '';

                // Edit permission
                if (auth()->user()->can('task-update')) {

                    $action .= '
                        <a href="' . route('task.edit', ['id' => $task->id]) . '"
                           class="btn btn-sm btn-primary">
                            Edit
                        </a>
                    ';
                }

                // Delete permission
                if (auth()->user()->can('task-delete')) {

                    $action .= '
                        <form action="' . route('task.delete') . '"
                              method="POST"
                              class="d-inline">

                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '

                            <input type="hidden"
                                   name="id"
                                   value="' . $task->id . '">

                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm(\'Are you sure?\')">
                                Delete
                            </button>

                        </form>
                    ';
                }

                return $action;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    return view('task.view');
}

    public function editTask($id)
    {
        $data = Task::findOrFail($id);
        $user = auth()->user();
        $employees = Employee::where('company_id', $user->company_id)->get();

        return view('task.update', compact('data', 'employees'));
    }

    public function updateTask(Request $request, $id)
    {
        $validate = $request->validate([
            'title' => ['required', 'string', 'max:30'],
            'description' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string'],

            'employee_id' => ['required', 'integer', 'exists:employees,id'],
        ]);
        $data = Task::where('id', $id)->update($validate);

        return redirect()->route('task.read');

    }

    public function deleteTask(Request $request)
    {
        $data = Task::where('id', $request->id)->delete();
        return redirect()->route('task.read');

    }
}
