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
                        <div class="mb20">
                            <div class="form-group  col-md-12">
                                <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter contact name'), 'required' => 'required'])); ?>

                            </div>
                        </div>
                        <div class="mb20">
                            <div class="form-group  col-md-12">
                                <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter contact email'), 'required' => 'required'])); ?>

                            </div>
                        </div>
                        <div class="mb20">
                            <div class="form-group  col-md-12">
                                <?php echo e(Form::label('contact_number', __('Contact Number'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::number('contact_number', null, ['class' => 'form-control', 'placeholder' => __('Enter contact number')])); ?>

                            </div>
                        </div>
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