@extends('layouts.app')

@section('content')

<div class="card">

    <div class="card-header">
        <h4 class="mb-0">Update Task</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('task.update', $data->id) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- Task Title --}}
            <div class="mb-3">

                <label class="form-label">Title</label>

                <input type="text"
                       name="title"
                       class="form-control"
                       placeholder="Enter Task Title"
                       value="{{ $data->title }}">

            </div>


            {{-- Task Description --}}
            <div class="mb-3">

                <label class="form-label">Description</label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="4"
                    placeholder="Enter Task Description">{{ $data->description }}</textarea>

            </div>


            {{-- Task Status --}}
            <div class="mb-3">

                <label class="form-label">Status</label>

                <input type="text"
                       name="status"
                       class="form-control"
                       placeholder="Enter Status"
                       value="{{ $data->status }}">

            </div>


            {{-- Employee --}}
            <div class="mb-3">

                <label class="form-label">Employee</label>

                <select name="employee_id" class="form-select">

                    <option value="">
                        Select Employee
                    </option>

                    @foreach($employees as $employee)

                        <option value="{{ $employee->id }}"
                            {{ $data->employee_id == $employee->id ? 'selected' : '' }}>

                            {{ $employee->first_name }}
                            {{ $employee->last_name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Update Button --}}
            <button type="submit" class="btn btn-dark">
                Update Task
            </button>


            {{-- Back Button --}}
            <a href="{{ route('task.read') }}"
               class="btn btn-secondary">
                View Task
            </a>

        </form>

    </div>

</div>

@endsection