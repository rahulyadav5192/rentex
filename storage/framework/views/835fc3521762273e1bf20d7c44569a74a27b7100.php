<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Property Create')); ?>

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
        // Prevent multiple submissions
        let isSubmitting = false;
        
        // Remove any existing handlers first to prevent duplicates
        $('#property-submit').off('click').on('click', function(e) {
            "use strict";
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation(); // Prevent other handlers from firing
            
            // Prevent multiple clicks
            if (isSubmitting) {
                return false;
            }
            
            // Clear previous error messages
            $('.error-message').remove();
            $('.is-invalid').removeClass('is-invalid');
            
            // Small delay to ensure checkbox states are updated before validation
            // Increased delay to ensure DOM state is fully updated
            setTimeout(function() {
                validateAndSubmit();
            }, 100);
        });
        
        function validateAndSubmit() {
            // Validate all required tabs - collect all errors first
            let allValid = true;
            let firstErrorTab = null;
            let firstErrorMsg = '';
            
            // Validate each tab
            $('.tab-pane').each(function() {
                let $tab = $(this);
                let currentTabId = $tab.attr('id');
                let tabIsValid = true;
                
                // Validate based on tab
                if (currentTabId === 'profile-1') {
                    // Property Details validation
                    let requiredFields = $tab.find('[required]');
                    requiredFields.each(function() {
                        let $field = $(this);
                        let fieldId = $field.attr('id');
                        
                        if ($field.prop('disabled')) {
                            return true;
                        }

                        if (fieldId === 'classic-editor') {
                            // CKEditor validation - try multiple methods to get content
                            let editorContent = '';
                            let hasContent = false;
                            
                            // Method 1: Try to get from ClassicEditor instance
                            if (typeof ClassicEditor !== 'undefined') {
                                try {
                                    // ClassicEditor stores instances, try to access it
                                    let editorElement = document.querySelector('#classic-editor');
                                    if (editorElement) {
                                        // Check if editor is attached to element
                                        if (editorElement.ckeditorInstance) {
                                            editorContent = editorElement.ckeditorInstance.getData();
                                            hasContent = editorContent && editorContent.trim() !== '';
                                        }
                                        // Try accessing via ClassicEditor.instances
                                        if (!hasContent && ClassicEditor.instances) {
                                            // Check if instances is a Map or object
                                            let editorInstance = null;
                                            if (ClassicEditor.instances instanceof Map) {
                                                editorInstance = ClassicEditor.instances.get(editorElement);
                                            } else if (ClassicEditor.instances['classic-editor']) {
                                                editorInstance = ClassicEditor.instances['classic-editor'];
                                            } else if (ClassicEditor.instances[editorElement]) {
                                                editorInstance = ClassicEditor.instances[editorElement];
                                            }
                                            
                                            if (editorInstance && typeof editorInstance.getData === 'function') {
                                                editorContent = editorInstance.getData();
                                                hasContent = editorContent && editorContent.trim() !== '';
                                            }
                                        }
                                    }
                                } catch (e) {
                                    console.log('Error accessing ClassicEditor instance:', e);
                                }
                            }
                            
                            // Method 2: Check .ck-content div directly (same method used in form submission)
                            // This matches how the form gets description: $('.ck-content').html()
                            if (!hasContent) {
                                // Use the same selector as form submission
                                let $ckContent = $('.ck-content');
                                
                                if ($ckContent.length > 0) {
                                    // Get HTML content (same as form submission)
                                    editorContent = $ckContent.html() || '';
                                    
                                    // Also get text content for validation
                                    let textContent = $ckContent.text() || '';
                                    
                                    // Create temp div to extract pure text from HTML
                                    let tempDiv = document.createElement('div');
                                    tempDiv.innerHTML = editorContent;
                                    let extractedText = (tempDiv.textContent || tempDiv.innerText || '').trim();
                                    
                                    // Check if we have actual content
                                    // Empty HTML patterns that should be considered empty
                                    let emptyPatterns = [
                                        '', 
                                        '<p></p>', 
                                        '<p><br></p>', 
                                        '<p><br/></p>',
                                        '<br>', 
                                        '<br/>',
                                        '<p>&nbsp;</p>',
                                        '<p> </p>'
                                    ];
                                    
                                    let isEmptyHtml = emptyPatterns.includes(editorContent.trim()) || 
                                                     (editorContent.trim().length === 0);
                                    
                                    // Content is valid if there's actual text (not just empty HTML)
                                    hasContent = (extractedText.length > 0) || 
                                                (textContent.trim().length > 0) ||
                                                (editorContent.trim().length > 0 && !isEmptyHtml);
                                }
                            }
                            
                            // Method 3: Check textarea value as fallback
                            if (!hasContent) {
                                let textareaValue = $field.val() || '';
                                hasContent = textareaValue.trim().length > 0;
                            }
                            
                            // Debug: Log if content is found (remove in production)
                            // console.log('CKEditor validation - hasContent:', hasContent, 'editorContent:', editorContent);
                            
                            if (!hasContent) {
                                tabIsValid = false;
                                allValid = false;
                                let $formGroup = $field.closest('.form-group');
                                if (!$formGroup.find('.error-message').length) {
                                    $formGroup.append('<div class="error-message text-danger small mt-1">Description is required.</div>');
                                }
                                let $ckEditor = $('#classic-editor').closest('.ck-editor');
                                if ($ckEditor.length) {
                                    $ckEditor.addClass('is-invalid');
                                }
                                if (!firstErrorTab) {
                                    firstErrorTab = $tab;
                                    firstErrorMsg = 'Description is required.';
                                }
                            }
                        } else {
                            let fieldValue = $field.val();
                            if (!fieldValue || fieldValue.trim() === '') {
                                tabIsValid = false;
                                allValid = false;
                                $field.addClass('is-invalid');
                                let label = $field.closest('.form-group').find('label').text() || $field.attr('name') || 'Field';
                                let labelText = (label && typeof label === 'string' && label.trim() !== '') ? label.trim() : 'This field';
                                if (!$field.next('.error-message').length) {
                                    $field.after('<div class="error-message text-danger small mt-1">' + labelText + ' is required.</div>');
                                }
                                if (!firstErrorTab) {
                                    firstErrorTab = $tab;
                                    firstErrorMsg = labelText + ' is required.';
                                }
                            }
                        }
                    });
                } else if (currentTabId === 'profile-3') {
                    // Unit validation
                    let unitFields = $tab.find('.unit_list:first [required]');
                    unitFields.each(function() {
                        let $field = $(this);
                        let fieldValue = $field.val();
                        
                        if ($field.prop('disabled')) {
                            return true;
                        }

                        if (!fieldValue || fieldValue.toString().trim() === '') {
                            tabIsValid = false;
                            allValid = false;
                            $field.addClass('is-invalid');
                            let label = $field.closest('.form-group').find('label').text() || $field.attr('name') || 'Field';
                            let labelText = (label && typeof label === 'string' && label.trim() !== '') ? label.trim() : 'This field';
                            if (!$field.next('.error-message').length) {
                                $field.after('<div class="error-message text-danger small mt-1">' + labelText + ' is required.</div>');
                            }
                            if (!firstErrorTab) {
                                firstErrorTab = $tab;
                                firstErrorMsg = labelText + ' is required.';
                            }
                        }
                    });
                } else if (currentTabId === 'profile-5') {
                    // Advantages are now optional - no validation needed
                    // Validate listing fields only if "Property will display in listings?" is checked
                    let displayInListing = $('#display_in_listing').is(':checked');
                    
                    if (displayInListing) {
                        // Listing Type is required when display_in_listing is checked
                        let listingType = $('input[name="listing_type"]:checked').val();
                        
                        if (!listingType) {
                            tabIsValid = false;
                            allValid = false;
                            let $listingTypeContainer = $('#listing_type_container');
                            
                            // Remove existing error messages first
                            $listingTypeContainer.find('.error-message').remove();
                            
                            // Add error message
                            if (!$listingTypeContainer.find('.error-message').length) {
                                $listingTypeContainer.append('<div class="error-message text-danger small mt-2"><strong>Please select a listing type (Rent or Sell).</strong></div>');
                            }
                            if (!firstErrorTab) {
                                firstErrorTab = $tab;
                                firstErrorMsg = 'Please select a listing type (Rent or Sell).';
                            }
                        } else {
                            // Remove listing type error if selected
                            $('#listing_type_container').find('.error-message').remove();
                            
                            // Validate price based on listing type
                            if (listingType === 'rent') {
                                // Monthly Rent Price is required
                                let rentPrice = $('#rent_price').val();
                                if (!rentPrice || rentPrice.trim() === '' || parseFloat(rentPrice) <= 0) {
                                    tabIsValid = false;
                                    allValid = false;
                                    let $rentPriceInput = $('#rent_price_input');
                                    
                                    // Remove existing error messages first
                                    $rentPriceInput.find('.error-message').remove();
                                    $('#rent_price').removeClass('is-invalid');
                                    
                                    // Add error message
                                    if (!$rentPriceInput.find('.error-message').length) {
                                        $rentPriceInput.append('<div class="error-message text-danger small mt-1"><strong>Monthly Rent Price is required.</strong></div>');
                                        $('#rent_price').addClass('is-invalid');
                                    }
                                    if (!firstErrorTab) {
                                        firstErrorTab = $tab;
                                        firstErrorMsg = 'Monthly Rent Price is required.';
                                    }
                                } else {
                                    // Remove rent price error if valid
                                    $('#rent_price_input').find('.error-message').remove();
                                    $('#rent_price').removeClass('is-invalid');
                                }
                            } else if (listingType === 'sell') {
                                // Sell Price is required
                                let sellPrice = $('#sell_price').val();
                                if (!sellPrice || sellPrice.trim() === '' || parseFloat(sellPrice) <= 0) {
                                    tabIsValid = false;
                                    allValid = false;
                                    let $sellPriceInput = $('#sell_price_input');
                                    
                                    // Remove existing error messages first
                                    $sellPriceInput.find('.error-message').remove();
                                    $('#sell_price').removeClass('is-invalid');
                                    
                                    // Add error message
                                    if (!$sellPriceInput.find('.error-message').length) {
                                        $sellPriceInput.append('<div class="error-message text-danger small mt-1"><strong>Sell Price is required.</strong></div>');
                                        $('#sell_price').addClass('is-invalid');
                                    }
                                    if (!firstErrorTab) {
                                        firstErrorTab = $tab;
                                        firstErrorMsg = 'Sell Price is required.';
                                    }
                                } else {
                                    // Remove sell price error if valid
                                    $('#sell_price_input').find('.error-message').remove();
                                    $('#sell_price').removeClass('is-invalid');
                                }
                            }
                        }
                    } else {
                        // If display_in_listing is not checked, remove all listing-related errors
                        $('#listing_type_container').find('.error-message').remove();
                        $('#rent_price_input').find('.error-message').remove();
                        $('#sell_price_input').find('.error-message').remove();
                        $('#rent_price, #sell_price').removeClass('is-invalid');
                    }
                }
            });
            
            // If validation failed, show error and switch to first error tab
            if (!allValid) {
                if (firstErrorTab) {
                    let tabId = firstErrorTab.attr('id');
                    $('a[href="#' + tabId + '"]').tab('show');
                }
                // Show only ONE error message - use flag to prevent duplicates
                if (!window._showingValidationError) {
                    window._showingValidationError = true;
                    setTimeout(function() {
                        if (firstErrorMsg && firstErrorMsg.trim().length > 1) {
                            toastrs('Error', firstErrorMsg.trim(), 'error');
                        } else {
                            toastrs('Error', 'Please fix the validation errors before submitting.', 'error');
                        }
                        setTimeout(function() {
                            window._showingValidationError = false;
                        }, 1000);
                    }, 10);
                }
                isSubmitting = false; // Reset flag
                $('#property-submit').attr('disabled', false); // Re-enable button
                return false;
            }
            
            // All validation passed, proceed with submission
            isSubmitting = true;
            $('#property-submit').attr('disabled', true);
            var fd = new FormData();
            
            // Only append thumbnail if a file is selected
            var thumbnailInput = document.getElementById('thumbnail');
            if (thumbnailInput && thumbnailInput.files && thumbnailInput.files.length > 0) {
                var file = thumbnailInput.files[0];
                fd.append('thumbnail', file);
            }

            var files = $('#demo-upload').get(0).dropzone.getAcceptedFiles();
            $.each(files, function(key, file) {
                fd.append('property_images[' + key + ']', $('#demo-upload')[0].dropzone
                    .getAcceptedFiles()[key]); // attach dropzone image element
            });
            var other_data = $('#property_form').serializeArray();
            $.each(other_data, function(key, input) {
                fd.append(input.name, input.value);
            });
            fd.append('description', $('.ck-content').html());
            
            // Ensure final_price is set before submission
            let listingType = $('input[name="listing_type"]:checked').val();
            if (listingType === 'rent') {
                fd.append('price', $('#rent_price').val() || '');
            } else if (listingType === 'sell') {
                fd.append('price', $('#sell_price').val() || '');
            } else {
                fd.append('price', $('#final_price').val() || '');
            }

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
                        toastrs(data.status, data.msg || 'Property created successfully!', data.status);
                        var url = '<?php echo e(route('property.show', ':id')); ?>';
                        url = url.replace(':id', data.id);
                        setTimeout(() => {
                            window.location.href = url;
                        }, "1000");

                    } else {
                        var errorMsg = data.msg || data.message || 'An error occurred. Please try again.';
                        // Ensure error message is valid before showing
                    if (errorMsg && typeof errorMsg === 'string' && errorMsg.trim().length > 1) {
                        toastrs('Error', errorMsg.trim(), 'error');
                    } else {
                        toastrs('Error', 'Please fix the validation errors.', 'error');
                    }
                        $('#property-submit').attr('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    isSubmitting = false;
                    $('#property-submit').attr('disabled', false);
                    var errorMessage = 'An error occurred. Please try again.';
                    var allErrors = [];
                    
                    if (xhr.responseJSON) {
                        // Handle validation errors - collect all error messages
                        if (xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            // Collect all error messages
                            for (var field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    if (Array.isArray(errors[field])) {
                                        allErrors = allErrors.concat(errors[field]);
                                    } else {
                                        allErrors.push(errors[field]);
                                    }
                                }
                            }
                            // Use first error as primary message, but show all if multiple
                            if (allErrors.length > 0) {
                                errorMessage = allErrors[0];
                            } else {
                                errorMessage = 'Validation error occurred.';
                            }
                        } else if (xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON.msg) {
                            errorMessage = xhr.responseJSON.msg;
                        }
                    } else if (xhr.responseText) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.errors) {
                                var errors = response.errors;
                                for (var field in errors) {
                                    if (errors.hasOwnProperty(field)) {
                                        if (Array.isArray(errors[field])) {
                                            allErrors = allErrors.concat(errors[field]);
                                        } else {
                                            allErrors.push(errors[field]);
                                        }
                                    }
                                }
                                if (allErrors.length > 0) {
                                    errorMessage = allErrors[0];
                                }
                            } else if (response.message) {
                                errorMessage = response.message;
                            } else if (response.msg) {
                                errorMessage = response.msg;
                            }
                        } catch (e) {
                            errorMessage = 'An error occurred. Please try again.';
                        }
                    }
                    
                    // Ensure error message is valid before showing
                    if (errorMessage && typeof errorMessage === 'string' && errorMessage.trim().length > 1) {
                        // Show first error message
                        toastrs('Error', errorMessage.trim(), 'error');
                        
                        // If there are multiple errors, show them all after a delay
                        if (allErrors.length > 1) {
                            setTimeout(function() {
                                for (var i = 1; i < allErrors.length; i++) {
                                    if (allErrors[i] && typeof allErrors[i] === 'string' && allErrors[i].trim().length > 1) {
                                        setTimeout(function(err) {
                                            toastrs('Error', err.trim(), 'error');
                                        }, i * 500, allErrors[i]);
                                    }
                                }
                            }, 1000);
                        }
                    } else {
                        toastrs('Error', 'An error occurred. Please try again.', 'error');
                    }
                },
            });
        }
    </script>

    <script>
        $('#rent_type').on('change', function() {
            "use strict";
            var type = this.value;
            $('.rent_type').addClass('d-none')
            $('.' + type).removeClass('d-none')

            var input1 = $('.rent_type').find('input');
            input1.prop('disabled', true);
            var input2 = $('.' + type).find('input');
            input2.prop('disabled', false);
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to validate current tab
            function validateCurrentTab() {
                let $activeTab = $('.tab-content .tab-pane.active');
                let tabId = $activeTab.attr('id');
                let isValid = true;
                let errorMessages = [];

                // Remove previous error messages
                $activeTab.find('.error-message').remove();
                $activeTab.find('.is-invalid').removeClass('is-invalid');

                // Validate based on tab
                if (tabId === 'profile-1') {
                    // Property Details validation
                    let requiredFields = $activeTab.find('[required]');
                    requiredFields.each(function() {
                        let $field = $(this);
                        let fieldName = $field.attr('name') || $field.attr('id');
                        let fieldId = $field.attr('id');
                        let fieldValue = '';
                        
                        // Skip disabled fields
                        if ($field.prop('disabled')) {
                            return true;
                        }

                        // Special handling for rich text editor (CKEditor)
                        if (fieldId === 'classic-editor') {
                            let editorContent = '';
                            
                            // Method 1: Check .ck-content div directly (most reliable)
                            let $ckEditor = $('#classic-editor').closest('.ck-editor');
                            let $ckContent = $ckEditor.find('.ck-content');
                            
                            if ($ckContent.length) {
                                editorContent = $ckContent.html();
                            } else {
                                // Try finding .ck-content anywhere in the form
                                $ckContent = $activeTab.find('.ck-content');
                                if ($ckContent.length) {
                                    editorContent = $ckContent.html();
                                }
                            }
                            
                            // Method 2: Try to get from ClassicEditor instance if available
                            if ((!editorContent || editorContent.trim() === '') && typeof ClassicEditor !== 'undefined') {
                                try {
                                    // Try to find editor instance via DOM element
                                    let editorElement = document.querySelector('#' + fieldId);
                                    if (editorElement && editorElement.ckeditorInstance) {
                                        editorContent = editorElement.ckeditorInstance.getData();
                                    }
                                } catch (e) {
                                    // Ignore errors
                                }
                            }
                            
                            // Method 3: Last resort - check textarea value
                            if (!editorContent || editorContent.trim() === '') {
                                editorContent = $field.val() || '';
                            }
                            
                            // Clean HTML tags to check if there's actual text content
                            // Remove all HTML tags and check for text
                            let tempDiv = document.createElement('div');
                            tempDiv.innerHTML = editorContent || '';
                            let textContent = tempDiv.textContent || tempDiv.innerText || '';
                            textContent = textContent.trim();
                            
                            if (!textContent || textContent === '') {
                                isValid = false;
                                // Add error to the form group
                                let $formGroup = $field.closest('.form-group');
                                if (!$formGroup.find('.error-message').length) {
                                    $formGroup.append('<div class="error-message text-danger small mt-1">Description is required.</div>');
                                }
                                // Mark the editor container visually
                                if ($ckEditor.length) {
                                    $ckEditor.addClass('is-invalid');
                                } else {
                                    $formGroup.addClass('is-invalid');
                                }
                                errorMessages.push('Description is required.');
                            }
                        } else {
                            // Regular field validation
                            fieldValue = $field.val();
                            if (!fieldValue || fieldValue.trim() === '') {
                                isValid = false;
                                $field.addClass('is-invalid');
                                let label = $field.closest('.form-group').find('label').text() || fieldName;
                                errorMessages.push(label + ' is required.');
                                
                                // Add error message below field
                                if (!$field.next('.error-message').length) {
                                    $field.after('<div class="error-message text-danger small mt-1">' + label + ' is required.</div>');
                                }
                            }
                        }
                    });
                } else if (tabId === 'profile-2') {
                    // Property Images validation (optional, but can add if needed)
                    // Images are optional, so we'll skip validation
                } else if (tabId === 'profile-4') {
                    // Amenities validation (optional)
                    // Amenities are optional, so we'll skip validation
                } else if (tabId === 'profile-5') {
                    // Advantages validation - at least one must be selected
                    let $advantagesCheckboxes = $activeTab.find('input[name="advantages[]"]');
                    let checkedAdvantages = $activeTab.find('input[name="advantages[]"]:checked');
                    
                    if (checkedAdvantages.length === 0) {
                        isValid = false;
                        errorMessages.push('Please select at least one advantage.');
                        
                        // Add error message to the advantages section
                        let $advantagesContainer = $activeTab.find('.card-body').first();
                        if (!$advantagesContainer.find('.error-message').length) {
                            $advantagesContainer.prepend('<div class="error-message text-danger small mb-3"><strong>Please select at least one advantage.</strong></div>');
                        }
                    } else {
                        // Remove error if advantages are selected
                        $activeTab.find('.error-message').remove();
                    }
                } else if (tabId === 'profile-3') {
                    // Unit validation
                    let unitFields = $activeTab.find('.unit_list:first [required]');
                    unitFields.each(function() {
                        let $field = $(this);
                        let fieldValue = $field.val();
                        
                        // Skip disabled fields
                        if ($field.prop('disabled')) {
                            return true;
                        }

                        if (!fieldValue || fieldValue.toString().trim() === '') {
                            isValid = false;
                            $field.addClass('is-invalid');
                            let label = $field.closest('.form-group').find('label').text() || $field.attr('name') || 'Field';
                            // Ensure label is a valid string
                            if (label && typeof label === 'string' && label.trim() !== '') {
                                errorMessages.push(label.trim() + ' is required.');
                            } else {
                                errorMessages.push('This field is required.');
                            }
                            
                            // Add error message below field
                            if (!$field.next('.error-message').length) {
                                $field.after('<div class="error-message text-danger small mt-1">' + label + ' is required.</div>');
                            }
                        }
                    });
                }
                // profile-4 (Amenities) is optional, no validation needed

                if (!isValid && errorMessages.length > 0) {
                    // Don't show toast here - only show toast on submit button click
                    // Just scroll to first error
                    let $firstError = $activeTab.find('.is-invalid').first();
                    if ($firstError.length) {
                        $('html, body').animate({
                            scrollTop: $firstError.offset().top - 100
                        }, 500);
                    } else {
                        // If no invalid field (like for advantages), scroll to error message
                        let $errorMsg = $activeTab.find('.error-message').first();
                        if ($errorMsg.length) {
                            $('html, body').animate({
                                scrollTop: $errorMsg.offset().top - 100
                            }, 500);
                        }
                    }
                }

                return isValid;
            }

            $('.nextButton').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // If it's the submit button, don't do anything - the #property-submit handler handles it
                // The submit button has both class 'nextButton' and id 'property-submit'
                // The #property-submit handler fires first and uses stopImmediatePropagation()
                if ($(this).hasClass('submit-button') || $(this).attr('id') === 'property-submit') {
                    // Do nothing - let the #property-submit handler handle it
                    return false;
                }

                // Validate current tab before moving to next
                if (!validateCurrentTab()) {
                    return false;
                }

                let $activeTab = $('.tab-content .tab-pane.active'); // Current active tab
                let $nextTab = $activeTab.next('.tab-pane'); // Next tab

                if ($nextTab.length > 0) {
                    let nextTabId = $nextTab.attr('id');
                    $('a[href="#' + nextTabId + '"]').tab('show'); // Move to next tab

                    // If the next tab is the last, change the button text to "Submit"
                    if ($nextTab.is(':last-child')) {
                        $(this).text('Submit').addClass('submit-button');
                    }
                }
            });

            // Listen for display_in_listing checkbox changes to show/hide listing fields
            $(document).on('change', '#display_in_listing', function() {
                // Clear any existing listing-related errors when checkbox state changes
                $('#listing_type_container').find('.error-message').remove();
                $('#rent_price_input').find('.error-message').remove();
                $('#sell_price_input').find('.error-message').remove();
                $('#rent_price, #sell_price').removeClass('is-invalid');
            });
            
            // Listen for listing_type radio changes to validate price fields
            $(document).on('change', 'input[name="listing_type"]', function() {
                // Clear listing type error when selected
                $('#listing_type_container').find('.error-message').remove();
                
                // Clear price errors when listing type changes
                $('#rent_price_input').find('.error-message').remove();
                $('#sell_price_input').find('.error-message').remove();
                $('#rent_price, #sell_price').removeClass('is-invalid');
            });
            
            // Listen for price input changes to remove errors
            $(document).on('input change', '#rent_price, #sell_price', function() {
                $(this).removeClass('is-invalid');
                $(this).closest('.mb-3').find('.error-message').remove();
            });
            
            // Validate on input change to remove error styling
            $(document).on('input change', '.tab-pane [required]', function() {
                let $field = $(this);
                let fieldId = $field.attr('id');
                let hasValue = false;
                
                // Special handling for rich text editor
                if (fieldId === 'classic-editor') {
                    let editorContent = '';
                    let $ckEditor = $('#classic-editor').closest('.ck-editor');
                    let $ckContent = $ckEditor.find('.ck-content');
                    
                    if ($ckContent.length) {
                        editorContent = $ckContent.html();
                    } else {
                        $ckContent = $('.ck-content');
                        editorContent = $ckContent.length ? $ckContent.html() : '';
                    }
                    
                    // Clean HTML to get text content
                    let tempDiv = document.createElement('div');
                    tempDiv.innerHTML = editorContent || '';
                    let textContent = (tempDiv.textContent || tempDiv.innerText || '').trim();
                    hasValue = textContent !== '';
                    
                    if (hasValue) {
                        if ($ckEditor.length) {
                            $ckEditor.removeClass('is-invalid');
                        }
                        $field.closest('.form-group').find('.error-message').remove();
                    }
                } else {
                    hasValue = $field.val() && $field.val().toString().trim() !== '';
                    if (hasValue) {
                        $field.removeClass('is-invalid');
                        $field.next('.error-message').remove();
                    }
                }
            });
            
            // Listen for CKEditor content changes by monitoring the .ck-content div
            // Use MutationObserver to watch for content changes
            $(document).ready(function() {
                function setupEditorListener() {
                    let $ckContent = $('#classic-editor').closest('.ck-editor').find('.ck-content');
                    if ($ckContent.length === 0) {
                        $ckContent = $('.ck-content');
                    }
                    
                    if ($ckContent.length > 0) {
                        // Use MutationObserver to watch for content changes
                        let observer = new MutationObserver(function(mutations) {
                            let editorContent = $ckContent.html();
                            let tempDiv = document.createElement('div');
                            tempDiv.innerHTML = editorContent || '';
                            let textContent = (tempDiv.textContent || tempDiv.innerText || '').trim();
                            
                            if (textContent !== '') {
                                $('#classic-editor').closest('.ck-editor').removeClass('is-invalid');
                                $('#classic-editor').closest('.form-group').find('.error-message').remove();
                            }
                        });
                        
                        observer.observe($ckContent[0], {
                            childList: true,
                            subtree: true,
                            characterData: true
                        });
                        
                        return true;
                    }
                    return false;
                }
                
                // Try to setup listener
                if (!setupEditorListener()) {
                    // If editor not ready, try again after delay
                    setTimeout(function() {
                        if (!setupEditorListener()) {
                            setTimeout(setupEditorListener, 1000);
                        }
                    }, 500);
                }
            });

            $('a[data-toggle="tab"], a[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
                let $activeTab = $('.tab-content .tab-pane.active');
                let isLastTab = $activeTab.is(':last-child');

                if (!isLastTab) {
                    $('.nextButton').text('Next').removeClass('submit-button');
                } else {
                    $('.nextButton').text('Submit').addClass('submit-button');
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            function toggleRemoveServiceButton() {
                let serviceCount = $('.unit_list').length;
                $('.remove-service').toggle(serviceCount > 1);
            }

            $(document).on('click', '.add-unit', function() {
                let originalRow = $('.unit_list:first');


                let clonedRow = originalRow.clone();
                console.log(clonedRow);

                clonedRow.find('input, select').val('');
                clonedRow.find('.description').val('');

                let rowIndex = $('.unit_list').length;
                clonedRow.find('select[name^="skill"]').each(function() {
                    $(this).attr('name', 'skill[' + rowIndex + '][]');
                });

                let hrElement = $('<hr class="mt-2 mb-4 border-dark">');
                $('.unit_list_results').append(clonedRow).append(hrElement);

                originalRow.find('.select2').select2();
                clonedRow.find('.select2').select2();

                toggleRemoveServiceButton();

            });

            $(document).on('click', '.remove-service', function() {
                $(this).parent().parent().closest('.unit_list').next('hr').remove();
                $(this).parent().parent().closest('.unit_list').remove();
                toggleRemoveServiceButton();
            });

            toggleRemoveServiceButton();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#display_in_listing').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#listing_type_container').slideDown();
                } else {
                    $('#listing_type_container').slideUp();
                    $('#rent_price_input, #sell_price_input').slideUp();
                    $('input[name="listing_type"]').prop('checked', false);
                    $('#final_price').val('');
                }
            });

            $('input[name="listing_type"]').on('change', function() {
                if ($(this).val() === 'rent') {
                    $('#rent_price_input').slideDown();
                    $('#sell_price_input').slideUp();
                    $('#final_price').val($('#rent_price').val());
                } else if ($(this).val() === 'sell') {
                    $('#sell_price_input').slideDown();
                    $('#rent_price_input').slideUp();
                    $('#final_price').val($('#sell_price').val());
                }
            });

            // Sync value to hidden field on input
            $('#rent_price').on('input', function() {
                if ($('#type_rent').is(':checked')) {
                    $('#final_price').val($(this).val());
                }
            });

            $('#sell_price').on('input', function() {
                if ($('#type_sell').is(':checked')) {
                    $('#final_price').val($(this).val());
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('property.index')); ?>"><?php echo e(__('Property')); ?></a>
    </li>
    <li class="breadcrumb-item active"><a href="#"><?php echo e(__('Create')); ?></a>
    </li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo e(Form::open(['url' => 'property', 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'property_form'])); ?>

    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1"
                                role="tab" aria-selected="true">
                                <i class="material-icons-two-tone me-2 ">info</i>
                                <?php echo e(__('Property Details')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab"
                                aria-selected="true">
                                <i class="material-icons-two-tone me-2 ">image</i>
                                <?php echo e(__('Property Images')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-3" data-bs-toggle="tab" href="#profile-3" role="tab"
                                aria-selected="true">
                                <i class="material-icons-two-tone me-2">layers</i>
                                <?php echo e(__('Unit')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-4" data-bs-toggle="tab" href="#profile-4" role="tab"
                                aria-selected="true">
                                <i class="material-icons-two-tone me-2">fact_check</i>
                                <?php echo e(__('Amenities')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-5" data-bs-toggle="tab" href="#profile-5" role="tab"
                                aria-selected="true">
                                <i class="material-icons-two-tone me-2">thumb_up_alt</i>
                                <?php echo e(__('Advantages')); ?>

                            </a>
                        </li>

                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border">
                                        <div class="card-header">
                                            <h5> <?php echo e(__('Add Property Details')); ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="mb-3">
                                                        <div class="form-group ">
                                                            <?php echo e(Form::label('type', __('Type'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::select('type', $types, null, ['class' => 'form-control basic-select', 'required' => 'required'])); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Property Name'), 'required' => 'required'])); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <?php echo e(Form::label('thumbnail', __('Thumbnail Image'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::file('thumbnail', ['class' => 'form-control'])); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <div class="form-group ">
                                                            <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'id' => 'classic-editor', 'rows' => 4, 'placeholder' => __('Enter Property Description'), 'required' => 'required'])); ?>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <?php echo e(Form::label('country', __('Country'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('country', null, ['class' => 'form-control', 'placeholder' => __('Enter Property Country'), 'required' => 'required'])); ?>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <?php echo e(Form::label('state', __('State'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('state', null, ['class' => 'form-control', 'placeholder' => __('Enter Property State'), 'required' => 'required'])); ?>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <?php echo e(Form::label('city', __('City'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('city', null, ['class' => 'form-control', 'placeholder' => __('Enter Property City'), 'required' => 'required'])); ?>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="mb-3">
                                                        <div class="form-group">
                                                            <?php echo e(Form::label('zip_code', __('Zip Code'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::text('zip_code', null, ['class' => 'form-control', 'placeholder' => __('Enter Property Zip Code'), 'required' => 'required'])); ?>

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <div class="form-group ">
                                                            <?php echo e(Form::label('address', __('Address'), ['class' => 'form-label'])); ?>

                                                            <?php echo e(Form::textarea('address', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Enter Property Address'), 'required' => 'required'])); ?>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-secondary btn-rounded nextButton"
                                    data-next-tab="#profile-2">
                                    <?php echo e(__('Next')); ?>

                                </button>


                            </div>
                        </div>
                        <div class="tab-pane" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border">
                                        <div class="card-header">
                                            <?php echo e(Form::label('demo-upload', __('Add Property Images'), ['class' => 'form-label'])); ?>

                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="dropzone needsclick" id='demo-upload' action="#">
                                                    <div class="dz-message needsclick">
                                                        <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                                                        <h3><?php echo e(__('Drop files here or click to upload.')); ?></h3>
                                                    </div>
                                                </div>
                                                <div class="preview-dropzon" style="display: none;">
                                                    <div class="dz-preview dz-file-preview">
                                                        <div class="dz-image"><img data-dz-thumbnail="" src=""
                                                                alt=""></div>
                                                        <div class="dz-details">
                                                            <div class="dz-size"><span data-dz-size=""></span></div>
                                                            <div class="dz-filename"><span data-dz-name=""></span></div>
                                                        </div>
                                                        <div class="dz-progress"><span class="dz-upload"
                                                                data-dz-uploadprogress=""> </span></div>
                                                        <div class="dz-success-mark"><i class="fa fa-check"
                                                                aria-hidden="true"></i></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-secondary btn-rounded nextButton"
                                    data-next-tab="#profile-2">
                                    <?php echo e(__('Next')); ?>

                                </button>
                            </div>
                        </div>

                        <div class="tab-pane show " id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                            <div class="card border">
                                <div class="card-header">
                                    <h5><?php echo e(__('Add Unit')); ?></h5>
                                </div>

                                <div class="card-body">
                                    <div class="row unit_list">
                                        <div class="form-group col-md-4">
                                            <?php echo e(Form::label('unitname', __('Name'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('unitname', null, ['class' => 'form-control', 'placeholder' => __('Enter unit name'), 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-2">
                                            <?php echo e(Form::label('bedroom', __('Bedroom'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('bedroom', null, ['class' => 'form-control', 'placeholder' => __('Enter number of bedroom'), 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-2">
                                            <?php echo e(Form::label('kitchen', __('Kitchen'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('kitchen', null, ['class' => 'form-control', 'placeholder' => __('Enter number of kitchen'), 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-2">
                                            <?php echo e(Form::label('baths', __('Bath'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('baths', null, ['class' => 'form-control', 'placeholder' => __('Enter number of bath'), 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-2">
                                            <?php echo e(Form::label('rent', __('Rent'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('rent', null, ['class' => 'form-control', 'placeholder' => __('Enter unit rent'), 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('rent_type', __('Rent Type'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('rent_type', $rentTypes, null, ['class' => 'form-control hidesearch', 'id' => 'rent_type', 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-6 rent_type monthly">
                                            <?php echo e(Form::label('rent_duration', __('Rent Duration'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('rent_duration', null, ['class' => 'form-control', 'placeholder' => __('Enter day of month between 1 to 30')])); ?>

                                        </div>
                                        <div class="form-group col-md-6 rent_type yearly d-none">
                                            <?php echo e(Form::label('rent_duration', __('Rent Duration'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('rent_duration', null, ['class' => 'form-control', 'placeholder' => __('Enter month of year between 1 to 12'), 'disabled'])); ?>

                                        </div>
                                        <div class="form-group col-md-2 rent_type custom d-none">
                                            <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::date('start_date', null, ['class' => 'form-control', 'disabled'])); ?>

                                        </div>
                                        <div class="form-group col-md-2 rent_type custom d-none">
                                            <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::date('end_date', null, ['class' => 'form-control', 'disabled'])); ?>

                                        </div>
                                        <div class="form-group col-md-2 rent_type custom d-none">
                                            <?php echo e(Form::label('payment_due_date', __('Payment Due Date'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::date('payment_due_date', null, ['class' => 'form-control', 'disabled'])); ?>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <?php echo e(Form::label('deposit_type', __('Deposit Type'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('deposit_type', $unitTypes, null, ['class' => 'form-control hidesearch', 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <?php echo e(Form::label('deposit_amount', __('Deposit Amount'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('deposit_amount', null, ['class' => 'form-control', 'placeholder' => __('Enter deposit amount'), 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-3">
                                            <?php echo e(Form::label('late_fee_type', __('Late Fee Type'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::select('late_fee_type', $unitTypes, null, ['class' => 'form-control hidesearch', 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-2">
                                            <?php echo e(Form::label('late_fee_amount', __('Late Fee Amount'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('late_fee_amount', null, ['class' => 'form-control', 'placeholder' => __('Enter late fee amount'), 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('incident_receipt_amount', __('Incident Receipt Amount'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::number('incident_receipt_amount', null, ['class' => 'form-control', 'placeholder' => __('Enter incident receipt amount'), 'required' => 'required'])); ?>

                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('notes', __('Notes'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Enter notes')])); ?>

                                        </div>
                                    </div>



                                </div>
                            </div>


                            <div class="col-lg-12 mb-2">
                                <div class="group-button text-end">
                                    <button type="button" class="btn btn-secondary btn-rounded nextButton"
                                        data-next-tab="#profile-2">
                                        <?php echo e(__('Next')); ?>

                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="row">
                                                <?php $__currentLoopData = $amenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-md-6 col-xl-4 mb-4">
                                                        <label
                                                            class="border rounded p-3 d-flex align-items-start gap-3 shadow-sm h-100 cursor-pointer">
                                                            <input type="checkbox" name="amenities[]"
                                                                value="<?php echo e($amenity->id); ?>"
                                                                class="form-check-input mt-1">
                                                            <div>
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <img src="<?php echo e(fetch_file($amenity->image, 'upload/amenity/')); ?>"
                                                                        alt="Amenity Image" class="rounded me-2"
                                                                        width="40" height="40">
                                                                    <strong
                                                                        class="text-dark"><?php echo e(ucfirst($amenity->name)); ?></strong>
                                                                </div>
                                                                <div class="text-muted small">
                                                                    <?php echo e(\Illuminate\Support\Str::limit($amenity->description, 120)); ?>

                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-secondary btn-rounded nextButton"
                                    data-next-tab="#profile-2">
                                    <?php echo e(__('Next')); ?>

                                </button>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile-5" role="tabpanel" aria-labelledby="profile-tab-5">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="row">
                                                <?php $__currentLoopData = $advantages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advantage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-md-6 col-xl-4 mb-4">
                                                        <label
                                                            class="border rounded p-3 d-flex align-items-start gap-3 shadow-sm h-100 cursor-pointer">
                                                            <input type="checkbox" name="advantages[]"
                                                                value="<?php echo e($advantage->id); ?>"
                                                                class="form-check-input mt-1">
                                                            <div>
                                                                <div class="d-flex align-items-center mb-2">

                                                                    <strong
                                                                        class="text-dark"><?php echo e(ucfirst($advantage->name)); ?></strong>
                                                                </div>
                                                                <div class="text-muted small">
                                                                    <?php echo e(\Illuminate\Support\Str::limit($advantage->description, 120)); ?>

                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="row">

                                                <!-- Display in listing checkbox -->
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="display_in_listing" name="display_in_listing"
                                                            value="1">
                                                        <label class="form-check-label" for="display_in_listing">
                                                            <?php echo e(__(' Property will display in listings?')); ?>

                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Rent/Sell radio (hidden by default) -->
                                                <div class="col-md-12 mb-3" id="listing_type_container"
                                                    style="display: none;">
                                                    <label class="form-label d-block"><?php echo e(__('Listing Type')); ?> <span class="text-danger">*</span></label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="listing_type" id="type_rent" value="rent">
                                                        <label class="form-check-label"
                                                            for="type_rent"><?php echo e(__('Rent')); ?></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="listing_type" id="type_sell" value="sell">
                                                        <label class="form-check-label"
                                                            for="type_sell"><?php echo e(__('Sell')); ?></label>
                                                    </div>
                                                </div>

                                                <!-- Hidden input to hold final price -->
                                                <input type="hidden" name="price" id="final_price">

                                                <!-- Rent Price Input -->
                                                <div class="col-md-6 mb-3" id="rent_price_input" style="display: none;">
                                                    <label for="rent_price" class="form-label">Monthly Rent Price <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="rent_price" name="rent_price"
                                                        placeholder="Enter monthly rent price" min="0" step="0.01">
                                                </div>

                                                <!-- Sell Price Input -->
                                                <div class="col-md-6 mb-3" id="sell_price_input" style="display: none;">
                                                    <label for="sell_price" class="form-label">Sell Price <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="sell_price" name="sell_price"
                                                        placeholder="Enter sell price" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="text-end mt-3">
                                <?php echo e(Form::submit(__('Create'), ['class' => 'btn btn-secondary btn-rounded nextButton', 'id' => 'property-submit'])); ?>


                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/property/create.blade.php ENDPATH**/ ?>