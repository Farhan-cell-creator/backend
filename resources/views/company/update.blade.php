@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Company Update</h4>
    </div>
    {{--Update Company form --}}
    <div class="card-body">
        <form action="{{ route('company.update', ['id' => $result->id]) }}"
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
                       value="{{ old('name', $result->name) }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
             {{-- Company Email --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter company email"
                       value="{{ old('email', $result->email) }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
             {{-- View Company Logo --}}
            <div class="mb-3">
                <label class="form-label">Current Company Logo</label>
                @if($result->logo)
                    <div class="mb-2">
                        <img src="{{ $result->logo }}"
                             alt="Company Logo"
                             width="100"
                             height="100"
                             style="object-fit: cover;">
                    </div>
                @endif
                 {{-- Choose Company Logo --}}
                <label class="form-label">Choose New Logo</label>
                <input type="file"
                       name="logo"
                       class="form-control"
                       accept="image/*">
                @error('logo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
             {{-- Update Company Button --}}
            <button type="submit" class="btn btn-dark">
                Update Company
            </button>
            {{-- View Company Button --}}
            <a href="{{ route('company.read') }}"
               class="btn btn-secondary">
                View Companies
            </a>
        </form>
    </div>
</div>
@endsection