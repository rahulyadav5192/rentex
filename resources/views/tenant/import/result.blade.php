@extends('layouts.app')

@section('page-title')
    {{ __('Import Complete') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tenant.index') }}">{{ __('Tenant') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Import Result') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Step 6: Import Results') }}</h5>
            </div>
            <div class="card-body">
                @php
                    $tenantsCreated = $importResult['tenants_created'] ?? 0;
                    $rowsSkipped = $importResult['rows_skipped'] ?? 0;
                    $skipReasons = $importResult['skip_reasons'] ?? [];
                @endphp

                <div class="alert alert-success">
                    <i class="ti ti-check-circle me-2"></i>
                    <strong>{{ __('Import completed successfully!') }}</strong>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h2 class="text-success mb-2">{{ $tenantsCreated }}</h2>
                                <p class="mb-0 text-muted">{{ __('Tenants Created') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h2 class="text-warning mb-2">{{ $rowsSkipped }}</h2>
                                <p class="mb-0 text-muted">{{ __('Rows Skipped') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($rowsSkipped > 0 && !empty($skipReasons))
                    <div class="alert alert-warning">
                        <i class="ti ti-alert-triangle me-2"></i>
                        <strong>{{ __('Note:') }}</strong> {{ __('Some rows were skipped:') }}
                        <ul class="mb-0 mt-2">
                            @foreach($skipReasons as $reason)
                                <li>{{ __('Row') }} {{ $reason['row'] }} - {{ $reason['tenant'] }}: {{ $reason['reason'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('tenant.index') }}" class="btn btn-primary">
                        <i class="ti ti-list me-2"></i>{{ __('View Tenants') }}
                    </a>
                    <a href="{{ route('tenant.import.index') }}" class="btn btn-secondary">
                        <i class="ti ti-upload me-2"></i>{{ __('Import Another File') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

