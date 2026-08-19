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
        // lengthMenu: [5, 10, 15, 100],

        // ajax: "{{ route('company.read') }}",
        ajax: {
            url: "{{ route('company.read') }}",
            type: "GET",
            dataSrc: function (json) {
                console.log('Raw response:', json);
                console.log('Data array:', json.data);
                return json.data; 
            },
            error: function (xhr, error, thrown) {
                console.log('AJAX failed. Status:', xhr.status);
                console.log('Error thrown:', thrown);
                console.log('Raw server response:', xhr.responseText);
            }
        },

       

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