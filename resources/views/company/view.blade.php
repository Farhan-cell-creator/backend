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

            <table id="company-table"
                   class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Logo</th>
                        <th>Action</th>
                    </tr>

                </thead>

            </table>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

$(document).ready(function () {

    $('#company-table').DataTable({

        processing: true,

        serverSide: true,

        pageLength: 6,
        lengthMenu: [5, 10, 15, 20],

        ajax: "{{ route('company.read') }}",
//         ajax: {
//     url: "{{ route('company.read') }}",
//     type: "GET",
//     dataSrc: function (json) {
//         console.log("DataTable Response:", json);
//         return json.data;
//     },
//     error: function (xhr) {
//         console.log("DataTable Error:", xhr.status);
//         console.log(xhr.responseText);
//     }
// },

        columns: [

            {
                data: 'id',
                name: 'id'
            },

            {
                data: 'name',
                name: 'name'
            },

            {
                data: 'email',
                name: 'email'
            },

            {
                data: 'logo',
                name: 'logo',
                orderable: false,
                searchable: false
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]

    });

});

</script>

@endpush