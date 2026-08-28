@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Credentials</h4>
        <a href="{{ route('credential.index') }}"
           class="btn"
           style="background-color: black; color: white;">
            Create Credential
        </a>
    </div>
    <div class="card-body">
        <table id="credential-table"
               class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function () {
    $('#credential-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('credential.read') }}",
            type: "GET",
            error: function (xhr) {
                console.log("STATUS:", xhr.status);
                console.log("RESPONSE:", xhr.responseText);
            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'value',
                name: 'value'
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