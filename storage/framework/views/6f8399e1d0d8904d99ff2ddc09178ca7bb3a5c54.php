<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Enquiry')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Enquiry')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Enquiry List')); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Property')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Email')); ?></th>
                                    <th><?php echo e(__('Phone')); ?></th>
                                    <th><?php echo e(__('Subject')); ?></th>
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th class="text-end"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $enquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $property = $enquiry->property;
                                        $propertyName = $property && $property->parent_id == \Auth::user()->id ? $property->name : __('N/A');
                                    ?>
                                    <tr>
                                        <td><?php echo e($propertyName); ?></td>
                                        <td><?php echo e($enquiry->name); ?></td>
                                        <td><?php echo e($enquiry->email); ?></td>
                                        <td><?php echo e($enquiry->contact_number ?? '-'); ?></td>
                                        <td><?php echo e($enquiry->subject); ?></td>
                                        <td><?php echo e(dateFormat($enquiry->created_at)); ?></td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <?php if(Gate::check('show enquiry')): ?>
                                                    <a href="<?php echo e(route('enquiry.show', $enquiry->id)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('View')); ?>">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if(Gate::check('edit enquiry')): ?>
                                                    <a href="<?php echo e(route('enquiry.edit', $enquiry->id)); ?>" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if(Gate::check('delete enquiry')): ?>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['enquiry.destroy', $enquiry->id], 'id' => 'delete-form-' . $enquiry->id, 'style' => 'display:inline']); ?>

                                                    <a href="#" class="btn btn-sm btn-danger confirm_dialog" data-form="delete-form-<?php echo e($enquiry->id); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Delete')); ?>">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/enquiry/index.blade.php ENDPATH**/ ?>