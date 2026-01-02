{{ Form::open(['url' => 'maintainer', 'enctype' => 'multipart/form-data', 'id' => 'maintainer-create-form']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6 col-lg-6">
            {{ Form::label('first_name', __('First Name'), ['class' => 'form-label']) }}
            {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => __('Enter First Name'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{ Form::label('last_name', __('Last Name'), ['class' => 'form-label']) }}
            {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Last Name'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
            {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Email'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-6 col-lg-6">
            {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}
            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter Password'), 'required' => 'required']) }}
        </div>
        <div class="form-group">
            {{ Form::label('phone_number', __('Phone Number'), ['class' => 'form-label']) }}
            {{ Form::text('phone_number', null, ['class' => 'form-control', 'placeholder' => __('Enter Phone Number'), 'required' => 'required']) }}
            <small class="form-text text-muted">
                {{ __('Please enter the number with country code. e.g., +91XXXXXXXXXX') }}
            </small>
        </div>
        <div class="form-group">
            {{ Form::label('property_id', __('Property'), ['class' => 'form-label']) }}
            {{ Form::select('property_id[]', $property, null, ['class' => 'form-control hidesearch', 'id' => 'property', 'multiple', 'required' => 'required']) }}
        </div>

        <div class="form-group">
            {{ Form::label('type_id', __('Type'), ['class' => 'form-label']) }}
            {{ Form::select('type_id', $types, null, ['class' => 'form-control hidesearch', 'required' => 'required']) }}
        </div>
        <div class="form-group">
            {{ Form::label('profile', __('Profile'), ['class' => 'form-label']) }}
            {{ Form::file('profile', ['class' => 'form-control']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary btn-rounded']) }}
</div>
{{ Form::close() }}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('maintainer-create-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Clear previous error messages
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                form.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.remove();
                });

                let isValid = true;
                const requiredFields = [
                    { name: 'first_name', label: '{{ __('First Name') }}' },
                    { name: 'last_name', label: '{{ __('Last Name') }}' },
                    { name: 'email', label: '{{ __('Email') }}' },
                    { name: 'password', label: '{{ __('Password') }}' },
                    { name: 'phone_number', label: '{{ __('Phone Number') }}' },
                    { name: 'type_id', label: '{{ __('Type') }}' }
                ];

                // Validate text/email/password fields
                requiredFields.forEach(field => {
                    const input = form.querySelector('[name="' + field.name + '"]');
                    if (input && !input.value.trim()) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = field.label + ' {{ __('is required') }}';
                        input.parentElement.appendChild(errorDiv);
                    }
                });

                // Validate property_id (multiple select)
                const propertySelect = form.querySelector('[name="property_id[]"]');
                if (propertySelect && (!propertySelect.selectedOptions || propertySelect.selectedOptions.length === 0)) {
                    isValid = false;
                    propertySelect.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = '{{ __('Property') }} {{ __('is required') }}';
                    propertySelect.parentElement.appendChild(errorDiv);
                }

                if (!isValid) {
                    e.preventDefault();
                    e.stopPropagation();
                    // Scroll to first error
                    const firstError = form.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                }
            });
        }
    });
</script>
