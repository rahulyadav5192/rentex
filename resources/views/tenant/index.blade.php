@extends('layouts.app')
@section('page-title')
    {{ __('Tenant') }}
@endsection
@php
    $profile = asset('assets/images/admin/user.png');
@endphp

@push('head-page')
    <style>
        .tenant-card-modern {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }
        .tenant-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        }
        .tenant-card-modern .dropdown-item:hover {
            background-color: #f5f5f5 !important;
        }
        .card-header {
            background: transparent !important;
            border-bottom: 2px solid #000 !important;
            padding: 1.5rem 0 !important;
        }
        .card-header h5 {
            color: #000 !important;
            font-weight: 700 !important;
            font-size: 1.5rem !important;
        }
        .btn-secondary {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
            border-radius: 8px !important;
            padding: 0.5rem 1.5rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }
        .btn-secondary:hover {
            background-color: #333 !important;
            border-color: #333 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }
        .tenant-card-modern h4 {
            color: #000 !important;
            font-weight: 600 !important;
        }
        .tenant-card-modern h4:hover {
            color: #333 !important;
        }
        .tenant-card-modern .text-muted {
            color: #666 !important;
        }
        .tenant-profile-img {
            position: relative;
            z-index: 1;
        }
        .tenant-profile-default {
            z-index: 0;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle image load errors
            document.querySelectorAll('.tenant-profile-img').forEach(function(img) {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    var defaultIcon = this.nextElementSibling;
                    if (defaultIcon && defaultIcon.classList.contains('tenant-profile-default')) {
                        defaultIcon.style.display = 'flex';
                    }
                });
            });
        });
    </script>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Tenant') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Tenant List') }}</h5>
                        </div>
                        @can('create tenant')
                            <div class="col-auto">
                                <a class="btn btn-secondary" href="{{ route('tenant.create') }}" data-size="md"> <i
                                        class="ti ti-circle-plus align-text-bottom" style="color: #fff;"></i> {{ __('Create Tenant') }}</a>
                            </div>
                        @endcan
                    </div>
                </div>

                <div class="row mt-4 g-4">
                    @foreach ($tenants as $tenant)
                        <div class="col-xxl-3 col-xl-4 col-md-6">
                            <div class="card border-0 shadow-sm h-100 tenant-card-modern">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0 position-relative" style="width: 70px; height: 70px;">
                                            @php
                                                $profileUrl = !empty($tenant->user->profile) ? fetch_file($tenant->user->profile, 'upload/profile/') : '';
                                                $profileUrl = !empty($profileUrl) ? $profileUrl : $profile;
                                            @endphp
                                            <img class="img-fluid rounded-circle tenant-profile-img"
                                                src="{{ $profileUrl }}"
                                                alt="Profile Image"
                                                style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #000; display: block;"
                                                onerror="this.src='{{ $profile }}'; this.onerror=null;">
                                        </div>
                                        @if (Gate::check('edit tenant') || Gate::check('delete tenant') || Gate::check('show tenant'))
                                            <div class="flex-shrink-0 ms-auto">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle text-dark opacity-75 arrow-none bg-white rounded-circle d-flex align-items-center justify-content-center" href="#"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="text-decoration: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 36px; height: 36px; line-height: 1;">
                                                        <i class="ti ti-dots" style="font-size: 18px; vertical-align: middle;"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 8px; min-width: 180px;">
                                                        <a class="dropdown-item text-dark d-flex align-items-center py-2"
                                                            href="{{ route('tenant.edit',\Crypt::encrypt($tenant->id)) }}"
                                                            style="transition: background 0.2s;">
                                                            <i class="material-icons-two-tone me-2" style="font-size: 20px;">edit</i>
                                                            {{ __('Edit Tenant') }}
                                                        </a>

                                                        @can('show tenant')
                                                            <a class="dropdown-item text-dark d-flex align-items-center py-2"
                                                                href="{{ route('tenant.show',\Crypt::encrypt($tenant->id)) }}"
                                                                style="transition: background 0.2s;">
                                                                <i class="material-icons-two-tone me-2" style="font-size: 20px;">remove_red_eye</i>
                                                                {{ __('View Tenant') }}
                                                            </a>
                                                        @endcan
                                                        @can('delete tenant')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['tenant.destroy', $tenant->id],
                                                                'id' => 'tenant-' . $tenant->id,
                                                            ]) !!}
                                                            <a class="dropdown-item text-dark d-flex align-items-center py-2 confirm_dialog" href="#"
                                                                style="transition: background 0.2s;">
                                                                <i class="material-icons-two-tone me-2" style="font-size: 20px;">delete</i>
                                                                {{ __('Delete Tenant') }}
                                                            </a>
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <a href="{{ route('tenant.show', \Crypt::encrypt($tenant->id)) }}" style="text-decoration: none;">
                                        <h4 class="mb-2">{{ ucfirst(!empty($tenant->user) ? $tenant->user->first_name : '') . ' ' . ucfirst(!empty($tenant->user) ? $tenant->user->last_name : '') }}
                                        </h4>
                                    </a>
                                    <h6 class="text-truncate text-muted d-flex align-items-center mb-3">
                                        <i class="ti ti-mail me-1"></i>
                                        {{ !empty($tenant->user) ? $tenant->user->email : '-' }}
                                    </h6>

                                    <div class="row">
                                        <div class="col-sm-12 mb-3">
                                            <p class="text-muted mb-0" style="font-size: 0.875rem;">
                                                <i class="ti ti-map-pin me-1"></i>
                                                {{ $tenant->address }}
                                            </p>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold">{{ __('Phone') }}</p>
                                            <h6 class="mb-0 text-dark">
                                                {{ !empty($tenant->user) ? $tenant->user->phone_number : '-' }}
                                            </h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold">{{ __('Family Member') }}</p>
                                            <h6 class="mb-0 text-dark">{{ !empty($tenant->family_member) ? $tenant->family_member : '-' }}</h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold">{{ __('Property') }}</p>
                                            <h6 class="mb-0 text-dark">
                                                {{ !empty($tenant->properties) ? $tenant->properties->name : '-' }}
                                            </h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold">{{ __('Unit') }}</p>
                                            <h6 class="mb-0 text-dark">
                                                {{ !empty($tenant->units) ? $tenant->units->name : '-' }}
                                            </h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold">{{ __('Lease Start Date') }}</p>
                                            <h6 class="mb-0 text-dark">{{ dateFormat($tenant->lease_start_date) }}</h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold">{{ __('Lease End Date') }}</p>
                                            <h6 class="mb-0 text-dark">{{ dateFormat($tenant->lease_end_date) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
