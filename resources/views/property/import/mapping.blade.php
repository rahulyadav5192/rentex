@extends('layouts.app')

@section('page-title')
    {{ __('Import Properties & Units - Column Mapping') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('property.index') }}">{{ __('Property') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('property.import') }}">{{ __('Import') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Mapping') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Step 2: Preview & Step 3: Column Mapping') }}</h5>
            </div>
            <div class="card-body">
                <!-- Preview Section -->
                <div class="mb-4">
                    <h6 class="mb-3">{{ __('File Preview (First 3 rows)') }}</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    @foreach($headings as $heading)
                                        <th>{{ $heading }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($preview as $row)
                                    <tr>
                                        @foreach($headings as $index => $heading)
                                            <td>{{ $row[$index] ?? '' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>

                <!-- Mapping Section -->
                <form id="mapping-form">
                    @csrf
                    <h6 class="mb-3">{{ __('Map Columns') }}</h6>
                    <p class="text-muted mb-4">{{ __('Select which column from your file corresponds to each database field.') }}</p>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">{{ __('Property Fields') }}</h6>
                            @foreach($propertyFields as $field => $config)
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $config['label'] }}
                                        @if($config['required'])
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <select name="mappings[{{ $field }}]" class="form-select" {{ $config['required'] ? 'required' : '' }}>
                                        <option value="ignore">{{ __('-- Ignore Field --') }}</option>
                                        @foreach($headings as $heading)
                                            <option value="{{ $heading }}" 
                                                {{ isset($autoMappings[$field]) && $autoMappings[$field] === $heading ? 'selected' : '' }}>
                                                {{ $heading }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">{{ __('Unit Fields') }}</h6>
                            @foreach($unitFields as $field => $config)
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ $config['label'] }}
                                        @if($config['required'])
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <select name="mappings[{{ $field }}]" class="form-select" {{ $config['required'] ? 'required' : '' }}>
                                        <option value="ignore">{{ __('-- Ignore Field --') }}</option>
                                        @foreach($headings as $heading)
                                            <option value="{{ $heading }}" 
                                                {{ isset($autoMappings[$field]) && $autoMappings[$field] === $heading ? 'selected' : '' }}>
                                                {{ $heading }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary" id="validate-btn">
                            <i class="ti ti-check me-2"></i>{{ __('Validate & Preview') }}
                        </button>
                        <a href="{{ route('property.import.cancel') }}" class="btn btn-secondary">
                            <i class="ti ti-x me-2"></i>{{ __('Cancel') }}
                        </a>
                    </div>
                </form>

                <!-- Validation Results -->
                <div id="validation-results" class="mt-4 d-none">
                    <hr>
                    <h6 class="mb-3">{{ __('Validation Results') }}</h6>
                    <div id="validation-content"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script-page')
<script>
$(document).ready(function() {
    $('#mapping-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        $('#validate-btn').prop('disabled', true).html('<i class="ti ti-loader me-2"></i>{{ __("Validating...") }}');
        
        $.ajax({
            url: '{{ route("property.import.validate") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    displayValidationResults(response.validation);
                } else {
                    alert(response.error || '{{ __("Validation failed.") }}');
                    $('#validate-btn').prop('disabled', false).html('<i class="ti ti-check me-2"></i>{{ __("Validate & Preview") }}');
                }
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.error || '{{ __("Validation failed. Please try again.") }}';
                alert(error);
                $('#validate-btn').prop('disabled', false).html('<i class="ti ti-check me-2"></i>{{ __("Validate & Preview") }}');
            }
        });
    });

    function displayValidationResults(validation) {
        let html = '<div class="alert alert-info">';
        html += '<strong>{{ __("Summary:") }}</strong><br>';
        html += `{{ __("Properties to be created:") }} <strong>${validation.properties_count}</strong><br>`;
        html += `{{ __("Units to be created:") }} <strong>${validation.units_count}</strong><br>`;
        html += `{{ __("Total rows:") }} <strong>${validation.total_rows}</strong>`;
        html += '</div>';

        if (validation.errors && validation.errors.length > 0) {
            html += '<div class="alert alert-danger">';
            html += '<strong>{{ __("Errors found:") }}</strong><br>';
            html += '<ul class="mb-0">';
            validation.errors.forEach(function(error) {
                html += `<li>{{ __("Row") }} ${error.row}: ${error.message}</li>`;
            });
            html += '</ul>';
            html += '</div>';
            html += '<p class="text-danger"><strong>{{ __("Cannot proceed with import until all errors are fixed.") }}</strong></p>';
        } else {
            html += '<div class="alert alert-success">';
            html += '<i class="ti ti-check-circle me-2"></i><strong>{{ __("Validation passed!") }}</strong> {{ __("Ready to import.") }}';
            html += '</div>';
            html += '<button type="button" class="btn btn-success" id="import-btn">';
            html += '<i class="ti ti-download me-2"></i>{{ __("Import Data") }}';
            html += '</button>';
        }

        $('#validation-content').html(html);
        $('#validation-results').removeClass('d-none');
        $('#validate-btn').prop('disabled', false).html('<i class="ti ti-check me-2"></i>{{ __("Validate & Preview") }}');

        // Handle import button click
        $(document).on('click', '#import-btn', function() {
            executeImport();
        });
    }

    function executeImport() {
        if (!confirm('{{ __("Are you sure you want to import this data? This action cannot be undone.") }}')) {
            return;
        }

        $('#import-btn').prop('disabled', true).html('<i class="ti ti-loader me-2"></i>{{ __("Importing...") }}');
        
        $.ajax({
            url: '{{ route("property.import.execute") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = '{{ route("property.import.result") }}';
                } else {
                    alert(response.error || '{{ __("Import failed.") }}');
                    $('#import-btn').prop('disabled', false).html('<i class="ti ti-download me-2"></i>{{ __("Import Data") }}');
                }
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.error || '{{ __("Import failed. Please try again.") }}';
                alert(error);
                $('#import-btn').prop('disabled', false).html('<i class="ti ti-download me-2"></i>{{ __("Import Data") }}');
            }
        });
    }
});
</script>
@endpush
@endsection

