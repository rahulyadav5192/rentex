@extends('layouts.app')

@section('page-title')
    {{ __('Auto Invoice Generation Logs') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.auto.invoice.index') }}">{{ __('Auto Invoice Management') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Generation Logs') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('All Generation Logs') }}</h5>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.auto.invoice.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left align-text-bottom"></i> {{ __('Back') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Owner') }}</th>
                                <th>{{ __('Invoices Created') }}</th>
                                <th>{{ __('Invoices Failed') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>{{ dateFormat($log->generation_date) }}</td>
                                    <td>{{ $owners[$log->parent_id] ?? __('Unknown') }}</td>
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
                                    <td>
                                        @if($log->error_log)
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#errorModal{{ $log->id }}">
                                                <i class="ti ti-alert-circle"></i> {{ __('View Errors') }}
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                @if($log->error_log)
                                    <!-- Error Modal -->
                                    <div class="modal fade" id="errorModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('Error Log') }} - {{ dateFormat($log->generation_date) }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <pre class="bg-light p-3 rounded" style="max-height: 400px; overflow-y: auto;">{{ $log->error_log }}</pre>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{ __('No logs found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

