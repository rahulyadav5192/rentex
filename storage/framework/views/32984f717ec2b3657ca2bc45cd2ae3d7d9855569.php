<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Maintainer')); ?>

<?php $__env->stopSection(); ?>
<?php
    $profile = asset('assets/images/admin/user.png');
?>

<?php $__env->startPush('head-page'); ?>
    <style>
        .maintainer-card-modern {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }
        .maintainer-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        }
        .maintainer-card-modern .dropdown-item:hover {
            background-color: #f5f5f5 !important;
        }
        .card-header {
            background: transparent !important;
            border-bottom: 2px solid #000 !important;
            padding: 1.5rem 0 !important;
        }
        .card-header h5 {
            color: #000 !important;
            font-weight: 700 !important;
            font-size: 1.5rem !important;
        }
        .btn-secondary {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
            border-radius: 8px !important;
            padding: 0.5rem 1.5rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }
        .btn-secondary:hover {
            background-color: #333 !important;
            border-color: #333 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }
        .maintainer-card-modern h4 {
            color: #000 !important;
            font-weight: 600 !important;
        }
        .maintainer-card-modern h4:hover {
            color: #333 !important;
        }
        .maintainer-card-modern .text-muted {
            color: #666 !important;
        }
        .maintainer-card-modern ul {
            margin: 0;
            padding-left: 1.25rem;
        }
        .maintainer-card-modern ul li {
            color: #000;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Maintainer')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Maintainer List')); ?></h5>
                        </div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create maintainer')): ?>
                            <div class="col-auto">
                                <a class="btn btn-secondary customModal" href="#"
                                    data-url="<?php echo e(route('maintainer.create')); ?>" data-title="<?php echo e(__('Create Maintainer')); ?>"
                                    data-size="lg"> <i class="ti ti-circle-plus align-text-bottom" style="color: #fff;"></i>
                                    <?php echo e(__('Create Maintainer')); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mt-4 g-4">
                    <?php $__currentLoopData = $maintainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maintainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xxl-3 col-xl-4 col-md-6">
                            <div class="card border-0 shadow-sm h-100 maintainer-card-modern">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0 position-relative" style="width: 70px; height: 70px;">
                                            <?php
                                                $profileUrl = !empty($maintainer->user->profile) ? fetch_file($maintainer->user->profile, 'upload/profile/') : '';
                                                $profileUrl = !empty($profileUrl) ? $profileUrl : $profile;
                                            ?>
                                            <img class="img-fluid rounded-circle"
                                                src="<?php echo e($profileUrl); ?>"
                                                alt="Profile Image"
                                                style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #000;"
                                                onerror="this.src='<?php echo e($profile); ?>'; this.onerror=null;">
                                        </div>
                                        <?php if(Gate::check('edit maintainer') || Gate::check('delete maintainer') || Gate::check('show maintainer')): ?>
                                            <div class="flex-shrink-0 ms-auto">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle text-dark opacity-75 arrow-none bg-white rounded-circle d-flex align-items-center justify-content-center" href="#"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="text-decoration: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 36px; height: 36px; line-height: 1;">
                                                        <i class="ti ti-dots" style="font-size: 18px; vertical-align: middle;"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 8px; min-width: 180px;">
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit maintainer')): ?>
                                                            <a class="dropdown-item text-dark d-flex align-items-center py-2 customModal" href="#"
                                                                data-url="<?php echo e(route('maintainer.edit', $maintainer->id)); ?>"
                                                                data-title="<?php echo e(__('Edit Maintainer')); ?>"
                                                                style="transition: background 0.2s;">
                                                                <i class="material-icons-two-tone me-2" style="font-size: 20px;">edit</i>
                                                                <?php echo e(__('Edit Maintainer')); ?>

                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete maintainer')): ?>
                                                            <?php echo Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['maintainer.destroy', $maintainer->id],
                                                                'id' => 'maintainer-' . $maintainer->id,
                                                            ]); ?>

                                                            <a class="dropdown-item text-dark d-flex align-items-center py-2 confirm_dialog" href="#"
                                                                style="transition: background 0.2s;">
                                                                <i class="material-icons-two-tone me-2" style="font-size: 20px;">delete</i>
                                                                <?php echo e(__('Delete Maintainer')); ?>

                                                            </a>
                                                            <?php echo Form::close(); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <a class="customModal" href="#"
                                        data-url="<?php echo e(route('maintainer.edit', $maintainer->id)); ?>"
                                        data-title="<?php echo e(__('Edit Maintainer')); ?>"
                                        style="text-decoration: none;">
                                        <h4 class="mb-2"><?php echo e(ucfirst(!empty($maintainer->user) ? $maintainer->user->first_name : '') . ' ' . ucfirst(!empty($maintainer->user) ? $maintainer->user->last_name : '')); ?>

                                        </h4>
                                    </a>
                                    <h6 class="text-truncate text-muted d-flex align-items-center mb-3">
                                        <i class="ti ti-mail me-1"></i>
                                        <?php echo e(!empty($maintainer->user) ? $maintainer->user->email : '-'); ?>

                                    </h6>

                                    <div class="row">
                                        <?php if($maintainer->user->phone_number): ?>
                                            <div class="col-sm-6 mb-3">
                                                <p class="mb-1 text-muted text-sm fw-semibold"><?php echo e(__('Phone')); ?></p>
                                                <h6 class="mb-0 text-dark">
                                                    <?php echo e(!empty($maintainer->user) ? $maintainer->user->phone_number : '-'); ?>

                                                </h6>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold"><?php echo e(__('Type')); ?></p>
                                            <h6 class="mb-0 text-dark">
                                                <?php echo e(!empty($maintainer->types) ? $maintainer->types->title : '-'); ?>

                                            </h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold"><?php echo e(__('Created Date')); ?></p>
                                            <h6 class="mb-0 text-dark">
                                                <?php echo e(dateFormat($maintainer->created_at)); ?>

                                            </h6>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold"><?php echo e(__('Property')); ?></p>
                                            <ul class="mb-0">
                                                <?php $__currentLoopData = $maintainer->properties(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($property->name); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/maintainer/index.blade.php ENDPATH**/ ?>