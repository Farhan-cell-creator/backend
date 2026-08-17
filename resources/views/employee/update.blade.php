@extends('layouts.app')

@section('content')

<div class="card">

    <div class="card-header">
        <h4 class="mb-0">Employee Create</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('employee.update',['id' => $data->id]) }}" method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label">First Name</label>

                <input type="text"
                       name="first_name"
                       class="form-control"
                       placeholder="Enter Employee First name"
                       value={{ $data->first_name }}>
            </div>


            <div class="mb-3">
                <label class="form-label">Last Name</label>

                <input type="text"
                       name="last_name"
                       class="form-control"
                       placeholder="Enter Employee Last Name"
                       value={{ $data->last_name }}>
            </div>


            <div class="mb-3">
                <label class="form-label">Email</label>

                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter Email"
                       value={{ $data->email }}>
            </div>
           
            
            <div class="mb-3">
                <label class="form-label">Phone</label>

                <input type="text"
                       name="phone"
                       class="form-control"
                       placeholder="Enter Phone Number"
                       value={{ $data->phone }}>

            </div>
             <div class="mb-3">
                <label class="form-label">Gender</label>

                <input type="text"
                       name="gender"
                       class="form-control"
                       placeholder="Enter  Gender"
                       value={{ $data->gender }}>
            </div>
            <div class="mb-3">
    <label class="form-label">Company</label>
    <select name="company_id" class="form-select">
    <option value="">Select Company</option>

    @foreach($company as $companies)
        <option value="{{ $companies->id }}"
            {{ $data->company_id == $companies->id ? 'selected' : '' }}>
            {{ $companies->name }}
        </option>
    @endforeach
</select>

    
</div>


            <button type="submit" class="btn btn-dark">
                Update Employee
            </button>

            <a href="{{ route('employee.read') }}"
               class="btn btn-secondary">

                View Employee

            </a>

        </form>

    </div>

</div>

@endsection