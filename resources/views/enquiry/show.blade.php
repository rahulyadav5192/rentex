@extends('layouts.app')
@section('page-title')
    {{ __('Enquiry Details') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('enquiry.index') }}">{{ __('Enquiry') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Enquiry Details') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Enquiry Details') }}</h5>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('enquiry.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">{{ __('Basic Information') }}</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted">{{ __('Name') }}:</td>
                                    <td><strong>{{ $enquiry->name }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('Email') }}:</td>
                                    <td><strong>{{ $enquiry->email }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('Phone') }}:</td>
                                    <td><strong>{{ $enquiry->contact_number ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('Subject') }}:</td>
                                    <td><strong>{{ $enquiry->subject }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">{{ __('Date') }}:</td>
                                    <td><strong>{{ dateFormat($enquiry->created_at) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">{{ __('Property Information') }}</h6>
                            @if ($property)
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted">{{ __('Property Name') }}:</td>
                                        <td><strong><a href="{{ route('property.show', \Crypt::encrypt($property->id)) }}" target="_blank">{{ $property->name }}</a></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">{{ __('Address') }}:</td>
                                        <td><strong>{{ $property->address ?? '-' }}</strong></td>
                                    </tr>
                                </table>
                            @else
                                <p class="text-muted">{{ __('No property associated with this enquiry.') }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3">{{ __('Message') }}</h6>
                            <div class="p-3 bg-light rounded">
                                <p class="mb-0">{{ $enquiry->message }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if (!empty($enquiry->custom_fields))
                        @php
                            $customFields = is_string($enquiry->custom_fields) ? json_decode($enquiry->custom_fields, true) : $enquiry->custom_fields;
                        @endphp
                        @if (!empty($customFields))
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="mb-3">{{ __('Additional Information') }}</h6>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Field') }}</th>
                                                <th>{{ __('Value') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customFields as $fieldName => $fieldValue)
                                                @php
                                                    $field = $leadFormFields->where('field_name', $fieldName)->first();
                                                    $fieldLabel = $field ? $field->field_label : ucfirst(str_replace('_', ' ', $fieldName));
                                                @endphp
                                                <tr>
                                                    <td class="text-muted">{{ $fieldLabel }}:</td>
                                                    <td>
                                                        @if ($field && $field->field_type == 'doc' && is_string($fieldValue) && strpos($fieldValue, 'upload/') === 0)
                                                            <a href="{{ \Storage::disk('public')->url($fieldValue) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                <i class="ti ti-download"></i> {{ __('Download') }}
                                                            </a>
                                                        @else
                                                            <strong>{{ is_array($fieldValue) ? json_encode($fieldValue) : $fieldValue }}</strong>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

