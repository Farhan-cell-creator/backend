@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
     <h4 class="mb-0">Employee Create</h4>
    </div>
      {{--Employee form --}}
    <div class="card-body">
        <form action="{{ route('employee.create') }}" method="POST">
            @csrf
              {{-- Employee First Name --}}
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text"
                       name="first_name"
                       class="form-control"
                       placeholder="Enter Employee First name">
            </div>
            {{-- Employee Last Name --}}
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text"
                       name="last_name"
                       class="form-control"
                       placeholder="Enter Employee Last Name">
            </div>
            {{-- Employee Email --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter Email">
            </div>
             {{-- Password --}}
             <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password"
                  name="password"
                  class="form-control"
                  placeholder="Enter User Password"
                  required>
            </div>
            {{-- Employee Phone no --}}
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text"
                       name="phone"
                       class="form-control"
                       placeholder="Enter Phone Number">
            </div>
            {{-- Employee Gender --}}
             <div class="mb-3">
                <label class="form-label">Gender</label>
                <input type="text"
                       name="gender"
                       class="form-control"
                       placeholder="Enter  Gender">
            </div>
            {{-- Employee Select Company --}}
            <div class="mb-3">
    <label class="form-label">Company</label>
    <select name="company_id" class="form-select">
        <option value="">Select Company</option>
        {{-- List Company --}}
        @foreach($companies as $company)
            <option value="{{ $company->id }}">
                {{ $company->name }}
            </option>
        @endforeach
    </select>
</div>
{{-- Create  Employee Button --}}
            <button type="submit" class="btn btn-dark">
                Add Employee
            </button>
            {{--View  Employee --}}
            <a href="{{ route('employee.read') }}"
               class="btn btn-secondary">
                View Employee
            </a>
        </form>
    </div>
</div>
@endsection