@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Company Create</h4>
    </div>
    {{-- Company form --}}
    <div class="card-body">
        <form action="{{ route('company.create') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
           {{-- Company Name --}}
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Enter company name"
                       required>
            </div>
              {{-- Company Email --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter company email"
                       required>
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
            <div class="mb-3">
                <label class="form-label">User Name</label>
                <input type="text"
                  name="user_name"
                  class="form-control"
                  placeholder="Enter User Name"
                  required>
            </div>
           
              {{-- Company Logo --}}
            <div class="mb-3">
                <label class="form-label">Company Logo</label>
                <input type="file"
                       name="logo"
                       class="form-control"
                       accept="image/*"
                       required>
            </div>
              {{--Company Button --}}
            <button type="submit" class="btn btn-dark">
                Add Company
            </button>
            {{-- View Company button --}}
            <a href="{{ route('company.read') }}"
               class="btn btn-secondary">
                View Companies
            </a>
        </form>
    </div>
</div>
@endsection