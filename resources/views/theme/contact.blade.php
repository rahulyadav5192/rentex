@extends('theme.main')

@section('content')
    <section class="our-login contact-background">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                    <div class="main-title text-center">
                        <h2 class="title">{{ __('Get in Touch') }}</h2>
                        <p class="paragraph">
                            {{ __('We’re here to help—reach out to us anytime with your questions or feedback.') }}</p>
                    </div>
                </div>
            </div>

            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="col-xl-6 mx-auto">
                    {{ Form::open(['route' => ['contact-us', 'code' => $user->code], 'method' => 'post']) }}

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif

                    <div class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">
                        @if (!empty($propertyId))
                            {{ Form::hidden('property_id', \Crypt::encrypt($propertyId)) }}
                            @if (!empty($property))
                                <div class="alert alert-info mb-3" role="alert">
                                    <strong>{{ __('Inquiry about:') }}</strong> {{ ucfirst($property->name) }}
                                </div>
                            @endif
                        @endif
                        
                        @php
                            // Get default fields (name, email, phone) and custom fields
                            $defaultFields = $leadFormFields->where('is_default', true)->sortBy('sort_order');
                            $customFields = $leadFormFields->where('is_default', false)->sortBy('sort_order');
                        @endphp
                        
                        @foreach ($defaultFields as $field)
                            <div class="mb20">
                                <div class="form-group col-md-12">
                                    {{ Form::label($field->field_name, $field->field_label, ['class' => 'form-label']) }}
                                    @if ($field->field_type == 'input')
                                        @if ($field->field_name == 'email')
                                            {{ Form::email($field->field_name, null, ['class' => 'form-control', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : '']) }}
                                        @elseif ($field->field_name == 'phone')
                                            {{ Form::tel($field->field_name, null, ['class' => 'form-control', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : '']) }}
                                        @else
                                            {{ Form::text($field->field_name, null, ['class' => 'form-control', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : '']) }}
                                        @endif
                                    @elseif ($field->field_type == 'select')
                                        {{ Form::select($field->field_name, ['' => __('Select') . ' ' . $field->field_label] + ($field->field_options ?? []), null, ['class' => 'form-control', $field->is_required ? 'required' : '']) }}
                                    @elseif ($field->field_type == 'checkbox')
                                        <div class="form-check">
                                            {{ Form::checkbox($field->field_name, 1, false, ['class' => 'form-check-input', 'id' => $field->field_name, $field->is_required ? 'required' : '']) }}
                                            {{ Form::label($field->field_name, $field->field_label, ['class' => 'form-check-label']) }}
                                        </div>
                                    @elseif ($field->field_type == 'yes_no')
                                        <div class="form-check form-check-inline">
                                            {{ Form::radio($field->field_name, 'yes', false, ['class' => 'form-check-input', 'id' => $field->field_name . '_yes', $field->is_required ? 'required' : '']) }}
                                            {{ Form::label($field->field_name . '_yes', __('Yes'), ['class' => 'form-check-label']) }}
                                        </div>
                                        <div class="form-check form-check-inline">
                                            {{ Form::radio($field->field_name, 'no', false, ['class' => 'form-check-input', 'id' => $field->field_name . '_no']) }}
                                            {{ Form::label($field->field_name . '_no', __('No'), ['class' => 'form-check-label']) }}
                                        </div>
                                    @elseif ($field->field_type == 'doc')
                                        {{ Form::file($field->field_name, ['class' => 'form-control', $field->is_required ? 'required' : '']) }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        @foreach ($customFields as $field)
                            @php
                                // Get original type from field_options
                                $originalType = 'text';
                                if (!empty($field->field_options)) {
                                    $options = is_array($field->field_options) ? $field->field_options : json_decode($field->field_options, true);
                                    if (isset($options['original_type'])) {
                                        $originalType = $options['original_type'];
                                    } else {
                                        // Fallback: map database types
                                        if ($field->field_type == 'doc') {
                                            $originalType = 'docs';
                                        } elseif ($field->field_type == 'input') {
                                            $originalType = 'text';
                                        }
                                    }
                                } else {
                                    // Fallback: map database types
                                    if ($field->field_type == 'doc') {
                                        $originalType = 'docs';
                                    } elseif ($field->field_type == 'input') {
                                        $originalType = 'text';
                                    }
                                }
                            @endphp
                            <div class="mb20">
                                <div class="form-group col-md-12">
                                    {{ Form::label('custom_fields[' . $field->field_name . ']', $field->field_label, ['class' => 'form-label']) }}
                                    @if ($originalType == 'text')
                                        {{ Form::text('custom_fields[' . $field->field_name . ']', null, ['class' => 'form-control', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : '']) }}
                                    @elseif ($originalType == 'number')
                                        {{ Form::number('custom_fields[' . $field->field_name . ']', null, ['class' => 'form-control', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : '']) }}
                                    @elseif ($originalType == 'docs')
                                        {{ Form::file('custom_fields[' . $field->field_name . ']', ['class' => 'form-control', $field->is_required ? 'required' : '']) }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="mb20">
                            <div class="form-group  col-md-12">
                                {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
                                {{ Form::text('subject', null, ['class' => 'form-control', 'placeholder' => __('Enter contact subject'), 'required' => 'required']) }}
                            </div>
                        </div>

                        <div class="mb15">
                            <div class="form-group col-md-12">
                                {{ Form::label('message', __('Message'), ['class' => 'form-label']) }}
                                {{ Form::textarea('message', null, [
                                    'class' => 'form-control',
                                    'rows' => 5,
                                    'required' => 'required',
                                    'placeholder' => __('Enter message'),
                                    'style' => 'height:auto; min-height:100px;',
                                ]) }}
                            </div>
                        </div>

                        <div class="d-grid mb20">
                            {{ Form::submit(__('Send Messages'), ['class' => 'ud-btn btn-thm']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
