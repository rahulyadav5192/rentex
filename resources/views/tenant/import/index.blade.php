@extends('layouts.app')

@section('page-title')
    {{ __('Import Tenants') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tenant.index') }}">{{ __('Tenant') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Import') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Step 1: Upload File') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            <strong>{{ __('Supported formats:') }}</strong> CSV, XLSX, XLS (Max 10MB)
                            <br>
                            <strong>{{ __('File structure:') }}</strong> Each row represents one tenant. Property and unit names will be matched automatically (case-insensitive).
                        </div>

                        <!-- Required Fields Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="ti ti-alert-circle me-2"></i>{{ __('Required Fields') }}</h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">{{ __('The following fields are required in your import file:') }}</p>
                                <div class="row">
                                    @foreach($tenantFields as $field => $config)
                                        @if($config['required'])
                                            <div class="col-md-6 mb-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="ti ti-check text-success me-2"></i>
                                                    <strong>{{ $config['label'] }}</strong>
                                                    <span class="badge bg-danger ms-2">{{ __('Required') }}</span>
                                                </div>
                                                <small class="text-muted ms-4">{{ __('Type:') }} {{ ucfirst($config['type']) }}</small>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Optional Fields Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0"><i class="ti ti-info-circle me-2"></i>{{ __('Optional Fields') }}</h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">{{ __('The following fields are optional but recommended:') }}</p>
                                <div class="row">
                                    @foreach($tenantFields as $field => $config)
                                        @if(!$config['required'])
                                            <div class="col-md-6 mb-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="ti ti-circle text-muted me-2"></i>
                                                    <strong>{{ $config['label'] }}</strong>
                                                </div>
                                                <small class="text-muted ms-4">{{ __('Type:') }} {{ ucfirst($config['type']) }}</small>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Sample Format -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="ti ti-file-text me-2"></i>{{ __('Sample CSV Format') }}</h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">{{ __('Your CSV/Excel file should have a header row with column names. Example:') }}</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>first_name</th>
                                                <th>last_name</th>
                                                <th>email</th>
                                                <th>password</th>
                                                <th>phone_number</th>
                                                <th>property_name</th>
                                                <th>unit_name</th>
                                                <th>lease_start_date</th>
                                                <th>lease_end_date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John</td>
                                                <td>Doe</td>
                                                <td>john.doe@example.com</td>
                                                <td>password123</td>
                                                <td>1234567890</td>
                                                <td>Sunset Apartments</td>
                                                <td>A101</td>
                                                <td>2024-01-01</td>
                                                <td>2024-12-31</td>
                                            </tr>
                                            <tr>
                                                <td>Jane</td>
                                                <td>Smith</td>
                                                <td>jane.smith@example.com</td>
                                                <td>password456</td>
                                                <td>0987654321</td>
                                                <td>Sunset Apartments</td>
                                                <td>A102</td>
                                                <td>2024-02-01</td>
                                                <td>2025-01-31</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Field Name Variations -->
                        <div class="alert alert-warning">
                            <h6 class="mb-2"><i class="ti ti-lightbulb me-2"></i>{{ __('Field Name Tips:') }}</h6>
                            <ul class="mb-0">
                                <li>{{ __('Column names can vary (e.g., "First Name", "Firstname", "Fname" will all work)') }}</li>
                                <li>{{ __('Property and Unit names will be matched automatically by trimming and converting to lowercase') }}</li>
                                <li>{{ __('If a property/unit is not found, you can select it manually during the mapping step') }}</li>
                                <li>{{ __('Date fields can be in various formats (YYYY-MM-DD, MM/DD/YYYY, etc.)') }}</li>
                            </ul>
                        </div>

                        <form id="import-upload-form" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="import-file" class="form-label">{{ __('Select File') }}</label>
                                <input type="file" class="form-control" id="import-file" name="file" accept=".csv,.xlsx,.xls" required>
                                <div class="form-text">{{ __('Maximum file size: 10MB') }}</div>
                            </div>

                            <div id="upload-progress" class="d-none mb-3">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>

                            <div id="upload-error" class="alert alert-danger d-none"></div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="upload-btn">
                                    <i class="ti ti-upload me-2"></i>{{ __('Upload & Preview') }}
                                </button>
                                <a href="{{ route('tenant.index') }}" class="btn btn-secondary">
                                    <i class="ti ti-x me-2"></i>{{ __('Cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script-page')
<script>
$(document).ready(function() {
    $('#import-upload-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const fileInput = $('#import-file')[0];
        
        if (!fileInput.files.length) {
            $('#upload-error').removeClass('d-none').text('{{ __("Please select a file.") }}');
            return;
        }

        $('#upload-btn').prop('disabled', true).html('<i class="ti ti-loader me-2"></i>{{ __("Uploading...") }}');
        $('#upload-progress').removeClass('d-none');
        $('#upload-error').addClass('d-none');
        
        $.ajax({
            url: '{{ route("tenant.import.upload") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        $('.progress-bar').css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = '{{ route("tenant.import.mapping") }}';
                } else {
                    $('#upload-error').removeClass('d-none').text(response.error || '{{ __("Upload failed.") }}');
                    $('#upload-btn').prop('disabled', false).html('<i class="ti ti-upload me-2"></i>{{ __("Upload & Preview") }}');
                }
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.error || '{{ __("Upload failed. Please try again.") }}';
                $('#upload-error').removeClass('d-none').text(error);
                $('#upload-btn').prop('disabled', false).html('<i class="ti ti-upload me-2"></i>{{ __("Upload & Preview") }}');
            }
        });
    });
});
</script>
@endpush
@endsection

