@extends('layouts.app')

@section('page-title')
    {{ __('Import Invoices - Column Mapping') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('invoice.index') }}">{{ __('Invoice') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('invoice.import.index') }}">{{ __('Import') }}</a></li>
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
                    <p class="text-muted mb-4">{{ __('Select which column from your file corresponds to each database field. Property and unit names will be matched automatically (case-insensitive).') }}</p>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">{{ __('Required Fields') }}</h6>
                            @foreach(['property_name', 'unit_name', 'invoice_month', 'end_date', 'invoice_type', 'amount'] as $field)
                                @if(isset($fields['required'][$field]))
                                    <div class="mb-3">
                                        <label class="form-label">
                                            {{ $fields['required'][$field]['label'] }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="mappings[{{ $field }}]" class="form-select" required>
                                            <option value="ignore">{{ __('-- Ignore Field --') }}</option>
                                            @foreach($headings as $index => $heading)
                                                <option value="{{ $index }}" 
                                                    {{ isset($autoMapped[$field]) && $autoMapped[$field] == $index ? 'selected' : '' }}>
                                                    {{ $heading }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">{{ __('Optional Fields') }}</h6>
                            @foreach(['invoice_id', 'notes', 'description'] as $field)
                                @if(isset($fields['optional'][$field]))
                                    <div class="mb-3">
                                        <label class="form-label">
                                            {{ $fields['optional'][$field]['label'] }}
                                        </label>
                                        <select name="mappings[{{ $field }}]" class="form-select">
                                            <option value="ignore">{{ __('-- Ignore Field --') }}</option>
                                            @foreach($headings as $index => $heading)
                                                <option value="{{ $index }}" 
                                                    {{ isset($autoMapped[$field]) && $autoMapped[$field] == $index ? 'selected' : '' }}>
                                                    {{ $heading }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary" id="validate-btn">
                            <i class="ti ti-check me-2"></i>{{ __('Validate & Preview') }}
                        </button>
                        <a href="{{ route('invoice.import.cancel') }}" class="btn btn-secondary">
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
var properties = @json($properties);
var unmatchedProperties = {};
var unmatchedUnits = {};
var savedPropertySelections = {}; // Store selections across validations
var savedUnitSelections = {}; // Store selections across validations

$(document).ready(function() {
    $('#mapping-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const formDataArray = $(this).serializeArray();
        
        // Debug: Log form data
        console.log('Form data (serialized):', formData);
        console.log('Form data (array):', formDataArray);
        
        // Check if all required mappings are set
        const requiredFields = ['property_name', 'unit_name', 'invoice_month', 'end_date', 'invoice_type', 'amount'];
        const missingFields = [];
        requiredFields.forEach(function(field) {
            const mappingValue = $('select[name="mappings[' + field + ']"]').val();
            console.log('Field:', field, 'Value:', mappingValue);
            if (!mappingValue || mappingValue === 'ignore' || mappingValue === '') {
                missingFields.push(field);
            }
        });
        
        if (missingFields.length > 0) {
            alert('{{ __("Please map all required fields: ") }}' + missingFields.join(', '));
            $('#validate-btn').prop('disabled', false).html('<i class="ti ti-check me-2"></i>{{ __("Validate & Preview") }}');
            return;
        }
        
        $('#validate-btn').prop('disabled', true).html('<i class="ti ti-loader me-2"></i>{{ __("Validating...") }}');
        
        $.ajax({
            url: '{{ route("invoice.import.validate") }}',
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
                console.log('Error response:', xhr.responseJSON);
                console.log('Status:', xhr.status);
                const error = xhr.responseJSON?.error || xhr.responseJSON?.message || '{{ __("Validation failed. Please try again.") }}';
                alert(error);
                $('#validate-btn').prop('disabled', false).html('<i class="ti ti-check me-2"></i>{{ __("Validate & Preview") }}');
            }
        });
    });

    function displayValidationResults(validation) {
        let html = '<div class="alert alert-info">';
        html += '<strong>{{ __("Summary:") }}</strong><br>';
        html += '{{ __("Invoices to be created:") }} <strong>' + (validation.tenants_to_create ? validation.tenants_to_create.length : 0) + '</strong><br>';
        html += '{{ __("Total rows:") }} <strong>' + validation.total_rows + '</strong>';
        html += '</div>';

        // Store current selections from DOM before updating
        $('.property-select').each(function() {
            const key = $(this).data('row-key');
            const value = $(this).val();
            if (key && value) {
                savedPropertySelections[key] = value;
            }
        });
        
        $('.unit-select').each(function() {
            const key = $(this).data('row-key');
            const value = $(this).val();
            if (key && value) {
                savedUnitSelections[key] = value;
            }
        });

        // Store unmatched data
        unmatchedProperties = validation.unmatched_properties || {};
        unmatchedUnits = validation.unmatched_units || {};

        // Display errors
        if (validation.errors && validation.errors.length > 0) {
            html += '<div class="alert alert-danger">';
            html += '<strong>{{ __("Errors found:") }}</strong><br>';
            html += '<ul class="mb-0">';
            validation.errors.forEach(function(error) {
                html += '<li>{{ __("Row") }} ' + error.row + ': ' + error.message + '</li>';
            });
            html += '</ul>';
            html += '</div>';
        }

        // Display unmatched properties
        if (Object.keys(unmatchedProperties).length > 0) {
            html += '<div class="alert alert-warning mt-3">';
            html += '<strong>{{ __("Unmatched Properties:") }}</strong> {{ __("Please select the correct property for each row.") }}<br>';
            html += '<div class="mt-3">';
            Object.keys(unmatchedProperties).forEach(function(key) {
                const item = unmatchedProperties[key];
                // Use saved selection if available
                const selectedPropertyId = savedPropertySelections[key] || '';
                
                html += '<div class="mb-3 p-3 border rounded" data-row-key="' + key + '">';
                html += '<strong>{{ __("Row") }} ' + item.row + ':</strong> ' + item.first_name + ' ' + item.last_name + '<br>';
                html += '<span class="text-muted">{{ __("Property Name in File:") }} "' + item.property_name + '"</span><br>';
                html += '<label class="form-label mt-2">{{ __("Select Property:") }}</label>';
                html += '<select class="form-select property-select" data-row-key="' + key + '" name="property_selections[' + key + ']">';
                html += '<option value="">{{ __("-- Select Property --") }}</option>';
                properties.forEach(function(prop) {
                    const selected = (selectedPropertyId == prop.id) ? ' selected' : '';
                    html += '<option value="' + prop.id + '"' + selected + '>' + prop.name + '</option>';
                });
                html += '</select>';
                html += '</div>';
            });
            html += '</div>';
        }

        // Display unmatched units
        if (Object.keys(unmatchedUnits).length > 0) {
            html += '<div class="alert alert-warning mt-3">';
            html += '<strong>{{ __("Unmatched Units:") }}</strong> {{ __("Please select the correct unit for each row.") }}<br>';
            html += '<div class="mt-3">';
            Object.keys(unmatchedUnits).forEach(function(key) {
                const item = unmatchedUnits[key];
                // Use saved selections if available
                const selectedUnitId = savedUnitSelections[key] || '';
                // Get property ID from saved selection or from item
                const propertyId = savedPropertySelections[key] || item.property_id || '';
                
                html += '<div class="mb-3 p-3 border rounded" data-row-key="' + key + '" data-property-id="' + propertyId + '">';
                html += '<strong>{{ __("Row") }} ' + item.row + ':</strong> ' + item.first_name + ' ' + item.last_name + '<br>';
                html += '<span class="text-muted">{{ __("Property:") }} ' + item.property_name + ' | {{ __("Unit Name in File:") }} "' + item.unit_name + '"</span><br>';
                html += '<label class="form-label mt-2">{{ __("Select Unit:") }}</label>';
                html += '<select class="form-select unit-select" data-row-key="' + key + '" data-property-id="' + propertyId + '" name="unit_selections[' + key + ']">';
                html += '<option value="">{{ __("-- Select Unit --") }}</option>';
                // Store selected unit ID for later use when loading units
                if (selectedUnitId) {
                    html += '<option value="' + selectedUnitId + '" data-preserve="true" style="display:none;">Preserved</option>';
                }
                html += '</select>';
                html += '</div>';
            });
            html += '</div>';
        }

        if (validation.errors && validation.errors.length > 0) {
            html += '<p class="text-danger mt-3"><strong>{{ __("Cannot proceed with import until all errors are fixed.") }}</strong></p>';
        } else if (Object.keys(unmatchedProperties).length > 0 || Object.keys(unmatchedUnits).length > 0) {
            html += '<p class="text-warning mt-3"><strong>{{ __("Please select properties and units for all unmatched rows, then click Validate again.") }}</strong></p>';
            html += '<button type="button" class="btn btn-warning mt-2" id="revalidate-btn">';
            html += '<i class="ti ti-refresh me-2"></i>{{ __("Re-validate with Selections") }}';
            html += '</button>';
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

        // Load units when property is selected for unmatched properties
        $(document).on('change', '.property-select', function() {
            const rowKey = $(this).data('row-key');
            const propertyId = $(this).val();
            
            // Save the selection
            if (propertyId) {
                savedPropertySelections[rowKey] = propertyId;
            } else {
                delete savedPropertySelections[rowKey];
            }
            
            if (!propertyId) {
                return;
            }
            
            // Find corresponding unmatched unit dropdown for the same row
            const unitSelect = $('.unit-select[data-row-key="' + rowKey + '"]');
            if (unitSelect.length) {
                // Update the property-id attribute and load units
                unitSelect.attr('data-property-id', propertyId);
                // Also update the parent div's data-property-id
                unitSelect.closest('[data-row-key="' + rowKey + '"]').attr('data-property-id', propertyId);
                loadUnitsForProperty(rowKey, propertyId);
            }
        });
        
        // Save unit selection when changed
        $(document).on('change', '.unit-select', function() {
            const rowKey = $(this).data('row-key');
            const unitId = $(this).val();
            
            // Save the selection
            if (unitId) {
                savedUnitSelections[rowKey] = unitId;
            } else {
                delete savedUnitSelections[rowKey];
            }
        });

        // Load units for unmatched units after HTML is inserted
        // Check both the data-property-id and if there's a property-select with a value
        setTimeout(function() {
            $('.unit-select').each(function() {
                const rowKey = $(this).data('row-key');
                let propertyId = $(this).data('property-id');
                
                // Check if there's a property-select for this row with a selected value
                const propertySelect = $('.property-select[data-row-key="' + rowKey + '"]');
                if (propertySelect.length && propertySelect.val()) {
                    propertyId = propertySelect.val();
                    // Update the data-property-id attribute
                    $(this).attr('data-property-id', propertyId);
                    $(this).closest('[data-row-key="' + rowKey + '"]').attr('data-property-id', propertyId);
                }
                
                // Only load if property_id is set and is a number (not empty string)
                if (propertyId && !isNaN(propertyId) && propertyId > 0) {
                    loadUnitsForProperty(rowKey, propertyId);
                }
            });
        }, 200);

        // Handle re-validate button
        $(document).off('click', '#revalidate-btn').on('click', '#revalidate-btn', function() {
            revalidateWithSelections();
        });

        // Handle import button click
        $(document).off('click', '#import-btn').on('click', '#import-btn', function() {
            executeImport();
        });
    }

    function loadUnitsForProperty(rowKey, propertyId) {
        const select = $('.unit-select[data-row-key="' + rowKey + '"]');
        if (!select.length) return;

        // Preserve the currently selected unit value (check for preserved option first)
        let currentSelectedValue = select.val();
        const preservedOption = select.find('option[data-preserve="true"]');
        if (preservedOption.length) {
            currentSelectedValue = preservedOption.val();
        }
        
        select.html('<option value="">{{ __("Loading...") }}</option>');
        
        $.ajax({
            url: '{{ route("invoice.import.units") }}',
            type: 'GET',
            data: { property_id: propertyId },
            success: function(units) {
                let options = '<option value="">{{ __("-- Select Unit --") }}</option>';
                units.forEach(function(unit) {
                    const selected = (currentSelectedValue == unit.id) ? ' selected' : '';
                    options += '<option value="' + unit.id + '"' + selected + '>' + unit.name + '</option>';
                });
                select.html(options);
            },
            error: function() {
                select.html('<option value="">{{ __("Error loading units") }}</option>');
            }
        });
    }

    function revalidateWithSelections() {
        // Update saved selections from current DOM state
        $('.property-select').each(function() {
            const key = $(this).data('row-key');
            const value = $(this).val();
            if (key && value) {
                savedPropertySelections[key] = value;
            }
        });
        
        $('.unit-select').each(function() {
            const key = $(this).data('row-key');
            const value = $(this).val();
            if (key && value) {
                savedUnitSelections[key] = value;
            }
        });
        
        // Get form data as object
        const formDataArray = $('#mapping-form').serializeArray();
        const formDataObj = {};
        
        // Convert serialized array to object
        formDataArray.forEach(function(item) {
            formDataObj[item.name] = item.value;
        });
        
        // Use saved selections (which include current DOM state + previously saved)
        const propertySelections = Object.assign({}, savedPropertySelections);
        const unitSelections = Object.assign({}, savedUnitSelections);

        // Add selections to form data object
        formDataObj.property_selections = propertySelections;
        formDataObj.unit_selections = unitSelections;

        // Build final data object - jQuery will convert nested objects to Laravel array format
        const finalData = {
            _token: formDataObj._token || '{{ csrf_token() }}'
        };
        
        // Copy all mappings
        Object.keys(formDataObj).forEach(function(key) {
            if (key.startsWith('mappings[')) {
                finalData[key] = formDataObj[key];
            }
        });
        
        // Add property and unit selections as nested objects
        // jQuery will automatically convert these to property_selections[row_2]=123 format
        if (Object.keys(propertySelections).length > 0) {
            finalData.property_selections = propertySelections;
        }
        
        if (Object.keys(unitSelections).length > 0) {
            finalData.unit_selections = unitSelections;
        }
        
        // Debug: log the data being sent
        console.log('Property selections object:', propertySelections);
        console.log('Unit selections object:', unitSelections);
        console.log('Final data being sent:', finalData);

        $('#revalidate-btn').prop('disabled', true).html('<i class="ti ti-loader me-2"></i>{{ __("Validating...") }}');
        
        $.ajax({
            url: '{{ route("invoice.import.validate") }}',
            type: 'POST',
            data: finalData,
            success: function(response) {
                if (response.success) {
                    displayValidationResults(response.validation);
                } else {
                    alert(response.error || '{{ __("Validation failed.") }}');
                    $('#revalidate-btn').prop('disabled', false).html('<i class="ti ti-refresh me-2"></i>{{ __("Re-validate with Selections") }}');
                }
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.error || '{{ __("Validation failed. Please try again.") }}';
                alert(error);
                $('#revalidate-btn').prop('disabled', false).html('<i class="ti ti-refresh me-2"></i>{{ __("Re-validate with Selections") }}');
            }
        });
    }

    function executeImport() {
        if (!confirm('{{ __("Are you sure you want to import this data? This action cannot be undone.") }}')) {
            return;
        }

        const propertySelections = {};
        const unitSelections = {};

        $('.property-select').each(function() {
            const key = $(this).data('row-key');
            const value = $(this).val();
            if (value) {
                propertySelections[key] = value;
            }
        });

        $('.unit-select').each(function() {
            const key = $(this).data('row-key');
            const value = $(this).val();
            if (value) {
                unitSelections[key] = value;
            }
        });

        $('#import-btn').prop('disabled', true).html('<i class="ti ti-loader me-2"></i>{{ __("Importing...") }}');
        
        $.ajax({
            url: '{{ route("invoice.import.execute") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                property_selections: propertySelections,
                unit_selections: unitSelections
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = '{{ route("invoice.import.result") }}';
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

