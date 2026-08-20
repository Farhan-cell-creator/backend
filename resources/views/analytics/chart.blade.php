@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Analytics Dashboard</h2>
            <p class="text-muted mb-0">
                Employee statistics and company overview
            </p>
        </div>
    </div>
    {{-- Grouped Bar Chart for Employees by Company --}}
    <div class="row g-4">
        <div class="col-lg-7 col-md-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">
                        Employees by Company
                    </h5>
                    <small class="text-muted">
                        Total employees in each company
                    </small>
                </div>
                <div class="card-body px-4 pb-4">
                    <div style="height: 400px; position: relative;">
                        <canvas id="companyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>  
         {{-- Pie Chart for Employee Gender --}}    
        <div class="col-lg-5 col-md-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-1">
                        Employee Gender
                    </h5>
                    <small class="text-muted">
                        Male and female employee percentage
                    </small>
                </div>
                <div class="card-body px-4 pb-4 d-flex align-items-center justify-content-center">
                    <div style="height: 350px; width: 100%; position: relative;">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const companies = @json($companies);
    const companyNames = companies.map(company => company.name);
    const employeeCounts = companies.map(
        company => company.employees_count
    );
    new Chart(document.getElementById('companyChart'), {
        type: 'bar',
        data: {
            labels: companyNames,
            datasets: [{
                label: 'Total Employees',
                data: employeeCounts,
                borderWidth: 1,
                borderRadius: 6,
                barThickness: 35
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                  suggestedMax: Math.max(...employeeCounts) + 10,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    const male = {{ $male }};
    const female = {{ $female }};
    const total = male + female;
    new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: {
            labels: [
                'Male',
                'Female'
            ],
            datasets: [{
                data: [
                    male,
                    female
                ],
                borderWidth: 3,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const percentage = total > 0
                                ? ((value / total) * 100).toFixed(1)
                                : 0;
                            return context.label
                                + ': '
                                + percentage
                                + '%';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush