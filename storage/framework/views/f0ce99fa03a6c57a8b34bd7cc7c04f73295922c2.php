<?php $__env->startSection('content'); ?>
    <section class="our-login contact-background py-12 sm:py-16 lg:py-20 bg-background-light dark:bg-background-dark transition-colors duration-300">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto wow fadeInUp" data-wow-delay="300ms">
                    <div class="main-title text-center">
                        <h2 class="title text-text-main-light dark:text-text-main-dark"><?php echo e(__('Get in Touch')); ?></h2>
                        <p class="paragraph text-text-sub-light dark:text-text-sub-dark">
                            <?php echo e(__('We are here to help—reach out to us anytime with your questions or feedback.')); ?></p>
                    </div>
                </div>
            </div>

            <div class="row wow fadeInRight" data-wow-delay="300ms">
                <div class="col-xl-6 mx-auto">
                    <?php echo e(Form::open(['route' => ['contact-us', 'code' => $user->code], 'method' => 'post'])); ?>


                    <?php if(session('error')): ?>
                        <div id="alert-message" class="alert alert-danger bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-lg p-4 mb-4" role="alert"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                    <?php if(session('success')): ?>
                        <div id="alert-message" class="alert alert-success bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg p-4 mb-4" role="alert"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

                    <div class="log-reg-form search-modal form-style1 bg-card-light dark:bg-card-dark p-8 sm:p-10 sm:p-12 rounded-xl shadow-lg dark:shadow-none dark:border dark:border-border-dark">
                        <?php if(!empty($propertyId)): ?>
                            <?php echo e(Form::hidden('property_id', \Crypt::encrypt($propertyId))); ?>

                            <?php if(!empty($property)): ?>
                                <div class="alert alert-info mb-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 rounded-lg p-4" role="alert">
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
                            <div class="mb-5">
                                <div class="form-group col-md-12">
                                    <?php echo e(Form::label($field->field_name, $field->field_label, ['class' => 'form-label text-text-main-light dark:text-text-main-dark font-medium mb-2 block'])); ?>

                                    <?php if($field->field_type == 'input'): ?>
                                        <?php if($field->field_name == 'email'): ?>
                                            <?php echo e(Form::email($field->field_name, null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : ''])); ?>

                                        <?php elseif($field->field_name == 'phone'): ?>
                                            <?php echo e(Form::tel($field->field_name, null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : ''])); ?>

                                        <?php else: ?>
                                            <?php echo e(Form::text($field->field_name, null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : ''])); ?>

                                        <?php endif; ?>
                                    <?php elseif($field->field_type == 'select'): ?>
                                        <?php echo e(Form::select($field->field_name, ['' => __('Select') . ' ' . $field->field_label] + ($field->field_options ?? []), null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', $field->is_required ? 'required' : ''])); ?>

                                    <?php elseif($field->field_type == 'checkbox'): ?>
                                        <div class="form-check">
                                            <?php echo e(Form::checkbox($field->field_name, 1, false, ['class' => 'form-check-input w-4 h-4 text-primary bg-surface-light dark:bg-surface-dark border-border-light dark:border-border-dark rounded focus:ring-primary focus:ring-2', 'id' => $field->field_name, $field->is_required ? 'required' : ''])); ?>

                                            <?php echo e(Form::label($field->field_name, $field->field_label, ['class' => 'form-check-label text-text-main-light dark:text-text-main-dark ml-2'])); ?>

                                        </div>
                                    <?php elseif($field->field_type == 'yes_no'): ?>
                                        <div class="form-check form-check-inline">
                                            <?php echo e(Form::radio($field->field_name, 'yes', false, ['class' => 'form-check-input w-4 h-4 text-primary bg-surface-light dark:bg-surface-dark border-border-light dark:border-border-dark focus:ring-primary focus:ring-2', 'id' => $field->field_name . '_yes', $field->is_required ? 'required' : ''])); ?>

                                            <?php echo e(Form::label($field->field_name . '_yes', __('Yes'), ['class' => 'form-check-label text-text-main-light dark:text-text-main-dark ml-2'])); ?>

                                        </div>
                                        <div class="form-check form-check-inline">
                                            <?php echo e(Form::radio($field->field_name, 'no', false, ['class' => 'form-check-input w-4 h-4 text-primary bg-surface-light dark:bg-surface-dark border-border-light dark:border-border-dark focus:ring-primary focus:ring-2', 'id' => $field->field_name . '_no'])); ?>

                                            <?php echo e(Form::label($field->field_name . '_no', __('No'), ['class' => 'form-check-label text-text-main-light dark:text-text-main-dark ml-2'])); ?>

                            </div>
                                    <?php elseif($field->field_type == 'doc'): ?>
                                        <?php echo e(Form::file($field->field_name, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', $field->is_required ? 'required' : ''])); ?>

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
                            <div class="mb-5">
                                <div class="form-group col-md-12">
                                    <?php echo e(Form::label('custom_fields[' . $field->field_name . ']', $field->field_label, ['class' => 'form-label text-text-main-light dark:text-text-main-dark font-medium mb-2 block'])); ?>

                                    <?php if($originalType == 'text'): ?>
                                        <?php echo e(Form::text('custom_fields[' . $field->field_name . ']', null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : ''])); ?>

                                    <?php elseif($originalType == 'number'): ?>
                                        <?php echo e(Form::number('custom_fields[' . $field->field_name . ']', null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter') . ' ' . strtolower($field->field_label), $field->is_required ? 'required' : ''])); ?>

                                    <?php elseif($originalType == 'docs'): ?>
                                        <?php echo e(Form::file('custom_fields[' . $field->field_name . ']', ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', $field->is_required ? 'required' : ''])); ?>

                                    <?php endif; ?>
                        </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <div class="mb-5">
                            <div class="form-group  col-md-12">
                                <?php echo e(Form::label('subject', __('Subject'), ['class' => 'form-label text-text-main-light dark:text-text-main-dark font-medium mb-2 block'])); ?>

                                <?php echo e(Form::text('subject', null, ['class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors', 'placeholder' => __('Enter contact subject'), 'required' => 'required'])); ?>

                            </div>
                        </div>

                        <div class="mb-5">
                            <div class="form-group col-md-12">
                                <?php echo e(Form::label('message', __('Message'), ['class' => 'form-label text-text-main-light dark:text-text-main-dark font-medium mb-2 block'])); ?>

                                <?php echo e(Form::textarea('message', null, [
                                    'class' => 'form-control w-full px-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark placeholder-text-sub-light dark:placeholder-text-sub-dark focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors resize-y',
                                    'rows' => 5,
                                    'required' => 'required',
                                    'placeholder' => __('Enter message'),
                                    'style' => 'height:auto; min-height:100px;',
                                ])); ?>

                            </div>
                        </div>

                        <div class="d-grid mb-5">
                            <?php echo e(Form::submit(__('Send Messages'), ['class' => 'ud-btn btn-thm bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-gray-800'])); ?>

                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('theme.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/contact.blade.php ENDPATH**/ ?>