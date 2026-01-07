@extends('theme.main')

@section('content')
    <section class="our-login contact-background py-12 sm:py-16 lg:py-20 bg-background-light dark:bg-background-dark transition-colors duration-300">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                    <div class="main-title text-center">
                        <h2 class="title text-text-main-light dark:text-text-main-dark">{{ __('Get in Touch') }}</h2>
                        <p class="paragraph text-text-sub-light dark:text-text-sub-dark">
                            {{ __('We are here to help—reach out to us anytime with your questions or feedback.') }}</p>
                    </div>
                </div>
            </div>

            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="col-xl-6 mx-auto">
                    {{ Form::open(['route' => ['contact-us', 'code' => $user->code], 'method' => 'post']) }}

                    @if (session('error'))
                        <div id="alert-message" class="alert alert-danger bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-lg p-4 mb-4" role="alert">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div id="alert-message" class="alert alert-success bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg p-4 mb-4" role="alert">{{ session('success') }}</div>
                    @endif

                    <div class="log-reg-form search-modal form-style1 bg-card-light dark:bg-card-dark p-8 sm:p-10 sm:p-12 rounded-xl shadow-lg dark:shadow-none dark:border dark:border-border-dark">
                        @if (!empty($propertyId))
                            {{ Form::hidden('property_id', \Crypt::encrypt($propertyId)) }}
                            @if (!empty($property))
                                <div class="alert alert-info mb-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 rounded-lg p-4" role="alert">
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
                            <div class="mb-5">
                                <div class="form-group col-md-12">
                                    {{ Form::label($field->field_name, $field->field_label, ['class' => 'form-label text-text-main-light dark:text-text-main-dark font-medium mb-2 block']) }}
                                    @if ($field->field_type == 'input')
                                        @if ($field->field_name == 'email')
                                            {{ Form::email($field->field_name, null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : '']) }}
                                        @elseif ($field->field_name == 'phone')
                                            {{ Form::tel($field->field_name, null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : '']) }}
                                        @else
                                            {{ Form::text($field->field_name, null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : '']) }}
                                        @endif
                                    @elseif ($field->field_type == 'select')
                                        {{ Form::select($field->field_name, ['' => __('Select') . ' ' . $field->field_label] + ($field->field_options ?? []), null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', $field->is_required ? 'required' : '']) }}
                                    @elseif ($field->field_type == 'checkbox')
                                        <div class="form-check">
                                            {{ Form::checkbox($field->field_name, 1, false, ['class' => 'form-check-input w-4 h-4 text-primary bg-surface-light dark:bg-surface-dark border-border-light dark:border-border-dark rounded focus:ring-primary focus:ring-2', 'id' => $field->field_name, $field->is_required ? 'required' : '']) }}
                                            {{ Form::label($field->field_name, $field->field_label, ['class' => 'form-check-label text-text-main-light dark:text-text-main-dark ml-2']) }}
                                        </div>
                                    @elseif ($field->field_type == 'yes_no')
                                        <div class="form-check form-check-inline">
                                            {{ Form::radio($field->field_name, 'yes', false, ['class' => 'form-check-input w-4 h-4 text-primary bg-surface-light dark:bg-surface-dark border-border-light dark:border-border-dark focus:ring-primary focus:ring-2', 'id' => $field->field_name . '_yes', $field->is_required ? 'required' : '']) }}
                                            {{ Form::label($field->field_name . '_yes', __('Yes'), ['class' => 'form-check-label text-text-main-light dark:text-text-main-dark ml-2']) }}
                                        </div>
                                        <div class="form-check form-check-inline">
                                            {{ Form::radio($field->field_name, 'no', false, ['class' => 'form-check-input w-4 h-4 text-primary bg-surface-light dark:bg-surface-dark border-border-light dark:border-border-dark focus:ring-primary focus:ring-2', 'id' => $field->field_name . '_no']) }}
                                            {{ Form::label($field->field_name . '_no', __('No'), ['class' => 'form-check-label text-text-main-light dark:text-text-main-dark ml-2']) }}
                            </div>
                                    @elseif ($field->field_type == 'doc')
                                        {{ Form::file($field->field_name, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', $field->is_required ? 'required' : '']) }}
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
                            <div class="mb-5">
                                <div class="form-group col-md-12">
                                    {{ Form::label('custom_fields[' . $field->field_name . ']', $field->field_label, ['class' => 'form-label text-text-main-light dark:text-text-main-dark font-medium mb-2 block']) }}
                                    @if ($originalType == 'text')
                                        {{ Form::text('custom_fields[' . $field->field_name . ']', null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : '']) }}
                                    @elseif ($originalType == 'number')
                                        {{ Form::number('custom_fields[' . $field->field_name . ']', null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : '']) }}
                                    @elseif ($originalType == 'docs')
                                        {{ Form::file('custom_fields[' . $field->field_name . ']', ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', $field->is_required ? 'required' : '']) }}
                                    @endif
                        </div>
                            </div>
                        @endforeach
                        
                        <div class="mb-5">
                            <div class="form-group  col-md-12">
                                {{ Form::label('subject', __('Subject'), ['class' => 'form-label text-text-main-light dark:text-text-main-dark font-medium mb-2 block']) }}
                                {{ Form::text('subject', null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter contact subject'), 'required' => 'required']) }}
                            </div>
                        </div>

                        <div class="mb-5">
                            <div class="form-group col-md-12">
                                {{ Form::label('message', __('Message'), ['class' => 'form-label text-text-main-light dark:text-text-main-dark font-medium mb-2 block']) }}
                                {{ Form::textarea('message', null, [
                                    'class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors resize-y',
                                    'rows' => 5,
                                    'required' => 'required',
                                    'placeholder' => __('Enter message'),
                                    'style' => 'height:auto; min-height:100px;',
                                ]) }}
                            </div>
                        </div>

                        <div class="d-grid mb-5">
                            {{ Form::submit(__('Send Messages'), ['class' => 'ud-btn btn-thm bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-gray-800']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-page')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's an alert message
        const alertMessage = document.getElementById('alert-message');
        if (alertMessage) {
            // Scroll to alert with offset for header
            setTimeout(function() {
                // Get header height dynamically or use fixed value
                const header = document.querySelector('header, nav, .navbar');
                const headerHeight = header ? header.offsetHeight : 130;
                const alertPosition = alertMessage.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
                
                window.scrollTo({
                    top: Math.max(0, alertPosition),
                    behavior: 'smooth'
                });
            }, 300); // Small delay to ensure page is fully rendered
        }
    });
</script>
@endpush
