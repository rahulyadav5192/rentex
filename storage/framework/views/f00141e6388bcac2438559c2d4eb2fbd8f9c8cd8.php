<?php echo e(Form::model($blog, array('route' => array('blog.update', $blog->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('title',__('Title'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Title')))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('image', __('Image'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::file('image', ['class' => 'form-control'])); ?>

            <?php if(!empty($blog->image)): ?>
                <?php
                    $currentImageUrl = fetch_file($blog->image, 'upload/blog/image/');
                ?>
                <?php if(!empty($currentImageUrl)): ?>
                    <div class="mt-2">
                        <img src="<?php echo e($currentImageUrl); ?>" alt="Current Image" 
                             style="max-width: 200px; max-height: 150px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;"
                             onerror="this.style.display='none';">
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('enabled', __('Enabled Page'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::hidden('enabled', 0, ['class' => 'form-check-input'])); ?>

            <div class="form-check form-switch">
                <?php echo e(Form::checkbox('enabled', 1, true, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'flexSwitchCheckChecked'])); ?>

                <?php echo e(Form::label('', '', ['class' => 'form-check-label'])); ?>

            </div>
        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('content',__('Content'),array('class'=>'form-label'))); ?>

            <?php echo Form::textarea('content', null, ['class' => 'form-control', 'id' => 'classic-editor']); ?>

        </div>
    </div>
</div>
<div class="modal-footer">

    <?php echo e(Form::submit(__('Update'),array('class'=>'btn btn-secondary btn-rounded'))); ?>

</div>
<?php echo e(Form::close()); ?>


<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/blog/edit.blade.php ENDPATH**/ ?>