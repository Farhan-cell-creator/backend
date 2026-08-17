@extends('layouts.app')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Employees</h4>

        <a href="{{ route('employee.index') }}" class="btn btn-dark">
            Create Employee
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Company</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $employee)

                        <tr>
                            <td>{{ $employee->id }}</td>

                            <td>{{ $employee->first_name }}</td>

                            <td>{{ $employee->last_name }}</td>

                            <td>{{ $employee->email }}</td>

                            <td>{{ $employee->phone }}</td>

                            <td>{{ $employee->gender }}</td>

                            <td>{{ $employee->company_id }}</td>

                            <td>

                                <a href="{{ route('employee.edit', ['id' => $employee->id]) }}"
                                   class="btn btn-sm btn-primary">
                                    Edit
                                </a>

                                <form action="{{ route('employee.delete') }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <input type="hidden"
                                           name="id"
                                           value="{{ $employee->id }}">

                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this employee?')">
                                        Delete
                                    </button>

                                </form>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                No employees found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection