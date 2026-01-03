@extends('layouts.app')
@section('page-title')
    {{ __('Edit Enquiry') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('enquiry.index') }}">{{ __('Enquiry') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Edit Enquiry') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Edit Enquiry') }}</h5>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('enquiry.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => ['enquiry.update', $enquiry->id], 'method' => 'PUT']) }}
                    
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                {{ Form::text('name', $enquiry->name, ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                {{ Form::email('email', $enquiry->email, ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('contact_number', __('Contact Number'), ['class' => 'form-label']) }}
                                {{ Form::text('contact_number', $enquiry->contact_number, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
                                {{ Form::text('subject', $enquiry->subject, ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                {{ Form::label('message', __('Message'), ['class' => 'form-label']) }}
                                {{ Form::textarea('message', $enquiry->message, ['class' => 'form-control', 'rows' => 5, 'required' => 'required']) }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-end">
                        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary']) }}
                    </div>
                    
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

