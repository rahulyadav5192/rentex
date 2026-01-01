<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Property')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-page'); ?>
    <style>
        .property-card-modern {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        .property-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        }
        .property-card-modern:hover img {
            transform: scale(1.05);
        }
        .property-card-modern .dropdown-item:hover {
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
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Property')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/js/vendors/dropzone/dropzone.js')); ?>"></script>
    <script>
        var dropzone = new Dropzone('#demo-upload', {
            previewTemplate: document.querySelector('.preview-dropzon').innerHTML,
            parallelUploads: 10,
            thumbnailHeight: 120,
            thumbnailWidth: 120,
            maxFilesize: 10,
            filesizeBase: 1000,
            autoProcessQueue: false,
            thumbnail: function(file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function() {
                        file.previewElement.classList.add("dz-image-preview");
                    }, 1);
                }
            }

        });
        $('#property-submit').on('click', function() {
            "use strict";
            $('#property-submit').attr('disabled', true);
            var fd = new FormData();
            var file = document.getElementById('thumbnail').files[0];

            var files = $('#demo-upload').get(0).dropzone.getAcceptedFiles();
            $.each(files, function(key, file) {
                fd.append('property_images[' + key + ']', $('#demo-upload')[0].dropzone
                    .getAcceptedFiles()[key]); // attach dropzone image element
            });
            fd.append('thumbnail', file);
            var other_data = $('#property_form').serializeArray();
            $.each(other_data, function(key, input) {
                fd.append(input.name, input.value);
            });
            $.ajax({
                url: "<?php echo e(route('property.store')); ?>",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: fd,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data) {
                    if (data.status == "success") {
                        $('#property-submit').attr('disabled', true);
                        toastrs(data.status, data.msg, data.status);
                        var url = '<?php echo e(route('property.show', ':id')); ?>';
                        url = url.replace(':id', data.id);
                        setTimeout(() => {
                            window.location.href = url;
                        }, "1000");

                    } else {
                        toastrs('Error', data.msg, 'error');
                        $('#property-submit').attr('disabled', false);
                    }
                },
                error: function(data) {
                    $('#property-submit').attr('disabled', false);
                    if (data.error) {
                        toastrs('Error', data.error, 'error');
                    } else {
                        toastrs('Error', data, 'error');
                    }
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5><?php echo e(__('Property List')); ?></h5>
                        </div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create property')): ?>
                            <div class="col-auto">
                                <a class="btn btn-secondary" href="<?php echo e(route('property.create')); ?>" data-size="md"> <i
                                        class="ti ti-circle-plus align-text-bottom "></i>
                                    <?php echo e(__('Create Property')); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mt-4 g-4">
                    <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $hasThumbnail = !empty($property->thumbnail) && !empty($property->thumbnail->image);
                            $thumbnail = $hasThumbnail ? $property->thumbnail->image : null;
                            $thumbnailUrl = $hasThumbnail ? fetch_file($thumbnail, 'upload/property/thumbnail/') : '';
                        ?>
                        <div class="col-sm-6 col-md-4 col-xxl-3">
                            <div class="card border-0 shadow-sm h-100 property-card-modern" style="transition: all 0.3s ease; border-radius: 12px; overflow: hidden;">
                                <div class="position-relative" style="height: 220px; overflow: hidden; background: #f8f9fa;">
                                    <?php if($hasThumbnail && !empty($thumbnailUrl)): ?>
                                        <img src="<?php echo e($thumbnailUrl); ?>"
                                            alt="<?php echo e($property->name); ?>" 
                                            class="w-100 h-100" 
                                            style="object-fit: cover; transition: transform 0.3s ease;" />
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center h-100" style="background: #f8f9fa;">
                                            <i class="material-icons-two-tone" style="font-size: 80px; color: #000; opacity: 0.3;">home</i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <?php if(Gate::check('edit property') || Gate::check('delete property') || Gate::check('show property')): ?>
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-dark opacity-75 arrow-none bg-white rounded-circle d-flex align-items-center justify-content-center" href="#"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    style="text-decoration: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); width: 36px; height: 36px; line-height: 1;">
                                                    <i class="ti ti-dots" style="font-size: 18px; vertical-align: middle;"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 8px; min-width: 180px;">
                                                    <?php echo Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['property.destroy', $property->id],
                                                        'id' => 'property-' . $property->id,
                                                    ]); ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit property')): ?>
                                                        <a class="dropdown-item text-dark d-flex align-items-center py-2" 
                                                            href="<?php echo e(route('property.edit', \Crypt::encrypt($property->id))); ?>"
                                                            style="transition: background 0.2s;">
                                                            <i class="material-icons-two-tone me-2" style="font-size: 20px;">edit</i>
                                                            <?php echo e(__('Edit Property')); ?>

                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show property')): ?>
                                                        <a class="dropdown-item text-dark d-flex align-items-center py-2"
                                                            href="<?php echo e(route('property.show', \Crypt::encrypt($property->id))); ?>"
                                                            style="transition: background 0.2s;">
                                                            <i class="material-icons-two-tone me-2" style="font-size: 20px;">remove_red_eye</i>
                                                            <?php echo e(__('View property')); ?>

                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete property')): ?>
                                                        <a class="dropdown-item text-dark d-flex align-items-center py-2 confirm_dialog" href="#"
                                                            style="transition: background 0.2s;">
                                                            <i class="material-icons-two-tone me-2" style="font-size: 20px;">delete</i>
                                                            <?php echo e(__('Delete Property')); ?>

                                                        </a>
                                                    <?php endif; ?>

                                                    <?php echo Form::close(); ?>

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <a href="<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show property')): ?> <?php echo e(route('property.show', \Crypt::encrypt($property->id))); ?>  <?php endif; ?>"
                                        class="text-dark text-decoration-none">
                                        <h5 class="mb-2 fw-bold" style="font-size: 1.1rem; line-height: 1.4; color: #000;">
                                            <?php echo e($property->name); ?>

                                        </h5>
                                    </a>
                                    
                                    <p class="text-muted mb-3" style="font-size: 0.875rem; line-height: 1.5; color: #666; min-height: 60px;">
                                        <?php echo e(Str::limit(strip_tags($property->description), 120, '...')); ?>

                                    </p>

                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge border border-dark text-dark px-3 py-1" 
                                            style="background: transparent; border-radius: 20px; font-weight: 500; font-size: 0.75rem;">
                                            <i class="material-icons-two-tone me-1" style="font-size: 16px; vertical-align: middle;">apartment</i>
                                            <?php echo e($property->totalUnit()); ?> <?php echo e(__('Unit')); ?>

                                        </span>

                                        <span class="badge border border-dark text-dark px-3 py-1" 
                                            style="background: transparent; border-radius: 20px; font-weight: 500; font-size: 0.75rem;">
                                            <i class="material-icons-two-tone me-1" style="font-size: 16px; vertical-align: middle;">meeting_room</i>
                                            <?php echo e($property->vacantUnit()); ?> <?php echo e(__('Vacant')); ?>

                                        </span>

                                        <span class="badge border border-dark text-dark px-3 py-1" 
                                            style="background: transparent; border-radius: 20px; font-weight: 500; font-size: 0.75rem;">
                                            <i class="material-icons-two-tone me-1" style="font-size: 16px; vertical-align: middle;">person</i>
                                            <?php echo e($property->occupiedUnit()); ?> <?php echo e(__('Occupied')); ?>

                                        </span>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between pt-3 border-top" style="border-color: #e0e0e0 !important;">
                                        <span class="badge bg-dark text-white px-3 py-1" 
                                            style="border-radius: 20px; font-weight: 500; font-size: 0.75rem; display: inline-flex; align-items: center; height: 28px;"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="<?php echo e(__('Type')); ?>">
                                            <?php echo e(\App\Models\Property::$Type[$property->type] ?? $property->type); ?>

                                        </span>
                                        <a href="<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show property')): ?> <?php echo e(route('property.show', \Crypt::encrypt($property->id))); ?>  <?php endif; ?>"
                                            class="text-dark text-decoration-none d-flex align-items-center"
                                            style="font-size: 0.875rem; font-weight: 500; height: 28px;">
                                            <span style="line-height: 1.5;"><?php echo e(__('View Details')); ?></span>
                                            <i class="material-icons-two-tone ms-1" style="font-size: 18px; line-height: 1;">arrow_forward</i>
                                        </a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/property/index.blade.php ENDPATH**/ ?>