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
        {{-- Select From Date--}}
         <div class="row mb-4">
            <div class="col-md-3">
                <label for="from_date" class="form-label">
                    From Date
                </label>
                <input type="date"
                       id="from_date"
                       class="form-control">
            </div>
             {{-- Select To Date--}}
            <div class="col-md-3">
                <label for="to_date" class="form-label">
                    To Date
                </label>
                <input type="date"
                       id="to_date"
                       class="form-control">
            </div>
             {{-- Set Filter Button--}}
             <div class="col-md-3 d-flex align-items-end">
                <button type="button"
                        id="filter-date"
                        class="btn btn-primary me-2">
                    Filter
                </button>
            {{-- Reset Filter Button--}}  
                <button type="button"
                        id="reset-date"
                        class="btn btn-secondary">
                    Reset
                </button>
            </div>
            {{-- Table --}}
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
    let table = $('#employee-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 20,
        ajax: {
            url: "{{ route('employee.read') }}",
            type: "GET",
            data: function (d) {
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            },
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
    $('#filter-date').click(function () {
        table.ajax.reload();
    });
    $('#reset-date').click(function () {
        $('#from_date').val('');
        $('#to_date').val('');
        table.ajax.reload();
    });
});
</script>
@endpush