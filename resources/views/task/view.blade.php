@extends('layouts.app')

@section('content')

<div class="card">


@can('task-create')
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Tasks</h4>

        <a href="{{ route('task.index') }}"
           class="btn btn-dark">
            Create Task
        </a>
    </div>
    @endcan

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row mb-4">

            <div class="col-md-3">
                <label for="from_date" class="form-label">
                    From Date
                </label>

                <input type="date"
                       id="from_date"
                       class="form-control">
            </div>

            <div class="col-md-3">
                <label for="to_date" class="form-label">
                    To Date
                </label>

                <input type="date"
                       id="to_date"
                       class="form-control">
            </div>

            <div class="col-md-3 d-flex align-items-end">

                <button type="button"
                        id="filter-date"
                        class="btn btn-primary me-2">
                    Filter
                </button>

                <button type="button"
                        id="reset-date"
                        class="btn btn-secondary">
                    Reset
                </button>

            </div>

        </div>

        <div class="table-responsive">

            <table id="task-table"
                   class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Employee ID</th>
                        <th>Status</th>
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

    console.log('Task DataTable JS running');

    let table = $('#task-table').DataTable({

        processing: true,

        serverSide: true,

        ajax: {
            url: "{{ route('task.read') }}",
            type: "GET",

            data: function (d) {
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            },

            error: function (xhr) {
                console.log('AJAX Error:', xhr.status);
                console.log(xhr.responseText);
            }
        },

        columns: [

            {
                data: 'id',
                name: 'id'
            },

            {
                data: 'title',
                name: 'title'
            },

            {
                data: 'description',
                name: 'description'
            },

            {
                data: 'employee_id',
                name: 'employee_id'
            },

            {
                data: 'status',
                name: 'status'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]

    });


    // Filter

    $('#filter-date').click(function () {

        table.ajax.reload();

    });


    // Reset

    $('#reset-date').click(function () {

        $('#from_date').val('');

        $('#to_date').val('');

        table.ajax.reload();

    });

});

</script>

@endpush