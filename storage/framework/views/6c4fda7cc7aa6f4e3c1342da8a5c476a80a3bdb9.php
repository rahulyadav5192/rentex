<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Enquiry')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('enquiry.index')); ?>"><?php echo e(__('Enquiry')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Edit Enquiry')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Edit Enquiry')); ?></h5>
                        </div>
                        <div class="col-auto">
                            <a href="<?php echo e(route('enquiry.index')); ?>" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> <?php echo e(__('Back')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php echo e(Form::open(['route' => ['enquiry.update', $enquiry->id], 'method' => 'PUT'])); ?>

                    
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger" role="alert"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                    <?php if(session('success')): ?>
                        <div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('name', $enquiry->name, ['class' => 'form-control', 'required' => 'required'])); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::email('email', $enquiry->email, ['class' => 'form-control', 'required' => 'required'])); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('contact_number', __('Contact Number'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('contact_number', $enquiry->contact_number, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('subject', __('Subject'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('subject', $enquiry->subject, ['class' => 'form-control', 'required' => 'required'])); ?>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <?php echo e(Form::label('message', __('Message'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::textarea('message', $enquiry->message, ['class' => 'form-control', 'rows' => 5, 'required' => 'required'])); ?>

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-end">
                        <?php echo e(Form::submit(__('Update'), ['class' => 'btn btn-primary'])); ?>

                    </div>
                    
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/enquiry/edit.blade.php ENDPATH**/ ?>