<?php echo e(Form::open(['url' => 'amenity', 'enctype' => 'multipart/form-data'])); ?>


<div class="modal-body">
    <div class="form-group col-md-12">
        <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

        <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Amenity Name')])); ?>

    </div>
    <div class="form-group col-md-12">
        <?php echo e(Form::label('image', __('Image'), ['class' => 'form-label'])); ?>

        <?php echo e(Form::file('image', ['class' => 'form-control'])); ?>

    </div>
    <div class="form-group col-md-12">
        <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

        <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3])); ?>

    </div>
</div>
<div class="modal-footer">
    <?php echo e(Form::submit(__('Create'), ['class' => 'btn btn-secondary btn-rounded'])); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/amenity/create.blade.php ENDPATH**/ ?>