<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Tenant')); ?>

<?php $__env->stopSection(); ?>
<?php
    $profile = asset('assets/images/admin/user.png');
?>

<?php $__env->startPush('head-page'); ?>
    <style>
        .tenant-card-modern {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }
        .tenant-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        }
        .tenant-card-modern .dropdown-item:hover {
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
        .tenant-card-modern h4 {
            color: #000 !important;
            font-weight: 600 !important;
        }
        .tenant-card-modern h4:hover {
            color: #333 !important;
        }
        .tenant-card-modern .text-muted {
            color: #666 !important;
        }
        .tenant-profile-img {
            position: relative;
            z-index: 1;
        }
        .tenant-profile-default {
            z-index: 0;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle image load errors
            document.querySelectorAll('.tenant-profile-img').forEach(function(img) {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    var defaultIcon = this.nextElementSibling;
                    if (defaultIcon && defaultIcon.classList.contains('tenant-profile-default')) {
                        defaultIcon.style.display = 'flex';
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Tenant')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Tenant List')); ?></h5>
                        </div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create tenant')): ?>
                            <div class="col-auto">
                                <a class="btn btn-secondary" href="<?php echo e(route('tenant.create')); ?>" data-size="md"> <i
                                        class="ti ti-circle-plus align-text-bottom" style="color: #fff;"></i> <?php echo e(__('Create Tenant')); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mt-4 g-4">
                    <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xxl-3 col-xl-4 col-md-6">
                            <div class="card border-0 shadow-sm h-100 tenant-card-modern">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0 position-relative" style="width: 70px; height: 70px;">
                                            <?php
                                                $profileUrl = !empty($tenant->user->profile) ? fetch_file($tenant->user->profile, 'upload/profile/') : '';
                                                $profileUrl = !empty($profileUrl) ? $profileUrl : $profile;
                                            ?>
                                            <img class="img-fluid rounded-circle tenant-profile-img"
                                                src="<?php echo e($profileUrl); ?>"
                                                alt="Profile Image"
                                                style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #000; display: block;"
                                                onerror="this.src='<?php echo e($profile); ?>'; this.onerror=null;">
                                        </div>
                                        <?php if(Gate::check('edit tenant') || Gate::check('delete tenant') || Gate::check('show tenant')): ?>
                                            <div class="flex-shrink-0 ms-auto">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle text-dark opacity-75 arrow-none bg-white rounded-circle d-flex align-items-center justify-content-center" href="#"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="text-decoration: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 36px; height: 36px; line-height: 1;">
                                                        <i class="ti ti-dots" style="font-size: 18px; vertical-align: middle;"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 8px; min-width: 180px;">
                                                        <a class="dropdown-item text-dark d-flex align-items-center py-2"
                                                            href="<?php echo e(route('tenant.edit',\Crypt::encrypt($tenant->id))); ?>"
                                                            style="transition: background 0.2s;">
                                                            <i class="material-icons-two-tone me-2" style="font-size: 20px;">edit</i>
                                                            <?php echo e(__('Edit Tenant')); ?>

                                                        </a>

                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show tenant')): ?>
                                                            <a class="dropdown-item text-dark d-flex align-items-center py-2"
                                                                href="<?php echo e(route('tenant.show',\Crypt::encrypt($tenant->id))); ?>"
                                                                style="transition: background 0.2s;">
                                                                <i class="material-icons-two-tone me-2" style="font-size: 20px;">remove_red_eye</i>
                                                                <?php echo e(__('View Tenant')); ?>

                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete tenant')): ?>
                                                            <?php echo Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['tenant.destroy', $tenant->id],
                                                                'id' => 'tenant-' . $tenant->id,
                                                            ]); ?>

                                                            <a class="dropdown-item text-dark d-flex align-items-center py-2 confirm_dialog" href="#"
                                                                style="transition: background 0.2s;">
                                                                <i class="material-icons-two-tone me-2" style="font-size: 20px;">delete</i>
                                                                <?php echo e(__('Delete Tenant')); ?>

                                                            </a>
                                                            <?php echo Form::close(); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?php echo e(route('tenant.show', \Crypt::encrypt($tenant->id))); ?>" style="text-decoration: none;">
                                        <h4 class="mb-2"><?php echo e(ucfirst(!empty($tenant->user) ? $tenant->user->first_name : '') . ' ' . ucfirst(!empty($tenant->user) ? $tenant->user->last_name : '')); ?>

                                        </h4>
                                    </a>
                                    <h6 class="text-truncate text-muted d-flex align-items-center mb-3">
                                        <i class="ti ti-mail me-1"></i>
                                        <?php echo e(!empty($tenant->user) ? $tenant->user->email : '-'); ?>

                                    </h6>

                                    <div class="row">
                                        <div class="col-sm-12 mb-3">
                                            <p class="text-muted mb-0" style="font-size: 0.875rem;">
                                                <i class="ti ti-map-pin me-1"></i>
                                                <?php echo e($tenant->address); ?>

                                            </p>
                                        </div>

                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold"><?php echo e(__('Phone')); ?></p>
                                            <h6 class="mb-0 text-dark">
                                                <?php echo e(!empty($tenant->user) ? $tenant->user->phone_number : '-'); ?>

                                            </h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold"><?php echo e(__('Family Member')); ?></p>
                                            <h6 class="mb-0 text-dark"><?php echo e(!empty($tenant->family_member) ? $tenant->family_member : '-'); ?></h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold"><?php echo e(__('Property')); ?></p>
                                            <h6 class="mb-0 text-dark">
                                                <?php echo e(!empty($tenant->properties) ? $tenant->properties->name : '-'); ?>

                                            </h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold"><?php echo e(__('Unit')); ?></p>
                                            <h6 class="mb-0 text-dark">
                                                <?php echo e(!empty($tenant->units) ? $tenant->units->name : '-'); ?>

                                            </h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold"><?php echo e(__('Lease Start Date')); ?></p>
                                            <h6 class="mb-0 text-dark"><?php echo e(dateFormat($tenant->lease_start_date)); ?></h6>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <p class="mb-1 text-muted text-sm fw-semibold"><?php echo e(__('Lease End Date')); ?></p>
                                            <h6 class="mb-0 text-dark"><?php echo e(dateFormat($tenant->lease_end_date)); ?></h6>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/tenant/index.blade.php ENDPATH**/ ?>