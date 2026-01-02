<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Maintenance Request Details')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
    </li>
    
    <li class="breadcrumb-item active">
        <a href="#"><?php echo e(__('Maintenance Request Details')); ?></a>
    </li>
<?php $__env->stopSection(); ?>

<?php
    $profile = asset(Storage::url('upload/profile/avatar.png'));
?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-xxl-3">
                            <div class="card border">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <?php
                                                $maintainerProfileUrl = !empty($maintainer->user->profile) ? fetch_file($maintainer->user->profile, 'upload/profile/') : '';
                                                $maintainerProfileUrl = !empty($maintainerProfileUrl) ? $maintainerProfileUrl : $profile;
                                            ?>
                                            <img class="img-radius img-fluid wid-80"
                                                src="<?php echo e($maintainerProfileUrl); ?>"
                                                alt="User image" />
                                        </div>
                                        <div class="flex-grow-1 mx-3">
                                            <h4 class="mb-2">
                                                <?php echo e(ucfirst(!empty($maintainer->user) ? $maintainer->user->first_name : '') . ' ' . ucfirst(!empty($maintainer->user) ? $maintainer->user->last_name : '')); ?>

                                            </h4>
                                            <h5 class="mt-1"><span
                                                    class="badge bg-light-secondary"><?php echo e(ucfirst($maintainer->user->type)); ?></span>
                                            </h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body px-2 pb-0">
                                    <div class="list-group list-group-flush">
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-icons-two-tone f-20">email</i>
                                                </div>
                                                <div class="flex-grow-1 mx-3">
                                                    <h5 class="m-0"><?php echo e(__('Email')); ?></h5>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <small><?php echo e(!empty($maintainer->user) ? $maintainer->user->email : '-'); ?></small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="material-icons-two-tone f-20">phonelink_ring</i>
                                                </div>
                                                <div class="flex-grow-1 mx-3">
                                                    <h5 class="m-0"><?php echo e(__('Phone')); ?></h5>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <small><?php echo e(!empty($maintainer->user) ? $maintainer->user->phone_number : '-'); ?>

                                                    </small>
                                                </div>
                                            </div>
                                        </a>


                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-8 col-xxl-9">
                            <div class="card border">
                                <div class="card-header">
                                    <h5><?php echo e(__('Additional Information')); ?></h5>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td><b class="text-header"><?php echo e(__('Property')); ?></b></td>
                                                    <td>:</td>
                                                    <td><?php echo e(!empty($maintenanceRequest->properties) ? $maintenanceRequest->properties->name : '-'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b class="text-header"><?php echo e(__('Unit')); ?></b></td>
                                                    <td>:</td>
                                                    <td> <?php echo e(!empty($maintenanceRequest->units) ? $maintenanceRequest->units->name : '-'); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b class="text-header"><?php echo e(__('Issue')); ?></b></td>
                                                    <td>:</td>
                                                    <td><?php echo e(!empty($maintenanceRequest->types) ? $maintenanceRequest->types->title : '-'); ?>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b class="text-header"><?php echo e(__('Request Date')); ?></b></td>
                                                    <td>:</td>
                                                    <td><?php echo e(dateFormat($maintenanceRequest->request_date)); ?></td>
                                                </tr>
                                                <?php if(!empty($maintenanceRequest->fixed_date)): ?>
                                                    <tr>
                                                        <td><b class="text-header"><?php echo e(__('Fixed Date')); ?></b></td>
                                                        <td>:</td>
                                                        <td><?php echo e(dateFormat($maintenanceRequest->fixed_date)); ?>

                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if($maintenanceRequest->amount != 0): ?>
                                                    <tr>
                                                        <td><b class="text-header"><?php echo e(__('Amount')); ?></b></td>
                                                        <td>:</td>
                                                        <td><?php echo e(priceFormat($maintenanceRequest->amount)); ?></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <tr>
                                                    <td><b class="text-header"><?php echo e(__('Status')); ?></b></td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php if($maintenanceRequest->status == 'pending'): ?>
                                                            <span class="badge bg-light-warning">
                                                                <?php echo e(\App\Models\MaintenanceRequest::$status[$maintenanceRequest->status]); ?></span>
                                                        <?php elseif($maintenanceRequest->status == 'in_progress'): ?>
                                                            <span class="badge bg-light-info">
                                                                <?php echo e(\App\Models\MaintenanceRequest::$status[$maintenanceRequest->status]); ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-light-primary">
                                                                <?php echo e(\App\Models\MaintenanceRequest::$status[$maintenanceRequest->status]); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>

                                                <?php if(!empty($maintenanceRequest->invoice)): ?>
                                                    <tr>
                                                        <td><b class="text-header"><?php echo e(__('Invoice')); ?></b></td>
                                                        <td>:</td>
                                                        <td><a href="<?php echo e(!empty($maintenanceRequest->invoice) ? fetch_file($maintenanceRequest->invoice, 'upload/invoice/') : '#'); ?>"
                                                                download="download"><i class="fa fa-download"></i></a></td>
                                                    </tr>
                                                <?php endif; ?>

                                                <tr>
                                                    <td><b class="text-header"><?php echo e(__('Attachment')); ?></b></td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php if(!empty($maintenanceRequest->issue_attachment)): ?>
                                                            <a href="<?php echo e(!empty($maintenanceRequest->issue_attachment) ? fetch_file($maintenanceRequest->issue_attachment, 'upload/issue_attachment/') : '#'); ?>"
                                                                download="download"><i class="fa fa-download"></i></a>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b class="text-header"><?php echo e(__('Notes')); ?></b></td>
                                                    <td>:</td>
                                                    <td> <?php echo e($maintenanceRequest->notes); ?></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">

            <?php if($maintenanceRequest->comments->count() > 0): ?>
                <div class="card border">
                    <div class="card-header">
                        <h5><?php echo e(__('Comments')); ?></h5>
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $maintenanceRequest->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $user = App\Models\User::find($comment->user_id);
                            ?>

                            <div class="bg-light rounded p-2 mb-3 position-relative">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <?php
                                            $profileUrl = !empty($user->profile) ? fetch_file($user->profile, 'upload/profile/') : '';
                                            $profileUrl = !empty($profileUrl) ? $profileUrl : $profile;
                                        ?>
                                        <img class="img-radius img-fluid wid-40"
                                            src="<?php echo e($profileUrl); ?>"
                                            alt="profile" />
                                    </div>

                                    <div class="flex-grow-1 mx-3">
                                        <div class="d-flex align-items-center">
                                            <h5 class="mb-0 me-3"><?php echo e($user->name ?? '-'); ?></h5>
                                            <span class="text-body text-opacity-50 d-flex align-items-center">
                                                <i class="fas fa-circle f-8 me-2"></i>
                                                <?php echo e(dateFormat($comment->created_at)); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-header"><?php echo e($comment->comment); ?></p>

                                <?php if(\Auth::user()->id === $comment->user_id || \Auth::user()->type === 'owner'): ?>
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <?php echo Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['maintenance-request.comment.destroy', $comment->id],
                                            'id' => 'delete-comment-' . $comment->id,
                                        ]); ?>

                                        <button type="button"
                                            class="btn btn-sm btn-light text-danger border-0 p-1 confirm_dialog"
                                            data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <?php echo Form::close(); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card border">
                <div class="card-header">
                    <h5><?php echo e(__('Add Comment')); ?></h5>
                </div>

                <div class="card-body">
                    <?php echo e(Form::open(['route' => ['maintenance-request.comment', $maintenanceRequest->id], 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

                    <div class="d-flex align-items-center mt-3">
                        <div class="flex-shrink-0">
                            <?php
                                $maintainerProfileUrl = !empty($maintainer->user->profile) ? fetch_file($maintainer->user->profile, 'upload/profile/') : '';
                                $maintainerProfileUrl = !empty($maintainerProfileUrl) ? $maintainerProfileUrl : $profile;
                            ?>
                            <img class="img-radius d-none d-sm-inline-flex me-3 img-fluid wid-35"
                                src="<?php echo e($maintainerProfileUrl); ?>"
                                alt="<?php echo e($maintainer->user->first_name); ?>" />
                        </div>
                        <div class="flex-grow-1 me-3">
                            <textarea class="form-control" rows="1" name="comment" placeholder="<?php echo e(__('Write a comment...')); ?>"></textarea>

                        </div>

                        <div class="flex-shrink-0">
                            <button type="submit" class="btn btn-secondary"><?php echo e(__('Send')); ?></button>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/maintenance_request/show.blade.php ENDPATH**/ ?>