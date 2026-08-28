@extends('layouts.app')
@section('content')
<div style="margin: 0 10px;">
    <div class="card">
        <div class="card-header">
            Update Credential
        </div>
        <div class="card-body">
            <form action="{{ route('credential.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="credential_name" class="form-label">
                        Credential Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="credential_name"
                        class="form-control"
                        placeholder="Enter credential name"
                        value="{{ $data->name }}"
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="credential_value" class="form-label">
                        Credential Value
                    </label>
                    <input
                        type="text"
                        name="value"
                        id="credential_value"
                        class="form-control"
                        placeholder="Enter credential value"
                        value="{{ $data->value }}"
                        required
                    >
                </div>
                <button type="submit"
                        class="btn"
                        style="background-color: black; color: white;">
                    Update Credential
                </button>
                <a href="{{ route('credential.read') }}"
                   class="btn"
                   style="background-color: black; color: white;">
                    View Credential
                </a>
            </form>
        </div>
    </div>
</div>
@endsection