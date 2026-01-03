<?php $__env->startSection('content'); ?>
    <section class="our-login contact-background">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                    <div class="main-title text-center">
                        <h2 class="title"><?php echo e(__('Get in Touch')); ?></h2>
                        <p class="paragraph">
                            <?php echo e(__('We’re here to help—reach out to us anytime with your questions or feedback.')); ?></p>
                    </div>
                </div>
            </div>

            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="col-xl-6 mx-auto">
                    <?php echo e(Form::open(['route' => ['contact-us', 'code' => $user->code], 'method' => 'post'])); ?>


                    <?php if(session('error')): ?>
                        <div class="alert alert-danger" role="alert"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                    <?php if(session('success')): ?>
                        <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

                    <div class="log-reg-form search-modal form-style1 bgc-white p50 p30-sm default-box-shadow1 bdrs12">
                        <?php if(!empty($propertyId)): ?>
                            <?php echo e(Form::hidden('property_id', \Crypt::encrypt($propertyId))); ?>

                            <?php if(!empty($property)): ?>
                                <div class="alert alert-info mb-3" role="alert">
                                    <strong><?php echo e(__('Inquiry about:')); ?></strong> <?php echo e(ucfirst($property->name)); ?>

                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php
                            // Get default fields (name, email, phone) and custom fields
                            $defaultFields = $leadFormFields->where('is_default', true)->sortBy('sort_order');
                            $customFields = $leadFormFields->where('is_default', false)->sortBy('sort_order');
                        ?>
                        
                        <?php $__currentLoopData = $defaultFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb20">
                                <div class="form-group col-md-12">
                                    <?php echo e(Form::label($field->field_name, $field->field_label, ['class' => 'form-label'])); ?>

                                    <?php if($field->field_type == 'input'): ?>
                                        <?php if($field->field_name == 'email'): ?>
                                            <?php echo e(Form::email($field->field_name, null, ['class' => 'form-control', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : ''])); ?>

                                        <?php elseif($field->field_name == 'phone'): ?>
                                            <?php echo e(Form::tel($field->field_name, null, ['class' => 'form-control', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : ''])); ?>

                                        <?php else: ?>
                                            <?php echo e(Form::text($field->field_name, null, ['class' => 'form-control', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : ''])); ?>

                                        <?php endif; ?>
                                    <?php elseif($field->field_type == 'select'): ?>
                                        <?php echo e(Form::select($field->field_name, ['' => __('Select') . ' ' . $field->field_label] + ($field->field_options ?? []), null, ['class' => 'form-control', $field->is_required ? 'required' : ''])); ?>

                                    <?php elseif($field->field_type == 'checkbox'): ?>
                                        <div class="form-check">
                                            <?php echo e(Form::checkbox($field->field_name, 1, false, ['class' => 'form-check-input', 'id' => $field->field_name, $field->is_required ? 'required' : ''])); ?>

                                            <?php echo e(Form::label($field->field_name, $field->field_label, ['class' => 'form-check-label'])); ?>

                                        </div>
                                    <?php elseif($field->field_type == 'yes_no'): ?>
                                        <div class="form-check form-check-inline">
                                            <?php echo e(Form::radio($field->field_name, 'yes', false, ['class' => 'form-check-input', 'id' => $field->field_name . '_yes', $field->is_required ? 'required' : ''])); ?>

                                            <?php echo e(Form::label($field->field_name . '_yes', __('Yes'), ['class' => 'form-check-label'])); ?>

                                        </div>
                                        <div class="form-check form-check-inline">
                                            <?php echo e(Form::radio($field->field_name, 'no', false, ['class' => 'form-check-input', 'id' => $field->field_name . '_no'])); ?>

                                            <?php echo e(Form::label($field->field_name . '_no', __('No'), ['class' => 'form-check-label'])); ?>

                                        </div>
                                    <?php elseif($field->field_type == 'doc'): ?>
                                        <?php echo e(Form::file($field->field_name, ['class' => 'form-control', $field->is_required ? 'required' : ''])); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
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
                            ?>
                            <div class="mb20">
                                <div class="form-group col-md-12">
                                    <?php echo e(Form::label('custom_fields[' . $field->field_name . ']', $field->field_label, ['class' => 'form-label'])); ?>

                                    <?php if($originalType == 'text'): ?>
                                        <?php echo e(Form::text('custom_fields[' . $field->field_name . ']', null, ['class' => 'form-control', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : ''])); ?>

                                    <?php elseif($originalType == 'number'): ?>
                                        <?php echo e(Form::number('custom_fields[' . $field->field_name . ']', null, ['class' => 'form-control', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : ''])); ?>

                                    <?php elseif($originalType == 'docs'): ?>
                                        <?php echo e(Form::file('custom_fields[' . $field->field_name . ']', ['class' => 'form-control', $field->is_required ? 'required' : ''])); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <div class="mb20">
                            <div class="form-group  col-md-12">
                                <?php echo e(Form::label('subject', __('Subject'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('subject', null, ['class' => 'form-control', 'placeholder' => __('Enter contact subject'), 'required' => 'required'])); ?>

                            </div>
                        </div>

                        <div class="mb15">
                            <div class="form-group col-md-12">
                                <?php echo e(Form::label('message', __('Message'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::textarea('message', null, [
                                    'class' => 'form-control',
                                    'rows' => 5,
                                    'required' => 'required',
                                    'placeholder' => __('Enter message'),
                                    'style' => 'height:auto; min-height:100px;',
                                ])); ?>

                            </div>
                        </div>

                        <div class="d-grid mb20">
                            <?php echo e(Form::submit(__('Send Messages'), ['class' => 'ud-btn btn-thm'])); ?>

                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('theme.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/contact.blade.php ENDPATH**/ ?>