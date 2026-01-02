<?php
$user=\Auth::user();
$tenant=$user->tenants;
?>
<?php echo e(Form::open(array('url'=>'maintenance-request','method'=>'post', 'enctype' => "multipart/form-data", 'id' => 'maintenance-request-create-form'))); ?>

<div class="modal-body">
    <div class="row">
        <?php if($user->type=='tenant'): ?>
            <?php echo e(Form::hidden('property_id',!empty($tenant)?$tenant->property:null,array('class'=>'form-control'))); ?>

            <?php echo e(Form::hidden('unit_id',!empty($tenant)?$tenant->unit:null,array('class'=>'form-control'))); ?>

        <?php else: ?>
            <div class="form-group col-md-6 col-lg-6">
                <?php echo e(Form::label('property_id',__('Property'),array('class'=>'form-label'))); ?>

                <?php echo e(Form::select('property_id',$property,null,array('class'=>'form-control hidesearch','id'=>'property_id','required'=>'required'))); ?>

            </div>
            <div class="form-group col-lg-6 col-md-6">
                <?php echo e(Form::label('unit_id',__('Unit'),array('class'=>'form-label'))); ?>

                <div class="unit_div">
                    <select class="form-control hidesearch unit" id="unit_id" name="unit_id" required="required">
                        <option value=""><?php echo e(__('Select Unit')); ?></option>
                    </select>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-group  col-md-6 col-lg-6">
            <?php echo e(Form::label('request_date',__('Request Date'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::date('request_date',null,array('class'=>'form-control','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('maintainer_id',__('Maintainer'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::select('maintainer_id',$maintainers,null,array('class'=>'form-control hidesearch','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('issue_type',__('Issue Type'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::select('issue_type',$types,null,array('class'=>'form-control hidesearch','required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
            <?php echo e(Form::label('status',__('Status'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::select('status',$status,null,array('class'=>'form-control hidesearch'))); ?>

        </div>
        <div class="form-group  col-md-12 col-lg-12">
            <?php echo e(Form::label('issue_attachment',__('Issue Attachment'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::file('issue_attachment',array('class'=>'form-control'))); ?>

        </div>
        <div class="form-group  col-md-12 col-lg-12">
            <?php echo e(Form::label('notes',__('Notes'),array('class'=>'form-label'))); ?>

            <?php echo e(Form::textarea('notes',null,array('class'=>'form-control','rows'=>3))); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <?php echo e(Form::submit(__('Create'),array('class'=>'btn btn-secondary btn-rounded'))); ?>

</div>
<?php echo e(Form::close()); ?>

<script>
    $('#property_id').on('change', function () {
        "use strict";
        var property_id=$(this).val();
        var url = '<?php echo e(route("property.unit", ":id")); ?>';
        url = url.replace(':id', property_id);
        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                property_id:property_id,
            },
            contentType: false,
            processData: false,
            type: 'GET',
            success: function (data) {
                $('.unit').empty();
                var unit = `<select class="form-control hidesearch unit" id="unit_id" name="unit_id" required="required"></select>`;
                $('.unit_div').html(unit);

                $.each(data, function(key, value) {
                    $('.unit').append('<option value="' + key + '">' + value +'</option>');
                });
                $(".hidesearch").each(function() {
                    var basic_select = new Choices(this, {
                        searchEnabled: false,
                        removeItemButton: true,
                    });
                });
            },

        });
    });

    // Client-side validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('maintenance-request-create-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Clear previous error messages
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                form.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.remove();
                });

                let isValid = true;
                const userType = '<?php echo e($user->type); ?>';
                
                // Validate fields based on user type
                if (userType !== 'tenant') {
                    // Validate property_id
                    const propertySelect = form.querySelector('[name="property_id"]');
                    if (propertySelect && (!propertySelect.value || propertySelect.value === '0')) {
                        isValid = false;
                        propertySelect.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = '<?php echo e(__('Property')); ?> <?php echo e(__('is required')); ?>';
                        propertySelect.parentElement.appendChild(errorDiv);
                    }

                    // Validate unit_id
                    const unitSelect = form.querySelector('[name="unit_id"]');
                    if (unitSelect && (!unitSelect.value || unitSelect.value === '')) {
                        isValid = false;
                        unitSelect.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = '<?php echo e(__('Unit')); ?> <?php echo e(__('is required')); ?>';
                        unitSelect.parentElement.appendChild(errorDiv);
                    }
                }

                // Validate request_date
                const requestDate = form.querySelector('[name="request_date"]');
                if (requestDate && !requestDate.value) {
                    isValid = false;
                    requestDate.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = '<?php echo e(__('Request Date')); ?> <?php echo e(__('is required')); ?>';
                    requestDate.parentElement.appendChild(errorDiv);
                }

                // Validate maintainer_id
                const maintainerSelect = form.querySelector('[name="maintainer_id"]');
                if (maintainerSelect && (!maintainerSelect.value || maintainerSelect.value === '')) {
                    isValid = false;
                    maintainerSelect.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = '<?php echo e(__('Maintainer')); ?> <?php echo e(__('is required')); ?>';
                    maintainerSelect.parentElement.appendChild(errorDiv);
                }

                // Validate issue_type
                const issueTypeSelect = form.querySelector('[name="issue_type"]');
                if (issueTypeSelect && (!issueTypeSelect.value || issueTypeSelect.value === '')) {
                    isValid = false;
                    issueTypeSelect.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = '<?php echo e(__('Issue Type')); ?> <?php echo e(__('is required')); ?>';
                    issueTypeSelect.parentElement.appendChild(errorDiv);
                }

                if (!isValid) {
                    e.preventDefault();
                    e.stopPropagation();
                    // Scroll to first error
                    const firstError = form.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                }
            });
        }
    });
</script>

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/maintenance_request/create.blade.php ENDPATH**/ ?>