<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Units')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Units')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Unit List')); ?></h5>
                        </div>
                        <?php if(Gate::check('create unit')): ?>
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="<?php echo e(route('unit.direct-create')); ?>" data-title="<?php echo e(__('Create unit')); ?>"> <i
                                        class="ti ti-circle-plus align-text-bottom"></i> <?php echo e(__('Create Unit')); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Rent Type')); ?></th>
                                    <th><?php echo e(__('Rent')); ?></th>
                                    <th><?php echo e(__('Rent Duration')); ?></th>
                                    <th><?php echo e(__('Property')); ?></th>
                                    <th><?php echo e(__('Tenant')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <?php if(Gate::check('edit unit') || Gate::check('delete unit')): ?>
                                        <th class="text-right"><?php echo e(__('Action')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                

                                    <tr>
                                        <td><?php echo e(ucfirst($unit->name)); ?> </td>
                                        <td><?php echo e($unit->rent_type); ?> </td>
                                        <td><?php echo e(priceFormat($unit->rent)); ?> </td>
                                        <td>
                                            <?php if($unit->rent_type == 'custom'): ?>
                                                <span><?php echo e(__('Start Date')); ?> :- </span><?php echo e(dateFormat($unit->start_date)); ?>

                                                <br>
                                                <span><?php echo e(__('End Date')); ?> :- </span><?php echo e(dateFormat($unit->end_date)); ?>

                                                <br>
                                                <span><?php echo e(__('Payment Due Date')); ?> :-
                                                </span><?php echo e(dateFormat($unit->payment_due_date)); ?>

                                            <?php else: ?>
                                                <?php echo e($unit->rent_duration); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(!empty($unit->properties) ? $unit->properties->name : '-'); ?> </td>
                                        <td><?php echo e(!empty($unit->tenants()) && !empty($unit->tenants()->user) ? $unit->tenants()->user->name : '-'); ?>

                                        </td>
                                        <?php if($unit->is_occupied == 1): ?>
                                            <td class="text-danger">
                                                <i class="fas fa-circle f-10 m-r-10"></i>
                                                <?php echo e(__('Occupied')); ?>

                                            </td>
                                        <?php else: ?>
                                            <td class="text-success">
                                                <i class="fas fa-circle f-10 m-r-10"></i>
                                                <?php echo e(__('Vacant')); ?>

                                            </td>
                                        <?php endif; ?>

                                        <?php if(Gate::check('edit unit') || Gate::check('delete unit')): ?>
                                            <td class="text-right">
                                                <div class="cart-action">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['unit.destroy', [$unit->property_id, $unit->id]]]); ?>


                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show unit')): ?>
                                                        <a class="avtar avtar-xs btn-link-warning text-warning"
                                                            href="<?php echo e(route('unit.show', \Crypt::encrypt($unit->id))); ?>"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Show')); ?>">
                                                            <i data-feather="eye"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit unit')): ?>
                                                        <a class="avtar avtar-xs btn-link-secondary text-secondary customModal"
                                                            data-url="<?php echo e(route('unit.edit', [$unit->property_id, $unit->id])); ?>"
                                                            href="#" data-size="lg" data-title="<?php echo e(__('Edit Unit')); ?>"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                            <i data-feather="edit"></i></a>
                                                    <?php endif; ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete unit')): ?>
                                                        <a class="avtar avtar-xs btn-link-danger text-danger confirm_dialog"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Detete')); ?>" href="#"> <i
                                                                data-feather="trash-2"></i></a>
                                                    <?php endif; ?>
                                                    <?php echo Form::close(); ?>

                                                </div>
                                            </td>
                                        <?php endif; ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/unit/index.blade.php ENDPATH**/ ?>