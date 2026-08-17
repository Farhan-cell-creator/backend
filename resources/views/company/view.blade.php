@extends('layouts.app')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Companies</h4>

        <a href="{{ route('company.index') }}" class="btn btn-dark">
            Create Company
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Logo</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $company)

                        <tr>
                            <td>{{ $company->id }}</td>

                            <td>{{ $company->name }}</td>

                            <td>{{ $company->email }}</td>

                            <td>
                                <img
                                    src="{{ $company->logo }}"
                                    width="60"
                                    height="60"
                                    style="object-fit: contain;"
                                    alt="Logo"
                                >
                            </td>

                            <td>

                               
                              <a href="{{ route('company.edit', ['id' => $company->id]) }}"
   class="btn btn-sm btn-primary">
    Edit
</a>

                                
<form action="{{ route('company.delete') }}"
      method="POST"
      class="d-inline">

    @csrf
    @method('DELETE')

    <input type="hidden" name="id" value="{{ $company->id }}">

    <button
        type="submit"
        class="btn btn-sm btn-danger"
        onclick="return confirm('Are you sure you want to delete this company?')"
    >
        Delete
    </button>

</form>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                No companies found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection