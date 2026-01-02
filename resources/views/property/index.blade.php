@extends('layouts.app')
@section('page-title')
    {{ __('Property') }}
@endsection

@push('head-page')
    <style>
        .property-card-modern {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        .property-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        }
        .property-card-modern:hover img {
            transform: scale(1.05);
        }
        .property-card-modern .dropdown-item:hover {
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
    </style>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Property') }}</li>
@endsection

@push('script-page')
    <script src="{{ asset('assets/js/vendors/dropzone/dropzone.js') }}"></script>
    <script>
        var dropzone = new Dropzone('#demo-upload', {
            previewTemplate: document.querySelector('.preview-dropzon').innerHTML,
            parallelUploads: 10,
            thumbnailHeight: 120,
            thumbnailWidth: 120,
            maxFilesize: 10,
            filesizeBase: 1000,
            autoProcessQueue: false,
            thumbnail: function(file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function() {
                        file.previewElement.classList.add("dz-image-preview");
                    }, 1);
                }
            }

        });
        $('#property-submit').on('click', function() {
            "use strict";
            $('#property-submit').attr('disabled', true);
            var fd = new FormData();
            var file = document.getElementById('thumbnail').files[0];

            var files = $('#demo-upload').get(0).dropzone.getAcceptedFiles();
            $.each(files, function(key, file) {
                fd.append('property_images[' + key + ']', $('#demo-upload')[0].dropzone
                    .getAcceptedFiles()[key]); // attach dropzone image element
            });
            fd.append('thumbnail', file);
            var other_data = $('#property_form').serializeArray();
            $.each(other_data, function(key, input) {
                fd.append(input.name, input.value);
            });
            $.ajax({
                url: "{{ route('property.store') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: fd,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data) {
                    if (data.status == "success") {
                        $('#property-submit').attr('disabled', true);
                        toastrs(data.status, data.msg, data.status);
                        var url = '{{ route('property.show', ':id') }}';
                        url = url.replace(':id', data.id);
                        setTimeout(() => {
                            window.location.href = url;
                        }, "1000");

                    } else {
                        toastrs('Error', data.msg, 'error');
                        $('#property-submit').attr('disabled', false);
                    }
                },
                error: function(data) {
                    $('#property-submit').attr('disabled', false);
                    if (data.error) {
                        toastrs('Error', data.error, 'error');
                    } else {
                        toastrs('Error', data, 'error');
                    }
                },
            });
        });
    </script>
