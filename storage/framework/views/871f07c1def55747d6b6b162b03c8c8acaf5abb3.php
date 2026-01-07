<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Frontend Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item" aria-current="page"> <?php echo e(__('Frontend Settings')); ?></li>
<?php $__env->stopSection(); ?>
<?php
    $profile = asset(Storage::url('upload/profile'));
    $settings = settings();
    $activeTab = session('tab', 'profile_tab_1');
?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).ready(function() {
            $('.location').on('click', '.location_list_remove', function() {
                if ($('.location_list').length > 1) {
                    $(this).closest('.location_remove').remove();
                }
            });
            $('.location').on('click', '.location_clone', function() {
                var clonedlocation = $(this).closest('.location').find('.location_list').first().clone();
                clonedlocation.find('input[type="text"]').val('');
                $(this).closest('.location').find('.location_list_results').append(clonedlocation);
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header" style="background: transparent !important; border-bottom: 2px solid #000 !important; padding: 1.5rem !important;">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5 style="color: #000 !important; font-weight: 700 !important; margin: 0;"><?php echo e(__('Frontend Settings')); ?></h5>
                        </div>
                        <div class="col-auto d-flex gap-2 align-items-center">
                            <?php
                                $frontendUrl = url('web/' . \Auth::user()->code);
                            ?>
                            <div class="d-flex align-items-center me-3" style="background: #f5f5f5; padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid #e0e0e0;">
                                <span class="text-muted me-2" style="font-size: 0.875rem;"><?php echo e(__('Frontend URL:')); ?></span>
                                <span class="text-dark fw-semibold" style="font-size: 0.875rem; font-family: monospace;"><?php echo e($frontendUrl); ?></span>
                            </div>
                            <a class="btn btn-secondary" href="<?php echo e($frontendUrl); ?>" target="_blank" style="white-space: nowrap;">
                                <i class="ti ti-external-link align-text-bottom me-1" style="color: #fff;"></i>
                                <?php echo e(__('View Frontend')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row setting_page_cnt">
                        <div class="col-lg-4">
                            <ul class="nav flex-column nav-tabs account-tabs mb-3" id="myTab" role="tablist">
                                <?php $__currentLoopData = $frontHomePage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section_key => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $section->content_value = !empty($section->content_value)
                                            ? json_decode($section->content_value, true)
                                            : [];
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(empty($activeTab) || $activeTab == 'profile_tab_' . $section->id ? ' active ' : ''); ?>"
                                            id="profile-tab-<?php echo e($section->id); ?>" data-bs-toggle="tab"
                                            href="#profile_tab_<?php echo e($section->id); ?>" role="tab" aria-selected="true">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="ti-view-list me-2 f-20"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h5 class="mb-0">
                                                        <?php echo e(!empty($section->content_value['name']) ? $section->content_value['name'] : $section->title); ?>

                                                    </h5>
                                                    <small class="text-muted"> <?php echo e($section->title); ?>

                                                        <?php echo e(__('Section Settings')); ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="col-lg-8">
                            <?php if(Gate::check('edit front home page')): ?>
                                <div class="tab-content">
                                    <?php $__currentLoopData = $frontHomePage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="tab-pane <?php echo e(empty($activeTab) || $activeTab == 'profile_tab_' . $section->id ? ' active show ' : ''); ?>"
                                            id="profile_tab_<?php echo e($section->id); ?>" role="tabpanel"
                                            aria-labelledby="footer_column_1">
                                            <?php echo e(Form::model($section, ['route' => ['front-home.update', $section->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data'])); ?>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[name]', !empty($section->content_value['name']) ? $section->content_value['name'] : $section->title, ['class' => 'form-control', 'placeholder' => __('Enter Section name')])); ?>

                                                    </div>
                                                </div>


                                                <?php if($section->section == 'Section 0'): ?>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch">
                                                            <?php echo e(Form::hidden('content_value[section_enabled]', 'deactive')); ?>

                                                            <?php echo e(Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('title', __('Title'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[title]', !empty($section->content_value['title']) ? $section->content_value['title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Section name')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('sub_title', __('Sub Title'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[sub_title]', !empty($section->content_value['sub_title']) ? $section->content_value['sub_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter sub title')])); ?>

                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <?php echo e(Form::label('banner_image1', __('Main Image'), ['class' => 'form-label'])); ?>

                                                        <?php if(!empty($section->content_value['banner_image1_path'])): ?>
                                                            <a href="<?php echo e(fetch_file(basename($section->content_value['banner_image1_path']), 'upload/fronthomepage/')); ?>"
                                                                target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::file('content_value[banner_image1]', ['class' => 'form-control'])); ?>

                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <?php echo e(Form::label('bg_image', __('Background Image'), ['class' => 'form-label'])); ?>

                                                        <?php if(!empty($section->content_value['bg_image_path'])): ?>
                                                            <a href="<?php echo e(fetch_file(basename($section->content_value['bg_image_path']), 'upload/fronthomepage/')); ?>"
                                                                target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::file('content_value[bg_image]', ['class' => 'form-control'])); ?>

                                                        <small class="form-text text-muted"><?php echo e(__('Background image for hero section with dark overlay')); ?></small>
                                                    </div>
                                                <?php endif; ?>


                                                <?php if($section->section == 'Section 1'): ?>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch">
                                                            <?php echo e(Form::hidden('content_value[section_enabled]', 'deactive')); ?>

                                                            <?php echo e(Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec1_title', __('Main Title'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec1_title]', !empty($section->content_value['Sec1_title']) ? $section->content_value['Sec1_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec1_info', __('Main Info'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec1_info]', !empty($section->content_value['Sec1_info']) ? $section->content_value['Sec1_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <?php for($is4 = 1; $is4 <= 4; $is4++): ?>
                                                        <div class="col-md-5 form-group">
                                                            <?php echo e(Form::label('sec1_info', __('Title'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('content_value[Sec1_box' . $is4 . '_title]', !empty($section->content_value['Sec1_box' . $is4 . '_title']) ? $section->content_value['Sec1_box' . $is4 . '_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                        </div>
                                                        <div class="col-md-5 form-group">
                                                            <?php echo e(Form::label('sec1_image', __('Image'), ['class' => 'form-label'])); ?>

                                                            <?php if(!empty($section->content_value['Sec1_box' . $is4 . '_image_path'])): ?>
                                                                <a href="<?php echo e(asset(Storage::url($section->content_value['Sec1_box' . $is4 . '_image_path']))); ?>"
                                                                target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                            <?php endif; ?>
                                                            <?php echo e(Form::file('content_value[Sec1_box' . $is4 . '_image]', ['class' => 'form-control'])); ?>

                                                        </div>
                                                        <div class="col-md-2 form-group">
                                                            <?php echo e(Form::label('enabled_email', __('Enabled'), ['class' => 'form-label'])); ?>

                                                            <div class="form-check form-switch">
                                                                <?php echo e(Form::hidden('content_value[Sec1_box' . $is4 . '_enabled]', 'deactive')); ?>

                                                                <?php echo e(Form::checkbox('content_value[Sec1_box' . $is4 . '_enabled]', 'active', !empty($section->content_value['Sec1_box' . $is4 . '_enabled']) && $section->content_value['Sec1_box' . $is4 . '_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <?php echo e(Form::label('sec1_info', __('Info'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('content_value[Sec1_box' . $is4 . '_info]', !empty($section->content_value['Sec1_box' . $is4 . '_info']) ? $section->content_value['Sec1_box' . $is4 . '_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                        </div>
                                                    <?php endfor; ?>
                                                <?php endif; ?>

                                                <?php if($section->section == 'Section 2'): ?>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch">
                                                            <?php echo e(Form::hidden('content_value[section_enabled]', 'deactive')); ?>

                                                            <?php echo e(Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                        </div>
                                                    </div>
                                                    <?php for($i = 1; $i <= 4; $i++): ?>
                                                        <div class="col-md-8 form-group">
                                                            <?php echo e(Form::label('Box' . $i . '_title', $i . __(' Box Title'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('content_value[Box' . $i . '_title]', !empty($section->content_value['Box' . $i . '_title']) ? $section->content_value['Box' . $i . '_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Box Name')])); ?>

                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <?php echo e(Form::label('Box' . $i . '_number', $i . __(' Box Number'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('content_value[Box' . $i . '_number]', !empty($section->content_value['Box' . $i . '_number']) ? $section->content_value['Box' . $i . '_number'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Box Number')])); ?>

                                                        </div>
                                                        
                                                    <?php endfor; ?>
                                                <?php endif; ?>

                                                <?php if($section->section == 'Section 3'): ?>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch">
                                                            <?php echo e(Form::hidden('content_value[section_enabled]', 'deactive')); ?>

                                                            <?php echo e(Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec3_title', __('Main Title'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec3_title]', !empty($section->content_value['Sec3_title']) ? $section->content_value['Sec3_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec3_info', __('Main Info'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec3_info]', !empty($section->content_value['Sec3_info']) ? $section->content_value['Sec3_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                <?php endif; ?>

                                                <?php if($section->section == 'Section 4'): ?>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch">
                                                            <?php echo e(Form::hidden('content_value[section_enabled]', 'deactive')); ?>

                                                            <?php echo e(Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec4_title', __('Main Title'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec4_title]', !empty($section->content_value['Sec4_title']) ? $section->content_value['Sec4_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <?php echo e(Form::label('about_image', __('Main Image'), ['class' => 'form-label'])); ?>

                                                        <?php if(!empty($section->content_value['about_image_path'])): ?>
                                                            <a href="<?php echo e(asset(Storage::url($section->content_value['about_image_path']))); ?>"
                                                            target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::file('content_value[about_image]', ['class' => 'form-control'])); ?>

                                                    </div>

                                                    <div class="col-md-12 form-group location">
                                                        <?php if(!empty($section->content_value['Sec4_Box_title'])): ?>
                                                            <?php $__currentLoopData = $section->content_value['Sec4_Box_title']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Box_title_key => $Box_title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="row location_list location_remove">
                                                                    <div class="col-md-5 form-group">
                                                                        <?php echo e(Form::label('Sec4_Box_title', __('Title'), ['class' => 'form-label'])); ?>

                                                                        <?php echo e(Form::text('content_value[Sec4_Box_title][]', !empty($section->content_value['Sec4_Box_title'][$Box_title_key]) ? $section->content_value['Sec4_Box_title'][$Box_title_key] : '', ['class' => 'form-control', 'placeholder' => __('Enter date')])); ?>

                                                                    </div>
                                                                    <div class="col-md-5 form-group">
                                                                        <?php echo e(Form::label('Sec4_Box_subtitle', __('Sub Title'), ['class' => 'form-label'])); ?>

                                                                        <?php echo e(Form::text('content_value[Sec4_Box_subtitle][]', !empty($section->content_value['Sec4_Box_subtitle'][$Box_title_key]) ? $section->content_value['Sec4_Box_subtitle'][$Box_title_key] : '', ['class' => 'form-control', 'placeholder' => __('Enter date')])); ?>

                                                                    </div>
                                                                    <div class="col-md-2 form-group m-auto">
                                                                        <a href="javascript:void(0)"
                                                                            class="bg-danger text-white location_list_remove btn btn-md ">
                                                                            <i class="ti ti-trash"></i></a>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <div class="row location_list location_remove">
                                                                <div class="col-md-5 form-group">
                                                                    <?php echo e(Form::label('Sec4_Box_title', __('Title'), ['class' => 'form-label'])); ?>

                                                                    <?php echo e(Form::text('content_value[Sec4_Box_title][]', null, ['class' => 'form-control', 'placeholder' => __('Enter Title')])); ?>

                                                                </div>
                                                                <div class="col-md-5 form-group">
                                                                    <?php echo e(Form::label('Sec4_Box_subtitle', __('Sub Title'), ['class' => 'form-label'])); ?>

                                                                    <?php echo e(Form::text('content_value[Sec4_Box_subtitle][]', null, ['class' => 'form-control', 'placeholder' => __('Enter Content')])); ?>

                                                                </div>

                                                                <div class="col-md-2 form-group m-auto">
                                                                    <a href="javascript:void(0)"
                                                                        class="bg-danger text-white location_list_remove btn btn-md ">
                                                                        <i class="ti ti-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <div class="location_list_results"></div>
                                                        <div class="row ">
                                                            <div class="col-sm-12">
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-secondary btn-xs location_clone "><i
                                                                        class="ti ti-plus"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if($section->section == 'Section 5'): ?>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch">
                                                            <?php echo e(Form::hidden('content_value[section_enabled]', 'deactive')); ?>

                                                            <?php echo e(Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec5_title', __('Main Title'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec5_title]', !empty($section->content_value['Sec5_title']) ? $section->content_value['Sec5_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec5_info', __('Main Info'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec5_info]', !empty($section->content_value['Sec5_info']) ? $section->content_value['Sec5_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                <?php endif; ?>


                                                <?php if($section->section == 'Section 6'): ?>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch">
                                                            <?php echo e(Form::hidden('content_value[section_enabled]', 'deactive')); ?>

                                                            <?php echo e(Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec6_title', __('Title'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec6_title]', !empty($section->content_value['Sec6_title']) ? $section->content_value['Sec6_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Section name')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec6_info', __('Sub Title'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec6_info]', !empty($section->content_value['Sec6_info']) ? $section->content_value['Sec6_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter sub title')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('sec6_btn_name', __('Button Name'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[sec6_btn_name]', !empty($section->content_value['sec6_btn_name']) ? $section->content_value['sec6_btn_name'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Button Name')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('sec6_btn_link', __('Button Link'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[sec6_btn_link]', !empty($section->content_value['sec6_btn_link']) ? $section->content_value['sec6_btn_link'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Button Link')])); ?>

                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <?php echo e(Form::label('banner_image2', __('Main Image'), ['class' => 'form-label'])); ?>

                                                        <a href="<?php echo e(asset(Storage::url($section->content_value['banner_image2_path']))); ?>"
                                                        target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                        <?php echo e(Form::file('content_value[banner_image2]', ['class' => 'form-control'])); ?>

                                                    </div>
                                                <?php endif; ?>

                                                <?php if($section->section == 'Section 7'): ?>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch">
                                                            <?php echo e(Form::hidden('content_value[section_enabled]', 'deactive')); ?>

                                                            <?php echo e(Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec7_title', __('Main Title'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec7_title]', !empty($section->content_value['Sec7_title']) ? $section->content_value['Sec7_title'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('Sec7_info', __('Main Info'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec7_info]', !empty($section->content_value['Sec7_info']) ? $section->content_value['Sec7_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <?php for($is7 = 1; $is7 <= 5; $is7++): ?>
                                                        <div class="col-md-4 form-group">
                                                            <?php echo e(Form::label('Sec7_box' . $is7 . '_name', __('Name'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('content_value[Sec7_box' . $is7 . '_name]', !empty($section->content_value['Sec7_box' . $is7 . '_name']) ? $section->content_value['Sec7_box' . $is7 . '_name'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <?php echo e(Form::label('Sec7_box' . $is7 . '_tag', __('Tag'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('content_value[Sec7_box' . $is7 . '_tag]', !empty($section->content_value['Sec7_box' . $is7 . '_tag']) ? $section->content_value['Sec7_box' . $is7 . '_tag'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <?php echo e(Form::label('Sec7_box' . $is7 . '_info', __('Image'), ['class' => 'form-label'])); ?>

                                                            <?php if(!empty($section->content_value['Sec7_box' . $is7 . '_image_path'])): ?>
                                                                <a href="<?php echo e(asset(Storage::url($section->content_value['Sec7_box' . $is7 . '_image_path']))); ?>"
                                                                target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                            <?php endif; ?>
                                                            <?php echo e(Form::file('content_value[Sec7_box' . $is7 . '_image]', ['class' => 'form-control'])); ?>

                                                        </div>
                                                        <div class="col-md-1 form-group">
                                                            <?php echo e(Form::label('Sec7_box' . $is7 . '_Enabled', __('Enabled'), ['class' => 'form-label'])); ?>

                                                            <div class="form-check form-switch">
                                                                <?php echo e(Form::hidden('content_value[Sec7_box' . $is7 . '_Enabled]', 'deactive')); ?>

                                                                <?php echo e(Form::checkbox('content_value[Sec7_box' . $is7 . '_Enabled]', 'active', !empty($section->content_value['Sec7_box' . $is7 . '_Enabled']) && $section->content_value['Sec7_box' . $is7 . '_Enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <?php echo e(Form::label('Sec7_box' . $is7 . '_review', __('Review'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('content_value[Sec7_box' . $is7 . '_review]', !empty($section->content_value['Sec7_box' . $is7 . '_review']) ? $section->content_value['Sec7_box' . $is7 . '_review'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                        </div>
                                                    <?php endfor; ?>
                                                <?php endif; ?>

                                                <?php if($section->section == 'Section 8'): ?>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch">
                                                            <?php echo e(Form::hidden('content_value[section_enabled]', 'deactive')); ?>

                                                            <?php echo e(Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 form-group">
                                                        <?php echo e(Form::label('Sec8_info', __('Main Info'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[Sec8_info]', !empty($section->content_value['Sec8_info']) ? $section->content_value['Sec8_info'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('fb_link', __('Facebook Link'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[fb_link]', !empty($section->content_value['fb_link']) ? $section->content_value['fb_link'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('twitter_link', __('Twitter Link'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[twitter_link]', !empty($section->content_value['twitter_link']) ? $section->content_value['twitter_link'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('insta_link', __('Instagram Link'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[insta_link]', !empty($section->content_value['insta_link']) ? $section->content_value['insta_link'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('linkedin_link', __('LinkedIn Link'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[linkedin_link]', !empty($section->content_value['linkedin_link']) ? $section->content_value['linkedin_link'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Data')])); ?>

                                                    </div>

                                                <?php endif; ?>

                                                <?php if($section->section == 'Section 9'): ?>
                                                    <?php
                                                        $settings = settings();
                                                    ?>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('enabled_email', __('Section Enabled'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch">
                                                            <?php echo e(Form::hidden('content_value[section_enabled]', 'deactive')); ?>

                                                            <?php echo e(Form::checkbox('content_value[section_enabled]', 'active', !empty($section->content_value['section_enabled']) && $section->content_value['section_enabled'] == 'active' ? true : false, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'section_enabled'])); ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('application_name', __('Application Name'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('content_value[application_name]', !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME'), ['class' => 'form-control', 'placeholder' => __('Enter your application name'), 'required' => 'required'])); ?>

                                                        <small class="form-text text-muted"><?php echo e(__('This name will appear in the footer and other places')); ?></small>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('logo', __('Logo'), ['class' => 'form-label'])); ?>

                                                        <?php if(!empty($section->content_value['logo_path'])): ?>
                                                            <a href="<?php echo e(fetch_file(basename($section->content_value['logo_path']), 'upload/logo/')); ?>" target="_blank">
                                                                <i class="ti ti-eye ms-2 f-15"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::file('content_value[logo]', ['class' => 'form-control', 'accept' => 'image/*'])); ?>

                                                        <small class="form-text text-muted"><?php echo e(__('Recommended size: 200x50px or similar aspect ratio')); ?></small>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('light_logo', __('Light Logo'), ['class' => 'form-label'])); ?>

                                                        <?php if(!empty($section->content_value['light_logo_path'])): ?>
                                                            <a href="<?php echo e(fetch_file(basename($section->content_value['light_logo_path']), 'upload/logo/')); ?>" target="_blank">
                                                                <i class="ti ti-eye ms-2 f-15"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::file('content_value[light_logo]', ['class' => 'form-control', 'accept' => 'image/*'])); ?>

                                                        <small class="form-text text-muted"><?php echo e(__('Light logo for admin footer (Recommended size: 200x50px)')); ?></small>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <?php echo e(Form::label('favicon', __('Favicon'), ['class' => 'form-label'])); ?>

                                                        <?php if(!empty($section->content_value['favicon_path'])): ?>
                                                            <a href="<?php echo e(fetch_file(basename($section->content_value['favicon_path']), 'upload/favicon/')); ?>" target="_blank">
                                                                <i class="ti ti-eye ms-2 f-15"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::file('content_value[favicon]', ['class' => 'form-control', 'accept' => 'image/*'])); ?>

                                                        <small class="form-text text-muted"><?php echo e(__('Recommended size: 32x32px or 16x16px (ICO, PNG)')); ?></small>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if($section->section == 'Section 10'): ?>
                                                    <div class="col-md-12 mb-4">
                                                        <h6 class="mb-3"><?php echo e(__('Lead Form Fields')); ?></h6>
                                                        <p class="text-muted"><?php echo e(__('Customize the application form fields for your properties. Default fields (Name, Email, Phone) cannot be edited or deleted.')); ?></p>
                                                    </div>
                                                    
                                                    <div class="col-md-12 mb-3">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addFieldModal">
                                                            <i class="ti ti-plus me-1"></i><?php echo e(__('Add Field')); ?>

                                                        </button>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%"><?php echo e(__('Order')); ?></th>
                                                                        <th width="25%"><?php echo e(__('Label')); ?></th>
                                                                        <th width="15%"><?php echo e(__('Type')); ?></th>
                                                                        <th width="10%"><?php echo e(__('Required')); ?></th>
                                                                        <th width="10%"><?php echo e(__('Default')); ?></th>
                                                                        <th width="35%"><?php echo e(__('Actions')); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="leadFieldsTableBody">
                                                                    <?php $__currentLoopData = $leadFormFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr data-field-id="<?php echo e($field->id); ?>" class="<?php echo e($field->is_default ? 'table-warning' : ''); ?>">
                                                                            <td>
                                                                                <?php if(!$field->is_default): ?>
                                                                                    <i class="ti ti-grip-vertical cursor-move" style="cursor: move;"></i>
                                                                                <?php endif; ?>
                                                                                <span class="sort-order"><?php echo e($field->sort_order); ?></span>
                                                                            </td>
                                                                            <td><?php echo e($field->field_label); ?></td>
                                                                            <td>
                                                                                <?php
                                                                                    // Get original type from field_options or map from field_type
                                                                                    $displayType = 'text';
                                                                                    if (!empty($field->field_options)) {
                                                                                        $options = is_array($field->field_options) ? $field->field_options : json_decode($field->field_options, true);
                                                                                        if (isset($options['original_type'])) {
                                                                                            $displayType = $options['original_type'];
                                                                                        } else {
                                                                                            // Map old types
                                                                                            if ($field->field_type == 'doc') {
                                                                                                $displayType = 'docs';
                                                                                            } elseif ($field->field_type == 'input') {
                                                                                                $displayType = 'text';
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        // Map database types to display types
                                                                                        if ($field->field_type == 'doc') {
                                                                                            $displayType = 'docs';
                                                                                        } elseif ($field->field_type == 'input') {
                                                                                            $displayType = 'text';
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <span class="badge bg-dark"><?php echo e(ucfirst($displayType)); ?></span>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($field->is_required): ?>
                                                                                    <span class="badge bg-dark"><?php echo e(__('Yes')); ?></span>
                                                                                <?php else: ?>
                                                                                    <span class="badge bg-secondary"><?php echo e(__('No')); ?></span>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php if($field->is_default): ?>
                                                                                    <span class="badge bg-warning text-dark"><?php echo e(__('Default')); ?></span>
                                                                                <?php else: ?>
                                                                                    <span class="badge bg-secondary"><?php echo e(__('Custom')); ?></span>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php if(!$field->is_default): ?>
                                                                                    <?php
                                                                                        // Get original type for edit
                                                                                        $editType = 'text';
                                                                                        if (!empty($field->field_options)) {
                                                                                            $options = is_array($field->field_options) ? $field->field_options : json_decode($field->field_options, true);
                                                                                            if (isset($options['original_type'])) {
                                                                                                $editType = $options['original_type'];
                                                                                            } else {
                                                                                                // Map old types
                                                                                                if ($field->field_type == 'doc') {
                                                                                                    $editType = 'docs';
                                                                                                } elseif ($field->field_type == 'input') {
                                                                                                    $editType = 'text';
                                                                                                }
                                                                                            }
                                                                                        } else {
                                                                                            // Map database types to display types
                                                                                            if ($field->field_type == 'doc') {
                                                                                                $editType = 'docs';
                                                                                            } elseif ($field->field_type == 'input') {
                                                                                                $editType = 'text';
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <button type="button" class="btn btn-sm btn-secondary edit-field-btn" data-field-id="<?php echo e($field->id); ?>" data-field-label="<?php echo e($field->field_label); ?>" data-field-type="<?php echo e($editType); ?>" data-field-required="<?php echo e($field->is_required ? 1 : 0); ?>">
                                                                                        <i class="ti ti-edit"></i>
                                                                                    </button>
                                                                                    <button type="button" class="btn btn-sm btn-danger delete-field-btn" data-field-id="<?php echo e($field->id); ?>">
                                                                                        <i class="ti ti-trash"></i>
                                                                                    </button>
                                                                                <?php else: ?>
                                                                                    <span class="text-muted"><?php echo e(__('Cannot edit')); ?></span>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>


                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-6"></div>
                                                <div class="col-6 text-end">
                                                    <input type="hidden" name="tab"
                                                        value="profile_tab_<?php echo e($section->id); ?>">
                                                    <?php echo e(Form::submit(__('Save'), ['class' => 'btn btn-secondary btn-rounded'])); ?>

                                                </div>
                                            </div>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Field Modal -->
    <div class="modal fade" id="addFieldModal" tabindex="-1" aria-labelledby="addFieldModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFieldModalLabel"><?php echo e(__('Add Field')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="fieldForm">
                        <input type="hidden" id="fieldId" name="field_id">
                        <div class="form-group mb-3">
                            <label for="fieldLabel" class="form-label"><?php echo e(__('Field Label')); ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fieldLabel" name="field_label" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fieldType" class="form-label"><?php echo e(__('Field Type')); ?> <span class="text-danger">*</span></label>
                            <select class="form-control" id="fieldType" name="field_type" required>
                                <option value="text"><?php echo e(__('Text')); ?></option>
                                <option value="number"><?php echo e(__('Number')); ?></option>
                                <option value="docs"><?php echo e(__('Document Upload')); ?></option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="isRequired" name="is_required">
                                <label class="form-check-label" for="isRequired">
                                    <?php echo e(__('Required Field')); ?>

                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                    <button type="button" class="btn btn-secondary" id="saveFieldBtn"><?php echo e(__('Save')); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).ready(function() {
            // Field type change handler (no options needed for text, number, docs)

            // Add Field
            $('#saveFieldBtn').on('click', function(e) {
                e.preventDefault();
                
                // Validate form
                if (!$('#fieldLabel').val() || !$('#fieldLabel').val().trim()) {
                    toastrs('Error!', '<?php echo e(__('Field Label is required')); ?>', 'error');
                    return;
                }
                
                if (!$('#fieldType').val()) {
                    toastrs('Error!', '<?php echo e(__('Field Type is required')); ?>', 'error');
                    return;
                }
                
                let formData = {
                    field_label: $('#fieldLabel').val().trim(),
                    field_type: $('#fieldType').val(),
                    is_required: $('#isRequired').is(':checked') ? 1 : 0,
                    _token: '<?php echo e(csrf_token()); ?>'
                };

                let fieldId = $('#fieldId').val();
                let url = fieldId ? '<?php echo e(route("lead-form-field.update", ":id")); ?>'.replace(':id', fieldId) : '<?php echo e(route("lead-form-field.store")); ?>';
                let method = fieldId ? 'PUT' : 'POST';

                // Disable button to prevent double submission
                $('#saveFieldBtn').prop('disabled', true).text('<?php echo e(__('Saving...')); ?>');

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            toastrs('Success!', response.msg, 'success');
                            $('#addFieldModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            toastrs('Error!', response.msg, 'error');
                            $('#saveFieldBtn').prop('disabled', false).text('<?php echo e(__('Save')); ?>');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = '<?php echo e(__('An error occurred')); ?>';
                        if (xhr.responseJSON && xhr.responseJSON.msg) {
                            errorMsg = xhr.responseJSON.msg;
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                let errorData = JSON.parse(xhr.responseText);
                                errorMsg = errorData.msg || errorData.message || errorMsg;
                            } catch(e) {
                                // Keep default error message
                            }
                        }
                        toastrs('Error!', errorMsg, 'error');
                        $('#saveFieldBtn').prop('disabled', false).text('<?php echo e(__('Save')); ?>');
                    }
                });
            });

            // Edit Field
            $(document).on('click', '.edit-field-btn', function() {
                let fieldId = $(this).data('field-id');
                let fieldLabel = $(this).data('field-label');
                let fieldType = $(this).data('field-type');
                let fieldRequired = $(this).data('field-required');

                $('#fieldId').val(fieldId);
                $('#fieldLabel').val(fieldLabel);
                $('#fieldType').val(fieldType);
                $('#isRequired').prop('checked', fieldRequired == 1);

                $('#addFieldModalLabel').text('<?php echo e(__('Edit Field')); ?>');
                $('#saveFieldBtn').prop('disabled', false).text('<?php echo e(__('Save')); ?>');
                $('#addFieldModal').modal('show');
            });

            // Delete Field
            $(document).on('click', '.delete-field-btn', function() {
                if (!confirm('<?php echo e(__('Are you sure you want to delete this field?')); ?>')) {
                    return;
                }

                let fieldId = $(this).data('field-id');
                $.ajax({
                    url: '<?php echo e(route("lead-form-field.destroy", ":id")); ?>'.replace(':id', fieldId),
                    method: 'DELETE',
                    data: { _token: '<?php echo e(csrf_token()); ?>' },
                    success: function(response) {
                        if (response.status === 'success') {
                            toastrs('Success!', response.msg, 'success');
                            location.reload();
                        } else {
                            toastrs('Error!', response.msg, 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON?.msg || '<?php echo e(__('An error occurred')); ?>';
                        toastrs('Error!', errorMsg, 'error');
                    }
                });
            });

            // Reset modal on close
            $('#addFieldModal').on('hidden.bs.modal', function() {
                $('#fieldForm')[0].reset();
                $('#fieldId').val('');
                $('#saveFieldBtn').prop('disabled', false).text('<?php echo e(__('Save')); ?>');
                $('#addFieldModalLabel').text('<?php echo e(__('Add Field')); ?>');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/front-home/index.blade.php ENDPATH**/ ?>