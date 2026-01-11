@extends('layouts.app')

@section('page-title')
    {{ __('Import Properties & Units') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('property.index') }}">{{ __('Property') }}</a></li>
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
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            <strong>{{ __('Supported formats:') }}</strong> CSV, XLSX, XLS (Max 10MB)
                            <br>
                            <strong>{{ __('File structure:') }}</strong> Each row represents one unit. Property data may repeat across rows.
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
                                <a href="{{ route('property.index') }}" class="btn btn-secondary">
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
            url: '{{ route("property.import.upload") }}',
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
                    window.location.href = '{{ route("property.import.mapping") }}';
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

