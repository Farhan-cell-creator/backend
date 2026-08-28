@extends('layouts.app')

@section('content')

<div class="card">

    {{-- Header --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Credentials</h4>

        <a href="{{ route('credential.index') }}" class="btn btn-dark">
            Add Credential
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Yajra Table --}}
        <div class="table-responsive">
            <table id="credential-table"
                   class="table table-bordered table-hover">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Credential Name</th>
                        <th>Credential Value</th>
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

    let table = $('#credential-table').DataTable({

        processing: true,
        serverSide: true,
        pageLength: 6,

        ajax: {
            url: "{{ route('credential.read') }}",
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