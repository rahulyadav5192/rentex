<?php $__env->startPush('head-page'); ?>
    <style>
        .maintainer-edit-modern .modal-body {
            padding: 1.5rem;
        }
        .maintainer-edit-modern .form-label {
            color: #000 !important;
            font-weight: 600 !important;
        }
        .maintainer-edit-modern .form-control {
            border-color: #e0e0e0 !important;
            border-radius: 8px !important;
        }
        .maintainer-edit-modern .form-control:focus {
            border-color: #000 !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1) !important;
        }
        .btn-secondary {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
            border-radius: 8px !important;
        }
        .btn-secondary:hover {
            background-color: #333 !important;
            border-color: #333 !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo e(Form::model($maintainer, ['route' => ['maintainer.update', $maintainer->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data'])); ?>

<div class="modal-body maintainer-edit-modern">
    <div class="row">
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('first_name', __('First Name'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('first_name', $user->first_name, ['class' => 'form-control', 'placeholder' => __('Enter First Name')])); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('last_name', __('Last Name'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => __('Enter Last Name')])); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6 ">
            <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => __('Enter Email')])); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('phone_number', __('Phone Number'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('phone_number', $user->phone_number, ['class' => 'form-control', 'placeholder' => __('Enter Phone Number')])); ?>

            <small class="form-text text-muted">
                <?php echo e(__('Please enter the number with country code. e.g., +91XXXXXXXXXX')); ?>

            </small>
        </div>
        <div class="form-group">
            <?php echo e(Form::label('property_id', __('Property'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::select('property_id[]', $property, explode(',', $maintainer->property_id), ['class' => 'form-control hidesearch', 'id' => 'property', 'multiple'])); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('type_id', __('Type'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::select('type_id', $types, null, ['class' => 'form-control hidesearch'])); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('profile', __('Profile'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::file('profile', ['class' => 'form-control'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo e(Form::submit(__('Update'), ['class' => 'btn btn-secondary btn-rounded'])); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/maintainer/edit.blade.php ENDPATH**/ ?>