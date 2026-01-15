@extends('layouts.app')

@section('page-title')
    {{ __('Auto Invoice Management') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Auto Invoice Management') }}</li>
@endsection

@push('script-page')
<script>
    $(document).ready(function() {
        // Generate invoices for a specific owner
        $('.generate-invoices-btn').on('click', function() {
            const ownerId = $(this).data('owner-id');
            const ownerName = $(this).data('owner-name');
            
            if (!confirm('Are you sure you want to generate invoices for ' + ownerName + '?')) {
                return;
            }

            $.ajax({
                url: '{{ route("admin.auto.invoice.generate", ":id") }}'.replace(':id', ownerId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                beforeSend: function() {
                    $('.generate-invoices-btn[data-owner-id="' + ownerId + '"]').prop('disabled', true).text('Generating...');
                },
                success: function(response) {
                    if (response.success) {
                        toastrs('Success', response.message, 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        toastrs('Error', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    toastrs('Error', xhr.responseJSON?.message || 'Failed to generate invoices', 'error');
                },
                complete: function() {
                    $('.generate-invoices-btn[data-owner-id="' + ownerId + '"]').prop('disabled', false).text('Generate Now');
                }
            });
        });
    });
</script>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-primary">
                                    <i class="ti ti-users f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Total Owners') }}</p>
                                <h4 class="mb-0">{{ $stats['total_owners'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-success">
                                    <i class="ti ti-check f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Owners with Auto-Invoice') }}</p>
                                <h4 class="mb-0">{{ $stats['owners_with_auto_invoice'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-info">
                                    <i class="ti ti-home f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Properties Enabled') }}</p>
                                <h4 class="mb-0">{{ $stats['total_properties_enabled'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-warning">
                                    <i class="ti ti-building f-24"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">{{ __('Units Enabled') }}</p>
                                <h4 class="mb-0">{{ $stats['total_units_enabled'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Owners with Auto-Invoice Enabled -->
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Owners with Auto-Invoice Enabled') }}</h5>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.auto.invoice.logs') }}" class="btn btn-secondary">
                            <i class="ti ti-file-text align-text-bottom"></i> {{ __('View All Logs') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(count($propertiesByOwner) > 0)
                    @foreach($propertiesByOwner as $ownerData)
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="mb-0">{{ $ownerData['owner']->name }}</h6>
                                        <small class="text-muted">{{ $ownerData['owner']->email }}</small>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-sm btn-primary generate-invoices-btn"
                                            data-owner-id="{{ $ownerData['owner']->id }}"
                                            data-owner-name="{{ $ownerData['owner']->name }}">
                                            <i class="ti ti-check align-text-bottom"></i> {{ __('Generate Now') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Property Name') }}</th>
                                                <th>{{ __('Generation Day') }}</th>
                                                <th>{{ __('Eligible Units') }}</th>
                                                <th>{{ __('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ownerData['properties'] as $property)
                                                <tr>
                                                    <td>{{ $property->name }}</td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            {{ $property->invoice_generation_day ?? 1 }}{{ $property->invoice_generation_day == 1 ? 'st' : ($property->invoice_generation_day == 2 ? 'nd' : ($property->invoice_generation_day == 3 ? 'rd' : 'th')) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $property->total_units_count ?? 0 }}</td>
                                                    <td>
                                                        @if($property->auto_invoice_enabled)
                                                            <span class="badge bg-success">{{ __('Enabled') }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ __('Disabled') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        {{ __('No owners have auto-invoice enabled yet.') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

