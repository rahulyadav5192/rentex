@extends('layouts.app')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Dashboard') }}</li>
@endsection

@push('head-page')
    <style>
        .dashboard-modern .stat-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            height: 100%;
        }
        .dashboard-modern .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        }
        .dashboard-modern .stat-card .card-body {
            display: flex;
            align-items: center;
            height: 100%;
        }
        .dashboard-modern .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            color: #fff;
            flex-shrink: 0;
        }
        .dashboard-modern .stat-card h4 {
            color: #000;
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
            line-height: 1.2;
        }
        .dashboard-modern .stat-card p {
            color: #666;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }
        .dashboard-modern .stat-card .flex-grow-1 {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .dashboard-modern .chart-card {
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .dashboard-modern .chart-card .card-header {
            background: transparent;
            border-bottom: 2px solid #000;
            padding: 1.5rem 0;
        }
        .dashboard-modern .chart-card h5 {
            color: #000;
            font-weight: 700;
            margin: 0;
        }
        .dashboard-modern .chart-card .text-muted {
            color: #666;
        }
    </style>
@endpush

@push('script-page')
<script>
    var options = {
        chart: {
            type: 'area',
            height: 450,
            toolbar: {
                show: false
            }
        },
        colors: ['#000000', '#666666'],
        dataLabels: {
            enabled: false
        },
        legend: {
            show: true,
            position: 'top',
            labels: {
                colors: ['#000', '#666']
            }
        },
        markers: {
            size: 1,
            colors: ['#fff', '#fff', '#fff'],
            strokeColors: ['#000', '#666'],
            strokeWidth: 2,
            shape: 'circle',
            hover: {
                size: 5
            }
        },
        stroke: {
            width: 2,
            curve: 'smooth'
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                type: 'vertical',
                inverseColors: false,
                opacityFrom: 0.3,
                opacityTo: 0.05,
                stops: [0, 100]
            }
        },
        grid: {
            show: true,
            borderColor: '#e0e0e0',
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        series: [{
                name: "{{ __('Total Income') }}",
                data: {!! json_encode($result['incomeExpenseByMonth']['income']) !!}
            },
            {
                name: "{{ __('Total Expense') }}",
                data: {!! json_encode($result['incomeExpenseByMonth']['expense']) !!}
            }
        ],
        xaxis: {
            categories: {!! json_encode($result['incomeExpenseByMonth']['label']) !!},
            tooltip: {
                enabled: false
            },
            labels: {
                hideOverlappingLabels: true,
                style: {
                    colors: '#666'
                }
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#666'
                }
            }
        },
        tooltip: {
            theme: 'light',
            style: {
                fontSize: '12px'
            }
        }
    };
    var chart = new ApexCharts(document.querySelector('#incomeExpense'), options);
    chart.render();

</script>
@endpush

@php
    $settings = settings();
@endphp

@section('content')
    <div class="row dashboard-modern">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon">
                                <i class="ti ti-building" style="font-size: 28px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Property') }}</p>
                            <h4 class="mb-0">{{ $result['totalProperty'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon">
                                <i class="ti ti-3d-cube-sphere" style="font-size: 28px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Unit') }}</p>
                            <h4 class="mb-0">{{ $result['totalUnit'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon">
                                <i class="ti ti-file-invoice" style="font-size: 28px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Invoice') }}</p>
                            <h4 class="mb-0">{{ $settings['CURRENCY_SYMBOL'] }}<span class="count">{{ $result['totalIncome'] }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon">
                                <i class="ti ti-exposure" style="font-size: 28px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Expense') }}</p>
                            <h4 class="mb-0">{{ $settings['CURRENCY_SYMBOL'] }}<span class="count">{{ $result['totalExpense'] }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon">
                                <i class="ti ti-users" style="font-size: 28px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Tenants') }}</p>
                            <h4 class="mb-0">{{ $result['totalTenant'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon">
                                <i class="ti ti-user-circle" style="font-size: 28px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Staff/Users') }}</p>
                            <h4 class="mb-0">{{ $result['totalStaff'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon">
                                <i class="ti ti-tools" style="font-size: 28px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Maintainers') }}</p>
                            <h4 class="mb-0">{{ $result['totalMaintainer'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stat-icon">
                                <i class="ti ti-mail" style="font-size: 28px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Enquiry') }}</p>
                            <h4 class="mb-0">{{ $result['totalEnquiry'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12 col-md-12">
            <div class="card chart-card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="card-header mb-4">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <h5 class="mb-1">{{ __('Analysis Report') }}</h5>
                                <p class="text-muted mb-0">{{ __('Income and Expense Overview') }}</p>
                            </div>
                        </div>
                    </div>
                    <div id="incomeExpense"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
