@extends('layouts.app')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">Employees</h4>

        <a href="{{ route('employee.index') }}"
           class="btn btn-dark">
            Create Employee
        </a>

    </div>


    <div class="card-body">

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        <div class="table-responsive">

            <table id="employee-table"
                   class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Company</th>
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

    $('#employee-table').DataTable({

        processing: true,

        serverSide: true,

        pageLength: 20,

        lengthMenu: [5, 10, 15, 20],

        ajax: "{{ route('employee.read') }}",

        columns: [

            {
                data: 'id',
                name: 'id'
            },

            {
                data: 'first_name',
                name: 'first_name'
            },

            {
                data: 'last_name',
                name: 'last_name'
            },
             {
                data: 'gender',
                name: 'gender'
            },

            {
                data: 'email',
                name: 'email'
            },

            {
                data: 'company_id',
                name: 'company_id'
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