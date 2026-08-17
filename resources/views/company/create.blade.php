@extends('layouts.app')

@section('content')

<div class="card">

    <div class="card-header">
        <h4 class="mb-0">Company Create</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('company.create') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label">Company Name</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Enter company name">
            </div>


            <div class="mb-3">
                <label class="form-label">Email</label>

                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter company email">
            </div>


            <div class="mb-3">
                <label class="form-label">Logo URL</label>

                <input type="url"
                       name="logo"
                       class="form-control"
                       placeholder="Enter logo URL">
            </div>


            <button type="submit" class="btn btn-dark">
                Create Company
            </button>

            <a href="{{ route('company.read') }}"
               class="btn btn-secondary">

                View Companies

            </a>

        </form>

    </div>

</div>

@endsection