@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
     <h4 class="mb-0">Task Create</h4>
    </div>
      {{--Task form --}}
    <div class="card-body">
        <form action="{{ route('task.create') }}" method="POST">
            @csrf
              {{-- Task Title --}}
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       placeholder="Enter Task Title">
            </div>
           
            {{-- Task Description --}}
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea
        name="description"
        class="form-control"
        rows="4"
        placeholder="Enter Task Description"></textarea>
</div>
           
            {{-- Task Status --}}
             <div class="mb-3">
                <label class="form-label">Status</label>
                <input type="text"
                       name="status"
                       class="form-control"
                       placeholder="Enter  Status">
            </div>
            {{--  Select Task --}}
          <div class="mb-3">
    <label class="form-label">Employee</label>

    <select name="employee_id" class="form-select">
        <option value="">Select Employee</option>

        @foreach($employees as $employee)
            <option value="{{ $employee->id }}">
                {{ $employee->first_name }} {{ $employee->last_name }}
            </option>
        @endforeach
    </select>
</div>
{{-- Create  Task Button --}}
            <button type="submit" class="btn btn-dark">
                Create Task
            </button>
            {{--View  Task --}}
            <a href="{{ route('task.read') }}"
               class="btn btn-secondary">
                View Task
            </a>
        </form>
    </div>
</div>
@endsection