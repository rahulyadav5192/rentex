<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Property Details')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-class'); ?>
    product-detail-page
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-page'); ?>
    <style>
        .property-detail-modern {
            border-radius: 12px;
            overflow: hidden;
        }
        .property-detail-modern .card {
            border: none !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
            border-radius: 12px !important;
        }
        .property-detail-modern .card-header {
            background: transparent !important;
            border-bottom: 2px solid #000 !important;
            padding: 1.5rem !important;
        }
        .property-detail-modern .nav-tabs {
            border-bottom: 2px solid #e0e0e0 !important;
        }
        .property-detail-modern .nav-tabs .nav-link {
            color: #666 !important;
            border: none !important;
            border-bottom: 3px solid transparent !important;
            padding: 1rem 1.5rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }
        .property-detail-modern .nav-tabs .nav-link:hover {
            color: #000 !important;
            background: #f8f9fa !important;
        }
        .property-detail-modern .nav-tabs .nav-link.active {
            color: #000 !important;
            background: transparent !important;
            border-bottom-color: #000 !important;
            font-weight: 600 !important;
        }
        .property-detail-modern .badge {
            background-color: #000 !important;
            color: #fff !important;
            border-radius: 20px !important;
            padding: 0.5rem 1rem !important;
            font-weight: 500 !important;
        }
        .property-detail-modern h3, .property-detail-modern h5 {
            color: #000 !important;
            font-weight: 700 !important;
        }
        .property-detail-modern hr {
            border-color: #e0e0e0 !important;
            opacity: 1 !important;
        }
        .property-detail-modern .btn-secondary {
            background-color: #000 !important;
            border-color: #000 !important;
            color: #fff !important;
            border-radius: 8px !important;
        }
        .property-detail-modern .btn-secondary:hover {
            background-color: #333 !important;
            border-color: #333 !important;
        }
        .property-detail-modern .follower-card {
            border: 1px solid #e0e0e0 !important;
            border-radius: 12px !important;
            transition: all 0.3s ease !important;
        }
        .property-detail-modern .follower-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            transform: translateY(-2px) !important;
        }
        .property-detail-modern .text-success {
            color: #000 !important;
            font-weight: 600 !important;
        }
        .property-detail-modern .text-danger {
            color: #000 !important;
            font-weight: 600 !important;
        }
        .property-detail-modern .dropdown-toggle {
            color: #000 !important;
        }
        .property-detail-modern .carousel-indicators li {
            border: 2px solid #000 !important;
        }
        .property-detail-modern .carousel-indicators li.active {
            background-color: #000 !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('property.index')); ?>"><?php echo e(__('Property')); ?></a>
    </li>
    <li class="breadcrumb-item active">
        <a href="#"><?php echo e(__('Details')); ?></a>
    </li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="card-header" style="background: transparent; border-bottom: 2px solid #000; padding: 1.5rem 0;">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5 style="color: #000; font-weight: 700; margin: 0;"><?php echo e(__('Property Details')); ?></h5>
                        </div>
                        <div class="col-auto d-flex gap-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit property')): ?>
                                <a class="btn btn-secondary" href="<?php echo e(route('property.edit', \Crypt::encrypt($property->id))); ?>"
                                    style="border-radius: 8px;"> 
                                    <i class="material-icons-two-tone align-text-bottom me-1" style="font-size: 18px; vertical-align: middle; color: #fff;">edit</i>
                                    <?php echo e(__('Edit Property')); ?>

                                </a>
                            <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create property')): ?>
                                <a class="btn btn-secondary customModal" data-size="lg" href="#"
                                    data-url="<?php echo e(route('unit.create', $property->id)); ?>" data-title="<?php echo e(__('Add Unit')); ?>"
                                    style="border-radius: 8px;"> 
                                    <i class="ti ti-circle-plus align-text-bottom me-1"></i>
                                    <?php echo e(__('Add Unit')); ?>

                                </a>
                            <?php endif; ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row property-page mt-3 property-detail-modern">
        <div class="col-sm-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header pb-0">
                    <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1"
                                role="tab" aria-selected="true">
                                <i class="material-icons-two-tone me-2">meeting_room</i>
                                <?php echo e(__('Property Details')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab"
                                aria-selected="true">
                                <i class="material-icons-two-tone me-2">ad_units</i>
                                <?php echo e(__('Property Units')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-3" data-bs-toggle="tab" href="#profile-3" role="tab"
                                aria-selected="true">
                                <i class="material-icons-two-tone me-2">fact_check</i>
                                <?php echo e(__('Amenities')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-4" data-bs-toggle="tab" href="#profile-4" role="tab"
                                aria-selected="true">
                                <i class="material-icons-two-tone me-2">thumb_up_alt</i>
                                <?php echo e(__('Advantages')); ?>

                            </a>
                        </li>


                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-12 col-xxl-12">
                                            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                                                <div class="card-body p-4">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="sticky-md-top product-sticky">
                                                                <div id="carouselExampleCaptions"
                                                                    class="carousel slide carousel-fade"
                                                                    data-bs-ride="carousel"
                                                                    style="border-radius: 12px; overflow: hidden;">
                                                                    <div class="carousel-inner">
                                                                        <?php if($property->propertyImages->count() > 0): ?>
                                                                        <?php $__currentLoopData = $property->propertyImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div
                                                                                class="carousel-item <?php echo e($key === 0 ? 'active' : ''); ?>">
                                                                                <img src="<?php echo e(fetch_file($image->image, 'upload/property/image/')); ?>"
                                                                                        class="d-block w-100"
                                                                                        alt="Property image"
                                                                                        style="height: 400px; object-fit: cover;" />
                                                                                </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php else: ?>
                                                                            <div class="carousel-item active">
                                                                                <div class="d-flex align-items-center justify-content-center bg-light" style="height: 400px;">
                                                                                    <i class="material-icons-two-tone" style="font-size: 100px; color: #000; opacity: 0.3;">home</i>
                                                                                </div>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <?php if($property->propertyImages->count() > 1): ?>
                                                                    <ol
                                                                        class="carousel-indicators position-relative product-carousel-indicators my-sm-3 mx-0">
                                                                        <?php $__currentLoopData = $property->propertyImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <li data-bs-target="#carouselExampleCaptions"
                                                                                data-bs-slide-to="<?php echo e($key); ?>"
                                                                                    class="<?php echo e($key === 0 ? 'active' : ''); ?> w-25 h-auto"
                                                                                    style="border: 2px solid #000;">
                                                                                <img src="<?php echo e(fetch_file($image->image, 'upload/property/image/')); ?>"
                                                                                    class="d-block wid-50 rounded"
                                                                                        alt="Property image"
                                                                                        style="object-fit: cover; height: 60px;" />
                                                                            </li>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </ol>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">

                                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                                <h3 class="mb-0" style="color: #000; font-weight: 700;">
                                                                <?php echo e(ucfirst($property->name)); ?>

                                                            </h3>
                                                                <span class="badge bg-dark text-white px-3 py-2"
                                                                    style="border-radius: 20px; font-weight: 500;"
                                                                data-bs-toggle="tooltip"
                                                                    data-bs-original-title="<?php echo e(__('Type')); ?>">
                                                                    <?php echo e(\App\Models\Property::$Type[$property->type]); ?>

                                                                </span>
                                                            </div>
                                                            <h5 class="mt-4 mb-3" style="color: #000; font-weight: 700;"><?php echo e(__('Property Details')); ?></h5>
                                                            <hr class="my-3" style="border-color: #e0e0e0; opacity: 1;" />
                                                            <p class="text-muted mb-4" style="line-height: 1.8; color: #666;">
                                                                <?php echo $property->description; ?>

                                                            </p>

                                                            <h5 class="mb-3" style="color: #000; font-weight: 700;"><?php echo e(__('Property Address')); ?></h5>
                                                            <hr class="my-3" style="border-color: #e0e0e0; opacity: 1;" />
                                                            <div class="mb-3 row">
                                                                <label
                                                                    class="col-form-label col-lg-3 col-sm-12 text-lg-end fw-semibold"
                                                                    style="color: #000;">
                                                                    <?php echo e(__('Address')); ?>:
                                                                </label>
                                                                <div
                                                                    class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center">
                                                                    <span style="color: #666;"><?php echo e($property->address); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label
                                                                    class="col-form-label col-lg-3 col-sm-12 text-lg-end fw-semibold"
                                                                    style="color: #000;">
                                                                    <?php echo e(__('Location')); ?>:
                                                                </label>
                                                                <div
                                                                    class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center">
                                                                    <span style="color: #666;"><?php echo e($property->city . ', ' . $property->state . ', ' . $property->country); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label
                                                                    class="col-form-label col-lg-3 col-sm-12 text-lg-end fw-semibold"
                                                                    style="color: #000;">
                                                                    <?php echo e(__('Zip Code')); ?>:
                                                                </label>
                                                                <div
                                                                    class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center">
                                                                    <span style="color: #666;"><?php echo e($property->zip_code); ?></span>
                                                                </div>
                                                            </div>

                                                            <hr class="my-3" />

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                            <div class="row">
                                <?php if($units->count()): ?>
                                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-xxl-3 col-xl-4 col-md-6">
                                            <div class="card follower-card border-0 shadow-sm">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-start mb-3">
                                                        <div class="flex-grow-1">
                                                            <h4 class="mb-1 text-truncate" style="color: #000; font-weight: 700;"><?php echo e(ucfirst($unit->name)); ?></h4>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <div class="dropdown">
                                                                <a class="dropdown-toggle text-dark opacity-75 arrow-none bg-white rounded-circle d-flex align-items-center justify-content-center"
                                                                    href="#" data-bs-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    style="width: 32px; height: 32px; text-decoration: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                                                    <i class="ti ti-dots" style="font-size: 16px;"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 8px; min-width: 160px;">

                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit unit')): ?>
                                                                        <a class="dropdown-item text-dark d-flex align-items-center py-2 customModal" href="#"
                                                                            data-url="<?php echo e(route('unit.edit', [$property->id, $unit->id])); ?>"
                                                                            data-title="<?php echo e(__('Edit Unit')); ?>"
                                                                            data-size="lg"
                                                                            style="transition: background 0.2s;">
                                                                            <i class="material-icons-two-tone me-2" style="font-size: 20px;">edit</i>
                                                                            <?php echo e(__('Edit Unit')); ?>

                                                                        </a>
                                                                    <?php endif; ?>

                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete unit')): ?>
                                                                        <?php echo Form::open([
                                                                            'method' => 'DELETE',
                                                                            'route' => ['unit.destroy', $property->id, $unit->id],
                                                                            'id' => 'unit-' . $unit->id,
                                                                        ]); ?>


                                                                        <a class="dropdown-item text-dark d-flex align-items-center py-2 confirm_dialog"
                                                                            href="#"
                                                                            style="transition: background 0.2s;">
                                                                            <i class="material-icons-two-tone me-2" style="font-size: 20px;">delete</i>
                                                                            <?php echo e(__('Delete Unit')); ?>

                                                                        </a>
                                                                        <?php echo Form::close(); ?>

                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="my-3" style="border-color: #e0e0e0; opacity: 1;" />

                                                    <div class="row">
                                                        <p class="mb-2 fw-semibold" style="color: #000;"><?php echo e(__('Status')); ?>:
                                                            <?php if($unit->is_occupied): ?>
                                                                <span class="badge bg-dark text-white ms-2 px-2 py-1" style="border-radius: 12px; font-weight: 500;"><?php echo e(__('Occupied')); ?></span>
                                                            <?php else: ?>
                                                                <span class="badge border border-dark text-dark ms-2 px-2 py-1" style="background: transparent; border-radius: 12px; font-weight: 500;"><?php echo e(__('Vacant')); ?></span>
                                                            <?php endif; ?>
                                                        </p>

                                                        <p class="mb-2"><span class="fw-semibold" style="color: #000;"><?php echo e(__('Bedroom')); ?>:</span>
                                                            <span class="text-muted ms-2"><?php echo e($unit->bedroom); ?></span>
                                                        </p>
                                                        <p class="mb-2"><span class="fw-semibold" style="color: #000;"><?php echo e(__('Kitchen')); ?>:</span>
                                                            <span class="text-muted ms-2"><?php echo e($unit->kitchen); ?></span>
                                                        </p>
                                                        <p class="mb-2"><span class="fw-semibold" style="color: #000;"><?php echo e(__('Bath')); ?>:</span>
                                                            <span class="text-muted ms-2"><?php echo e($unit->baths); ?></span>
                                                        </p>
                                                        <p class="mb-2"><span class="fw-semibold" style="color: #000;"><?php echo e(__('Rent Type')); ?>:</span>
                                                            <span class="text-muted ms-2"><?php echo e(ucfirst($unit->rent_type)); ?></span>
                                                        </p>
                                                        <p class="mb-2"><span class="fw-semibold" style="color: #000;"><?php echo e(__('Rent')); ?>:</span>
                                                            <span class="text-muted ms-2"><?php echo e(priceFormat($unit->rent)); ?></span>
                                                        </p>
                                                        <?php if($unit->rent_type == 'custom'): ?>
                                                            <p class="mb-1"><?php echo e(__('Start Date')); ?> :
                                                                <span
                                                                    class="text-muted"><?php echo e(dateformat($unit->start_date)); ?></span>
                                                            </p>
                                                            <p class="mb-1"><?php echo e(__('End Date')); ?> :
                                                                <span
                                                                    class="text-muted"><?php echo e(dateformat($unit->end_date)); ?></span>
                                                            </p>
                                                            <p class="mb-1"><?php echo e(__('Payment Due Date')); ?> :
                                                                <span
                                                                    class="text-muted"><?php echo e($unit->payment_due_date); ?></span>
                                                            </p>
                                                        <?php else: ?>
                                                            <p class="mb-1"><?php echo e(__('Rent Duration')); ?> :
                                                                <span class="text-muted"><?php echo e($unit->rent_duration); ?></span>
                                                            </p>
                                                        <?php endif; ?>

                                                        <p class="mb-1"><?php echo e(__('Deposit Type')); ?> :
                                                            <span class="text-muted"><?php echo e($unit->deposit_type); ?></span>
                                                        </p>
                                                        <p class="mb-1"><?php echo e(__('Deposit Amount')); ?> :
                                                            <span class="text-muted">
                                                                <?php echo e($unit->deposit_type == 'fixed' ? priceFormat($unit->deposit_amount) : $unit->deposit_amount . '%'); ?>

                                                            </span>
                                                        </p>
                                                        <p class="mb-1"><?php echo e(__('Late Fee Type')); ?> :
                                                            <span class="text-muted"><?php echo e($unit->late_fee_type); ?></span>
                                                        </p>
                                                        <p class="mb-1"><?php echo e(__('Late Fee Amount')); ?> :
                                                            <span class="text-muted">
                                                                <?php echo e($unit->late_fee_type == 'fixed' ? priceFormat($unit->late_fee_amount) : $unit->late_fee_amount . '%'); ?>

                                                            </span>
                                                        </p>
                                                        <p class="mb-1"><?php echo e(__('Incident Receipt Amount')); ?> :
                                                            <span
                                                                class="text-muted"><?php echo e(priceFormat($unit->incident_receipt_amount)); ?></span>
                                                        </p>
                                                    </div>

                                                    <hr class="my-2" />
                                                    <p class="my-3 text-muted text-sm">
                                                        <?php echo e($unit->notes); ?>

                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-12 col-xxl-12">
                                            <div class="card border">
                                                <div class="card-body">
                                                    <div class="col-12">
                                                        <p class="text-muted"><?php echo e(__('No unit available')); ?>.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-12 col-xxl-12">
                                            <div class="card border">
                                                <div class="card-body">
                                                    <?php if($selectedAmenities->count()): ?>
                                                        <div class="row">
                                                            <?php $__currentLoopData = $selectedAmenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="col-md-6 col-xl-4 mb-3">
                                                                    <div
                                                                        class="position-relative h-100 border p-3 rounded shadow-sm d-flex align-items-start gap-3"
                                                                        style="border-color: #e0e0e0 !important; border-radius: 12px !important; transition: all 0.3s ease;">
                                                                        <i class="material-icons-two-tone position-absolute"
                                                                            style="top: 10px; right: 10px; color: #000; font-size: 20px;">check_circle</i>

                                                                        <?php if($amenity->image): ?>
                                                                            <img src="<?php echo e(fetch_file('upload/amenity/' . $amenity->image)); ?>"
                                                                                alt="<?php echo e($amenity->name); ?>"
                                                                                style="width: 40px; height: 40px; object-fit: cover;"
                                                                                class="rounded shadow-sm mt-1">
                                                                        <?php endif; ?>
                                                                        <div>
                                                                            <h6 class="mb-1" style="color: #000; font-weight: 600;"><?php echo e($amenity->name); ?></h6>
                                                                            <p class="mb-0 text-muted"
                                                                                style="font-size: 0.875rem; color: #666; line-height: 1.5;">
                                                                                <?php echo e($amenity->description); ?>

                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="col-12">
                                                            <p class="text-muted"><?php echo e(__('No amenities selected')); ?>.</p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-12 col-xxl-12">
                                            <div class="card border">
                                                <div class="card-body">
                                                    <?php if($selectedAdvantages->count()): ?>
                                                        <div class="row">
                                                            <?php $__currentLoopData = $selectedAdvantages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advantage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="col-md-6 col-xl-4 mb-3">
                                                                    <div
                                                                        class="position-relative h-100 border p-3 rounded shadow-sm d-flex align-items-start gap-3"
                                                                        style="border-color: #e0e0e0 !important; border-radius: 12px !important; transition: all 0.3s ease;">
                                                                        <i class="material-icons-two-tone position-absolute"
                                                                            style="top: 10px; right: 10px; color: #000; font-size: 20px;">check_circle</i>

                                                                        <div>
                                                                            <h6 class="mb-1" style="color: #000; font-weight: 600;"><?php echo e($advantage->name); ?></h6>
                                                                            <p class="mb-0 text-muted"
                                                                                style="font-size: 0.875rem; color: #666; line-height: 1.5;">
                                                                                <?php echo e($advantage->description); ?>

                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="col-12">
                                                            <p class="text-muted"><?php echo e(__('No advantage selected')); ?>.</p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>


        <?php if(!empty($property->propertyImages) && $property->propertyImages->count()): ?>
            <div class="col-sm-12 mt-4">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-header" style="background: transparent; border-bottom: 2px solid #000; padding: 1.5rem;">
                        <h5 style="color: #000; font-weight: 700; margin: 0;"><?php echo e(__('Property Images')); ?></h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <?php $__currentLoopData = $property->propertyImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $folder = 'upload/property/image/';
                                    $filename = $doc->image;
                                    $fileUrl = fetch_file($filename, $folder);

                                    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION); // Use filename, not URL
                                    $isImage = in_array(strtolower($fileExtension), [
                                        'jpg',
                                        'jpeg',
                                        'png',
                                        'gif',
                                        'webp',
                                    ]);
                                ?>

                                <div class="col-md-2 col-sm-4 col-6 mb-2">
                                    <div
                                        class="card gallery-card shadow-sm border rounded text-center d-flex flex-column justify-content-between">
                                        <?php if($isImage): ?>
                                            <a href="<?php echo e($fileUrl); ?>" target="_blank">
                                                <img src="<?php echo e($fileUrl); ?>" alt="Document"
                                                    class="img-fluid img-card-top rounded-top mt-1"
                                                    style="height: 180px; object-fit: cover;">
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo e($fileUrl); ?>" target="_blank"
                                                class="d-flex justify-content-center align-items-center bg-light"
                                                style="height: 180px;">
                                                <i class="ti ti-file-text" style="font-size: 48px;"></i>
                                            </a>
                                        <?php endif; ?>
                                        <hr>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?php echo e($fileUrl); ?>" download title="Download"
                                                class="avtar btn-link-success text-success p-0">
                                                <i class="ti ti-download "></i>
                                            </a>

                                            <?php echo Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['property.image.delete', $doc->id],
                                                'id' => 'doc-' . $doc->id,
                                            ]); ?>

                                            <a class="avtar btn-link-danger text-danger confirm_dialog p-0"
                                                href="#"><i class="ti ti-trash text-danger"></i>
                                            </a>
                                            <?php echo Form::close(); ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>


                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/property/show.blade.php ENDPATH**/ ?>