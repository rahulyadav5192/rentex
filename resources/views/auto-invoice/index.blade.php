@extends('layouts.app')

@section('page-title')
    {{ __('Auto Invoice Settings') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Auto Invoice Settings') }}</li>
@endsection

@push('script-page')
<script>
    $(document).ready(function() {
        // Global settings toggle
        $('#global_auto_invoice_enabled').on('change', function() {
            const isEnabled = $(this).is(':checked');
            updateGlobalSettings(isEnabled);
        });

        $('#global_invoice_generation_day').on('change', function() {
            updateGlobalSettings(null);
        });

        function updateGlobalSettings(enableAll) {
            $.ajax({
                url: '{{ route("auto.invoice.global.settings") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    auto_invoice_enabled: $('#global_auto_invoice_enabled').is(':checked') ? 1 : 0,
                    invoice_generation_day: $('#global_invoice_generation_day').val(),
                },
                success: function(response) {
                    if (response.success) {
                        toastrs('Success', response.message, 'success');
                        
                        // Update UI immediately if global toggle changed
                        const isGlobalEnabled = $('#global_auto_invoice_enabled').is(':checked');
                        if (enableAll !== null) {
                            // Update all property toggles
                            $('.property-auto-invoice-toggle').prop('checked', isGlobalEnabled);
                            
                            // Update all unit toggles (only for occupied units that aren't disabled)
                            $('.unit-auto-invoice-toggle').each(function() {
                                if (!$(this).prop('disabled')) {
                                    $(this).prop('checked', isGlobalEnabled);
                                }
                            });
                        }
                        
                        // Reload after a short delay to ensure UI is updated
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }
                },
                error: function(xhr) {
                    toastrs('Error', xhr.responseJSON?.message || 'Failed to update settings', 'error');
                }
            });
        }

        // Property settings
        $('.property-auto-invoice-toggle').on('change', function() {
            const propertyId = $(this).data('property-id');
            updatePropertySettings(propertyId);
        });

        $('.property-generation-day').on('change', function() {
            const propertyId = $(this).data('property-id');
            updatePropertySettings(propertyId);
        });

        function updatePropertySettings(propertyId) {
            const enabled = $(`.property-auto-invoice-toggle[data-property-id="${propertyId}"]`).is(':checked') ? 1 : 0;
            const day = $(`.property-generation-day[data-property-id="${propertyId}"]`).val();

            $.ajax({
                url: `/auto-invoice/property/${propertyId}/settings`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    auto_invoice_enabled: enabled,
                    invoice_generation_day: day,
                },
                success: function(response) {
                    if (response.success) {
                        toastrs('Success', response.message, 'success');
                    }
                },
                error: function(xhr) {
                    toastrs('Error', xhr.responseJSON?.message || 'Failed to update property settings', 'error');
                }
            });
        }

        // Unit settings
        $('.unit-auto-invoice-toggle').on('change', function() {
            const unitId = $(this).data('unit-id');
            updateUnitSettings(unitId);
        });

        $('.unit-invoice-type').on('change', function() {
            const unitId = $(this).data('unit-id');
            updateUnitSettings(unitId);
        });

        function updateUnitSettings(unitId) {
            const enabled = $(`.unit-auto-invoice-toggle[data-unit-id="${unitId}"]`).is(':checked') ? 1 : 0;
            const typeId = $(`.unit-invoice-type[data-unit-id="${unitId}"]`).val();

            $.ajax({
                url: `/auto-invoice/unit/${unitId}/settings`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    auto_invoice_enabled: enabled,
                    default_invoice_type_id: typeId || null,
                },
                success: function(response) {
                    if (response.success) {
                        toastrs('Success', response.message, 'success');
                    }
                },
                error: function(xhr) {
                    toastrs('Error', xhr.responseJSON?.message || 'Failed to update unit settings', 'error');
                }
            });
        }

        // Preview invoices
        $('#preview_invoices').on('click', function() {
            const month = $('#preview_month').val();
            $.ajax({
                url: '{{ route("auto.invoice.preview") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    month: month,
                },
                beforeSend: function() {
                    $('#preview_invoices').prop('disabled', true).text('Loading...');
                },
                success: function(response) {
                    if (response.success) {
                        displayPreview(response.data);
                    }
                },
                error: function(xhr) {
                    toastrs('Error', xhr.responseJSON?.message || 'Failed to preview invoices', 'error');
                },
                complete: function() {
                    $('#preview_invoices').prop('disabled', false).text('Preview Invoices');
                }
            });
        });

        // Generate invoices
        $('#generate_invoices').on('click', function() {
            if (!confirm('Are you sure you want to generate invoices? This action cannot be undone.')) {
                return;
            }

            const month = $('#preview_month').val();
            $.ajax({
                url: '{{ route("auto.invoice.generate") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    month: month,
                },
                beforeSend: function() {
                    $('#generate_invoices').prop('disabled', true).text('Generating...');
                },
                success: function(response) {
                    if (response.success) {
                        toastrs('Success', response.message, 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    toastrs('Error', xhr.responseJSON?.message || 'Failed to generate invoices', 'error');
                },
                complete: function() {
                    $('#generate_invoices').prop('disabled', false).text('Generate Invoices Now');
                }
            });
        });

        function displayPreview(data) {
            let html = '';
            
            // Show summary information
            if (data.summary) {
                html += '<div class="alert alert-info mb-3">';
                html += '<h6><strong>Summary:</strong></h6>';
                html += '<ul class="mb-0">';
                html += '<li>Total Own Properties: ' + (data.summary.properties_checked || 0) + '</li>';
                html += '<li>Properties with Auto-Invoice Enabled: ' + (data.summary.properties_enabled || 0) + '</li>';
                html += '<li>Total Units in Enabled Properties: ' + (data.summary.total_units || 0) + '</li>';
                html += '<li>Eligible Units (enabled + occupied + rent > 0): ' + (data.summary.eligible_units || 0) + '</li>';
                html += '</ul>';
                html += '</div>';
            }

            // Show errors/warnings
            if (data.errors && data.errors.length > 0) {
                html += '<div class="alert alert-warning mb-3">';
                html += '<h6><strong>Issues Found:</strong></h6>';
                html += '<ul class="mb-0">';
                data.errors.forEach(function(error) {
                    html += '<li>' + error + '</li>';
                });
                html += '</ul>';
                html += '</div>';
            }

            // Show invoices to be created
            if (data.created_details && data.created_details.length > 0) {
                html += '<h6 class="mt-3"><strong>Invoices to be Created:</strong></h6>';
                html += '<div class="table-responsive"><table class="table table-bordered"><thead><tr>';
                html += '<th>Property</th><th>Unit</th><th>Amount</th><th>Invoice Month</th>';
                html += '</tr></thead><tbody>';

                data.created_details.forEach(function(item) {
                    html += '<tr>';
                    html += '<td>' + (item.property_name || '-') + '</td>';
                    html += '<td>' + (item.unit_name || '-') + '</td>';
                    html += '<td>' + (item.amount || '0.00') + '</td>';
                    html += '<td>' + (item.invoice_month || '-') + '</td>';
                    html += '</tr>';
                });

                html += '</tbody></table></div>';
            }

            // Show skipped units (why they won't be generated)
            if (data.skipped_details && data.skipped_details.length > 0) {
                html += '<h6 class="mt-3"><strong>Units Skipped (and reasons):</strong></h6>';
                html += '<div class="table-responsive"><table class="table table-bordered table-sm"><thead><tr>';
                html += '<th>Property</th><th>Unit</th><th>Reason</th>';
                html += '</tr></thead><tbody>';

                data.skipped_details.forEach(function(item) {
                    html += '<tr>';
                    html += '<td>' + (item.property_name || '-') + '</td>';
                    html += '<td>' + (item.unit_name || '-') + '</td>';
                    html += '<td class="text-warning">' + (item.reason || '-') + '</td>';
                    html += '</tr>';
                });

                html += '</tbody></table></div>';
            }

            // Show failed units
            if (data.failed_details && data.failed_details.length > 0) {
                html += '<h6 class="mt-3 text-danger"><strong>Failed Units:</strong></h6>';
                html += '<div class="table-responsive"><table class="table table-bordered table-sm"><thead><tr>';
                html += '<th>Property</th><th>Unit</th><th>Reason</th>';
                html += '</tr></thead><tbody>';

                data.failed_details.forEach(function(item) {
                    html += '<tr>';
                    html += '<td>' + (item.property_name || '-') + '</td>';
                    html += '<td>' + (item.unit_name || '-') + '</td>';
                    html += '<td class="text-danger">' + (item.reason || '-') + '</td>';
                    html += '</tr>';
                });

                html += '</tbody></table></div>';
            }

            // Final summary
            if (!data.created_details || data.created_details.length === 0) {
                html += '<div class="alert alert-warning mt-3">';
                html += '<strong>No invoices would be generated.</strong><br>';
                html += 'Please check:';
                html += '<ul class="mb-0 mt-2">';
                html += '<li>Properties must have "Auto Invoice" enabled</li>';
                html += '<li>Units must have "Auto Invoice" enabled</li>';
                html += '<li>Units must be marked as "Occupied"</li>';
                html += '<li>Units must have rent amount > 0</li>';
                html += '<li>Tenants must have valid lease dates</li>';
                html += '</ul>';
                html += '</div>';
            }

            html += '<div class="mt-3"><strong>Final Count:</strong> ';
            html += 'Invoices to be created: <span class="badge bg-success">' + (data.invoices_created || 0) + '</span>, ';
            html += 'Failed: <span class="badge bg-danger">' + (data.invoices_failed || 0) + '</span>';
            if (data.skipped_details && data.skipped_details.length > 0) {
                html += ', Skipped: <span class="badge bg-warning">' + data.skipped_details.length + '</span>';
            }
            html += '</div>';

            $('#preview_results').html(html).show();
        }
    });
