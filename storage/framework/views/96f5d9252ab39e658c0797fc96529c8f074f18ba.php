<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Enquiry Details')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('enquiry.index')); ?>"><?php echo e(__('Enquiry')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Enquiry Details')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Enquiry Details')); ?></h5>
                        </div>
                        <div class="col-auto">
                            <a href="<?php echo e(route('enquiry.index')); ?>" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> <?php echo e(__('Back')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3"><?php echo e(__('Basic Information')); ?></h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted"><?php echo e(__('Name')); ?>:</td>
                                    <td><strong><?php echo e($enquiry->name); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('Email')); ?>:</td>
                                    <td><strong><?php echo e($enquiry->email); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('Phone')); ?>:</td>
                                    <td><strong><?php echo e($enquiry->contact_number ?? '-'); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('Subject')); ?>:</td>
                                    <td><strong><?php echo e($enquiry->subject); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted"><?php echo e(__('Date')); ?>:</td>
                                    <td><strong><?php echo e(dateFormat($enquiry->created_at)); ?></strong></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3"><?php echo e(__('Property Information')); ?></h6>
                            <?php if($property): ?>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted"><?php echo e(__('Property Name')); ?>:</td>
                                        <td><strong><a href="<?php echo e(route('property.show', \Crypt::encrypt($property->id))); ?>" target="_blank"><?php echo e($property->name); ?></a></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><?php echo e(__('Address')); ?>:</td>
                                        <td><strong><?php echo e($property->address ?? '-'); ?></strong></td>
                                    </tr>
                                </table>
                            <?php else: ?>
                                <p class="text-muted"><?php echo e(__('No property associated with this enquiry.')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="mb-3"><?php echo e(__('Message')); ?></h6>
                            <div class="p-3 bg-light rounded">
                                <p class="mb-0"><?php echo e($enquiry->message); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <?php if(!empty($enquiry->custom_fields)): ?>
                        <?php
                            $customFields = is_string($enquiry->custom_fields) ? json_decode($enquiry->custom_fields, true) : $enquiry->custom_fields;
                        ?>
                        <?php if(!empty($customFields)): ?>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="mb-3"><?php echo e(__('Additional Information')); ?></h6>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('Field')); ?></th>
                                                <th><?php echo e(__('Value')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $customFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fieldName => $fieldValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $field = $leadFormFields->where('field_name', $fieldName)->first();
                                                    $fieldLabel = $field ? $field->field_label : ucfirst(str_replace('_', ' ', $fieldName));
                                                ?>
                                                <tr>
                                                    <td class="text-muted"><?php echo e($fieldLabel); ?>:</td>
                                                    <td>
                                                        <?php if($field && $field->field_type == 'doc' && is_string($fieldValue) && strpos($fieldValue, 'upload/') === 0): ?>
                                                            <a href="<?php echo e(\Storage::disk('public')->url($fieldValue)); ?>" target="_blank" class="btn btn-sm btn-primary">
                                                                <i class="ti ti-download"></i> <?php echo e(__('Download')); ?>

                                                            </a>
                                                        <?php else: ?>
                                                            <strong><?php echo e(is_array($fieldValue) ? json_encode($fieldValue) : $fieldValue); ?></strong>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/enquiry/show.blade.php ENDPATH**/ ?>