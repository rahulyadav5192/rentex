<?php echo e(Form::open(['url' => 'maintainer', 'enctype' => 'multipart/form-data', 'id' => 'maintainer-create-form'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('first_name', __('First Name'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => __('Enter First Name'), 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('last_name', __('Last Name'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Last Name'), 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Email'), 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('password', __('Password'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter Password'), 'required' => 'required'])); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('phone_number', __('Phone Number'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('phone_number', null, ['class' => 'form-control', 'placeholder' => __('Enter Phone Number'), 'required' => 'required'])); ?>

            <small class="form-text text-muted">
                <?php echo e(__('Please enter the number with country code. e.g., +91XXXXXXXXXX')); ?>

            </small>
        </div>
        <div class="form-group">
            <?php echo e(Form::label('property_id', __('Property'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::select('property_id[]', $property, null, ['class' => 'form-control hidesearch', 'id' => 'property', 'multiple', 'required' => 'required'])); ?>

        </div>

        <div class="form-group">
            <?php echo e(Form::label('type_id', __('Type'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::select('type_id', $types, null, ['class' => 'form-control hidesearch', 'required' => 'required'])); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('profile', __('Profile'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::file('profile', ['class' => 'form-control'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo e(Form::submit(__('Create'), ['class' => 'btn btn-secondary btn-rounded'])); ?>

</div>
<?php echo e(Form::close()); ?>


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
                    { name: 'first_name', label: '<?php echo e(__('First Name')); ?>' },
                    { name: 'last_name', label: '<?php echo e(__('Last Name')); ?>' },
                    { name: 'email', label: '<?php echo e(__('Email')); ?>' },
                    { name: 'password', label: '<?php echo e(__('Password')); ?>' },
                    { name: 'phone_number', label: '<?php echo e(__('Phone Number')); ?>' },
                    { name: 'type_id', label: '<?php echo e(__('Type')); ?>' }
                ];

                // Validate text/email/password fields
                requiredFields.forEach(field => {
                    const input = form.querySelector('[name="' + field.name + '"]');
                    if (input && !input.value.trim()) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = field.label + ' <?php echo e(__('is required')); ?>';
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
                    errorDiv.textContent = '<?php echo e(__('Property')); ?> <?php echo e(__('is required')); ?>';
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
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/maintainer/create.blade.php ENDPATH**/ ?>