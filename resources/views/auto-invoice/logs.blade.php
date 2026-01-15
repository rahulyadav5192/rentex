@extends('layouts.app')

@section('page-title')
    {{ __('Invoice Generation Logs') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('auto.invoice.index') }}">{{ __('Auto Invoice Settings') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Generation Logs') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Invoice Generation Logs') }}</h5>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('auto.invoice.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left align-text-bottom"></i> {{ __('Back to Settings') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('Generation Date') }}</th>
                                <th>{{ __('Invoices Created') }}</th>
                                <th>{{ __('Invoices Failed') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th class="text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>{{ dateFormat($log->generation_date) }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $log->invoices_created }}</span>
                                    </td>
                                    <td>
                                        @if($log->invoices_failed > 0)
                                            <span class="badge bg-danger">{{ $log->invoices_failed }}</span>
                                        @else
                                            <span class="badge bg-secondary">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->status == 'success')
                                            <span class="badge bg-success">{{ __('Success') }}</span>
                                        @elseif($log->status == 'partial')
                                            <span class="badge bg-warning">{{ __('Partial') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('Failed') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ dateFormat($log->created_at) }}</td>
                                    <td class="text-right">
                                        <button class="btn btn-sm btn-primary view-log-details" data-log-id="{{ $log->id }}">
                                            <i class="ti ti-eye"></i> {{ __('Details') }}
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{ __('No generation logs found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log Details Modal -->
<div class="modal fade" id="logDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Generation Log Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="logDetailsContent">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script-page')
<script>
    $(document).ready(function() {
        $('.view-log-details').on('click', function() {
            const logId = $(this).data('log-id');
            const modal = new bootstrap.Modal(document.getElementById('logDetailsModal'));
            
            $('#logDetailsContent').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            modal.show();

            $.ajax({
                url: `/auto-invoice/logs/${logId}/details`,
                method: 'GET',
                success: function(response) {
                    if (response.success && response.data) {
                        const log = response.data;
                        let html = '<div class="row mb-3">';
                        html += '<div class="col-md-6"><strong>{{ __("Generation Date:") }}</strong> ' + (log.generation_date || '-') + '</div>';
                        html += '<div class="col-md-6"><strong>{{ __("Status:") }}</strong> <span class="badge bg-' + (log.status == 'success' ? 'success' : (log.status == 'partial' ? 'warning' : 'danger')) + '">' + (log.status || '-') + '</span></div>';
                        html += '</div>';
                        html += '<div class="row mb-3">';
                        html += '<div class="col-md-6"><strong>{{ __("Invoices Created:") }}</strong> ' + (log.invoices_created || 0) + '</div>';
                        html += '<div class="col-md-6"><strong>{{ __("Invoices Failed:") }}</strong> ' + (log.invoices_failed || 0) + '</div>';
                        html += '</div>';

                        if (log.details) {
                            const details = typeof log.details === 'string' ? JSON.parse(log.details) : log.details;
                            
                            if (details.created && details.created.length > 0) {
                                html += '<h6 class="mt-4">{{ __("Created Invoices:") }}</h6>';
                                html += '<div class="table-responsive"><table class="table table-sm table-bordered"><thead><tr>';
                                html += '<th>{{ __("Property") }}</th><th>{{ __("Unit") }}</th><th>{{ __("Amount") }}</th><th>{{ __("Invoice Month") }}</th>';
                                html += '</tr></thead><tbody>';
                                details.created.forEach(function(item) {
                                    html += '<tr>';
                                    html += '<td>' + (item.property_name || '-') + '</td>';
                                    html += '<td>' + (item.unit_name || '-') + '</td>';
                                    html += '<td>' + (item.amount || '0.00') + '</td>';
                                    html += '<td>' + (item.invoice_month || '-') + '</td>';
                                    html += '</tr>';
                                });
                                html += '</tbody></table></div>';
                            }

                            if (details.failed && details.failed.length > 0) {
                                html += '<h6 class="mt-4">{{ __("Failed Invoices:") }}</h6>';
                                html += '<div class="table-responsive"><table class="table table-sm table-bordered"><thead><tr>';
                                html += '<th>{{ __("Property") }}</th><th>{{ __("Unit") }}</th><th>{{ __("Reason") }}</th>';
                                html += '</tr></thead><tbody>';
                                details.failed.forEach(function(item) {
                                    html += '<tr>';
                                    html += '<td>' + (item.property_name || '-') + '</td>';
                                    html += '<td>' + (item.unit_name || '-') + '</td>';
                                    html += '<td class="text-danger">' + (item.reason || '-') + '</td>';
                                    html += '</tr>';
                                });
                                html += '</tbody></table></div>';
                            }
                        }

                        if (log.error_log) {
                            html += '<h6 class="mt-4">{{ __("Error Log:") }}</h6>';
                            html += '<pre class="bg-light p-3 rounded">' + log.error_log + '</pre>';
                        }

                        $('#logDetailsContent').html(html);
                    } else {
                        $('#logDetailsContent').html('<div class="alert alert-warning">{{ __("No details available") }}</div>');
                    }
                },
                error: function(xhr) {
                    $('#logDetailsContent').html('<div class="alert alert-danger">{{ __("Failed to load log details") }}</div>');
                }
            });
        });
    });
</script>
@endpush
@endsection

