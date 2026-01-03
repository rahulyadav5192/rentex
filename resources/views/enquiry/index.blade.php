@extends('layouts.app')
@section('page-title')
    {{ __('Enquiry') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Enquiry') }}</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Enquiry List') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Subject') }}</th>
                                    <th>{{ __('Property') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($enquiries as $enquiry)
                                    <tr>
                                        <td>{{ $enquiry->name }}</td>
                                        <td>{{ $enquiry->email }}</td>
                                        <td>{{ $enquiry->contact_number ?? '-' }}</td>
                                        <td>{{ $enquiry->subject }}</td>
                                        <td>
                                            @if ($enquiry->property_id)
                                                @php
                                                    $property = \App\Models\Property::find($enquiry->property_id);
                                                @endphp
                                                @if ($property)
                                                    <a href="{{ route('property.show', $property->id) }}" target="_blank">
                                                        {{ $property->name }}
                                                    </a>
                                                @else
                                                    {{ __('N/A') }}
                                                @endif
                                            @else
                                                {{ __('N/A') }}
                                            @endif
                                        </td>
                                        <td>{{ dateFormat($enquiry->created_at) }}</td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                @if (Gate::check('show enquiry'))
                                                    <a href="{{ route('enquiry.show', $enquiry->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                @endif
                                                @if (Gate::check('edit enquiry'))
                                                    <a href="{{ route('enquiry.edit', $enquiry->id) }}" class="btn btn-sm btn-secondary">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                @endif
                                                @if (Gate::check('delete enquiry'))
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['enquiry.destroy', $enquiry->id], 'id' => 'delete-form-' . $enquiry->id, 'style' => 'display:inline']) !!}
                                                    <a href="#" class="btn btn-sm btn-danger confirm_dialog" data-form="delete-form-{{ $enquiry->id }}">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('No enquiries found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