</script>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Automatic Invoice Generation Settings') }}</h5>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('auto.invoice.logs') }}" class="btn btn-secondary">
                            <i class="ti ti-file-text align-text-bottom"></i> {{ __('View Generation Logs') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Global Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Global Settings') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Enable Auto Invoice Generation') }}</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="global_auto_invoice_enabled"
                                            {{ $properties->count() > 0 && $properties->where('auto_invoice_enabled', true)->count() == $properties->count() ? 'checked' : '' }}>
                                        <label class="form-check-label" for="global_auto_invoice_enabled">
                                            {{ __('Enable automatic invoice generation for all properties') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Invoice Generation Day') }}</label>
                                    <select class="form-select" id="global_invoice_generation_day">
                                        @for($i = 1; $i <= 28; $i++)
                                            <option value="{{ $i }}" {{ (isset($defaultGenerationDay) && $defaultGenerationDay == $i) ? 'selected' : ($i == 1 && !isset($defaultGenerationDay) ? 'selected' : '') }}>
                                                {{ $i }}{{ $i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th')) }} of each month
                                            </option>
                                        @endfor
                                    </select>
                                    <small class="text-muted">{{ __('Invoices will be generated on this day of each month') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview & Generate -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Preview & Generate') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <div class="row align-items-end">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('Target Month') }}</label>
                                            <input type="month" class="form-control" id="preview_month" value="{{ date('Y-m') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="button" class="btn btn-primary w-100" id="preview_invoices">
                                                <i class="ti ti-eye align-text-bottom"></i> {{ __('Preview Invoices') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-success w-100" id="generate_invoices">
                                        <i class="ti ti-check align-text-bottom"></i> {{ __('Generate Invoices Now') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="preview_results" class="mt-3" style="display: none;"></div>
                    </div>
                </div>

                @if($latestLog)
                <div class="alert alert-info">
                    <strong>{{ __('Last Generation:') }}</strong> 
                    {{ dateFormat($latestLog->generation_date) }} - 
                    {{ __('Created:') }} {{ $latestLog->invoices_created }}, 
                    {{ __('Failed:') }} {{ $latestLog->invoices_failed }}
                    <span class="badge bg-{{ $latestLog->status == 'success' ? 'success' : ($latestLog->status == 'partial' ? 'warning' : 'danger') }}">
                        {{ ucfirst($latestLog->status) }}
                    </span>
                </div>
                @endif

                <!-- Properties & Units -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ __('Properties & Units') }}</h6>
                    </div>
                    <div class="card-body">
                        @foreach($properties as $property)
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="mb-0">{{ $property->name }}</h6>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input property-auto-invoice-toggle"
                                                        data-property-id="{{ $property->id }}"
                                                        {{ $property->auto_invoice_enabled ? 'checked' : '' }}
                                                        id="property_toggle_{{ $property->id }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Generation Day') }}</label>
                                                <select class="form-select property-generation-day" data-property-id="{{ $property->id }}">
                                                    @for($i = 1; $i <= 28; $i++)
                                                        <option value="{{ $i }}" {{ $property->invoice_generation_day == $i ? 'selected' : '' }}>
                                                            {{ $i }}{{ $i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th')) }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Unit Name') }}</th>
                                                        <th>{{ __('Rent') }}</th>
                                                        <th>{{ __('Status') }}</th>
                                                        <th>{{ __('Default Invoice Type') }}</th>
                                                        <th>{{ __('Auto Generate') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($property->totalUnits as $unit)
                                                        <tr>
                                                            <td>{{ $unit->name }}</td>
                                                            <td>{{ priceFormat($unit->rent) }}</td>
                                                            <td>
                                                                @if($unit->is_occupied)
                                                                    <span class="badge bg-success">{{ __('Occupied') }}</span>
                                                                @else
                                                                    <span class="badge bg-secondary">{{ __('Vacant') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-select-sm unit-invoice-type" data-unit-id="{{ $unit->id }}">
                                                                    @foreach($invoiceTypes as $typeId => $typeTitle)
                                                                        <option value="{{ $typeId }}" {{ $unit->default_invoice_type_id == $typeId ? 'selected' : '' }}>
                                                                            {{ $typeTitle }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-switch">
                                                                    <input type="checkbox" class="form-check-input unit-auto-invoice-toggle"
                                                                        data-unit-id="{{ $unit->id }}"
                                                                        {{ $unit->auto_invoice_enabled ? 'checked' : '' }}
                                                                        {{ !$unit->is_occupied ? 'disabled' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        @endforeach

                        @if($properties->count() == 0)
                            <div class="alert alert-warning">
                                {{ __('No properties found. Please add properties first.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