@endpush


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Property List') }}</h5>
                        </div>
                        <div class="col-auto d-flex gap-2 align-items-center">
                            @php
                                $frontendUrl = url('web/' . \Auth::user()->code . '/properties');
                            @endphp
                            <div class="d-flex align-items-center me-3" style="background: #f5f5f5; padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid #e0e0e0;">
                                <span class="text-muted me-2" style="font-size: 0.875rem;">{{ __('Frontend URL:') }}</span>
                                <span class="text-dark fw-semibold" style="font-size: 0.875rem; font-family: monospace;">{{ $frontendUrl }}</span>
                            </div>
                            <a class="btn btn-secondary" href="{{ $frontendUrl }}" target="_blank" style="white-space: nowrap;">
                                <i class="ti ti-external-link align-text-bottom me-1" style="color: #fff;"></i>
                                {{ __('View Listings') }}
                            </a>
                        @can('create property')
                                <a class="btn btn-secondary" href="{{ route('property.create') }}" data-size="md"> <i
                                        class="ti ti-circle-plus align-text-bottom "></i>
                                    {{ __('Create Property') }}</a>
                            @endcan
                            </div>
                    </div>
                </div>

                <div class="row mt-4 g-4">
                    @foreach ($properties as $property)
                        @php
                            $hasThumbnail = !empty($property->thumbnail) && !empty($property->thumbnail->image);
                            $thumbnail = $hasThumbnail ? $property->thumbnail->image : null;
                            $thumbnailUrl = $hasThumbnail ? fetch_file($thumbnail, 'upload/property/thumbnail/') : '';
                        @endphp
                        <div class="col-sm-6 col-md-4 col-xxl-3">
                            <div class="card border-0 shadow-sm h-100 property-card-modern" style="transition: all 0.3s ease; border-radius: 12px; overflow: hidden;">
                                <div class="position-relative" style="height: 220px; overflow: hidden; background: #f8f9fa;">
                                    @if ($hasThumbnail && !empty($thumbnailUrl))
                                        <img src="{{ $thumbnailUrl }}"
                                            alt="{{ $property->name }}" 
                                            class="w-100 h-100" 
                                            style="object-fit: cover; transition: transform 0.3s ease;" />
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100" style="background: #f8f9fa;">
                                            <i class="material-icons-two-tone" style="font-size: 80px; color: #000; opacity: 0.3;">home</i>
                                </div>
                                    @endif
                                    <div class="position-absolute top-0 end-0 p-2">
                                        @if (Gate::check('edit property') || Gate::check('delete property') || Gate::check('show property'))
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-dark opacity-75 arrow-none bg-white rounded-circle d-flex align-items-center justify-content-center" href="#"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    style="text-decoration: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 36px; height: 36px; line-height: 1;">
                                                    <i class="ti ti-dots" style="font-size: 18px; vertical-align: middle;"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 8px; min-width: 180px;">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['property.destroy', $property->id],
                                                        'id' => 'property-' . $property->id,
                                                    ]) !!}
                                                    @can('edit property')
                                                        <a class="dropdown-item text-dark d-flex align-items-center py-2" 
                                                            href="{{ route('property.edit', \Crypt::encrypt($property->id)) }}"
                                                            style="transition: background 0.2s;">
                                                            <i class="material-icons-two-tone me-2" style="font-size: 20px;">edit</i>
                                                            {{ __('Edit Property') }}
                                                        </a>
                                                    @endcan

                                                    @can('show property')
                                                        <a class="dropdown-item text-dark d-flex align-items-center py-2"
                                                            href="{{ route('property.show', \Crypt::encrypt($property->id)) }}"
                                                            style="transition: background 0.2s;">
                                                            <i class="material-icons-two-tone me-2" style="font-size: 20px;">remove_red_eye</i>
                                                            {{ __('View property') }}
                                                        </a>
                                                    @endcan
                                                    @can('delete property')
                                                        <a class="dropdown-item text-dark d-flex align-items-center py-2 confirm_dialog" href="#"
                                                            style="transition: background 0.2s;">
                                                            <i class="material-icons-two-tone me-2" style="font-size: 20px;">delete</i>
                                                            {{ __('Delete Property') }}
                                                        </a>
                                                    @endcan

                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <a href="@can('show property') {{ route('property.show', \Crypt::encrypt($property->id)) }}  @endcan"
                                        class="text-dark text-decoration-none">
                                        <h5 class="mb-2 fw-bold" style="font-size: 1.1rem; line-height: 1.4; color: #000;">
                                            {{ $property->name }}
                                        </h5>
                                    </a>
                                    
                                    <p class="text-muted mb-3" style="font-size: 0.875rem; line-height: 1.5; color: #666; min-height: 60px;">
                                        {{ Str::limit(strip_tags($property->description), 120, '...') }}
                                    </p>

                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge border border-dark text-dark px-3 py-1" 
                                            style="background: transparent; border-radius: 20px; font-weight: 500; font-size: 0.75rem;">
                                            <i class="material-icons-two-tone me-1" style="font-size: 16px; vertical-align: middle;">apartment</i>
                                                {{ $property->totalUnit() }} {{ __('Unit') }}
                                        </span>

                                        <span class="badge border border-dark text-dark px-3 py-1" 
                                            style="background: transparent; border-radius: 20px; font-weight: 500; font-size: 0.75rem;">
                                            <i class="material-icons-two-tone me-1" style="font-size: 16px; vertical-align: middle;">meeting_room</i>
                                                {{ $property->vacantUnit() }} {{ __('Vacant') }}
                                        </span>

                                        <span class="badge border border-dark text-dark px-3 py-1" 
                                            style="background: transparent; border-radius: 20px; font-weight: 500; font-size: 0.75rem;">
                                            <i class="material-icons-two-tone me-1" style="font-size: 16px; vertical-align: middle;">person</i>
                                            {{ $property->occupiedUnit() }} {{ __('Occupied') }}
                                        </span>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between pt-3 border-top" style="border-color: #e0e0e0 !important;">
                                        <span class="badge bg-dark text-white px-3 py-1" 
                                            style="border-radius: 20px; font-weight: 500; font-size: 0.75rem; display: inline-flex; align-items: center; height: 28px;"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="{{ __('Type') }}">
                                            {{ \App\Models\Property::$Type[$property->type] ?? $property->type }}
                                        </span>
                                        <a href="@can('show property') {{ route('property.show', \Crypt::encrypt($property->id)) }}  @endcan"
                                            class="text-dark text-decoration-none d-flex align-items-center"
                                            style="font-size: 0.875rem; font-weight: 500; height: 28px;">
                                            <span style="line-height: 1.5;">{{ __('View Details') }}</span>
                                            <i class="material-icons-two-tone ms-1" style="font-size: 18px; line-height: 1;">arrow_forward</i>
                                        </a>
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
