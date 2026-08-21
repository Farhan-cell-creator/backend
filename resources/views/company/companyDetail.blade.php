@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow-sm">

        {{-- Header --}}
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">My Company</h4>
                    <small class="text-muted">
                        Company information and details
                    </small>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body p-4">

            @if($company)

                <div class="row g-4">

                    {{-- Company Logo --}}
                    <div class="col-md-4 text-center">

                        <div class="mb-3">
                            <span class="fw-semibold text-muted">
                                Company Logo
                            </span>
                        </div>

                        @if($company->logo)

                            <div class="d-flex justify-content-center">
                                <div class="border rounded-3 p-3 bg-light">
                                    <img src="{{ $company->logo }}"
                                         alt="{{ $company->name }} Logo"
                                         class="img-fluid rounded"
                                         style="width: 160px; height: 160px; object-fit: contain;">
                                </div>
                            </div>

                        @else

                            <div class="border rounded-3 p-5 bg-light text-muted">
                                <div class="fs-1 mb-2">🏢</div>
                                <span>No logo available</span>
                            </div>

                        @endif

                    </div>


                    {{-- Company Details --}}
                    <div class="col-md-8">

                        <div class="mb-4">
                            <label class="text-muted small fw-semibold">
                                COMPANY NAME
                            </label>

                            <div class="mt-1 fs-5 fw-bold">
                                {{ $company->name }}
                            </div>
                        </div>


                        <div class="mb-4">
                            <label class="text-muted small fw-semibold">
                                COMPANY EMAIL
                            </label>

                            <div class="mt-1">
                                <a href="mailto:{{ $company->email }}"
                                   class="text-decoration-none">
                                    {{ $company->email }}
                                </a>
                            </div>
                        </div>


                        {{-- Status --}}
                        <div class="mb-3">
                            <label class="text-muted small fw-semibold">
                                STATUS
                            </label>

                            <div class="mt-2">
                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                    Active
                                </span>
                            </div>
                        </div>

                    </div>

                </div>

            @else

                {{-- Empty State --}}
                <div class="text-center py-5">

                    <div class="fs-1 mb-3">
                        🏢
                    </div>

                    <h5 class="fw-bold">
                        Company Not Found
                    </h5>

                    <p class="text-muted mb-0">
                        We couldn't find any company information associated
                        with your account.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection