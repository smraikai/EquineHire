<script>
    function submitForm() {
        var form = document.getElementById('listing_form');

        // Check for active uploads
        if (parseInt(form.dataset.activeUploads) > 0) {
            alert('Please wait for all uploads to complete before submitting.');
            return;
        }

        // HTML5 Error Validation checks
        if (form.checkValidity() === false) {
            form.reportValidity();
            return; // Prevent submission if the form is invalid
        }

        // Validate categories
        if (!validateCategories()) {
            return; // Prevent form submission
        }

        // Retrieve Quill editor content and check for validity
        var quillContent = quill.root.innerHTML.trim();
        var descriptionError = document.getElementById('descriptionError'); // Reference to the error display element

        // Reset previous Quill errors
        descriptionError.textContent = '';

        if (quillContent === '<p><br></p>' || quillContent === '') {
            descriptionError.textContent = 'Please fill out this field.';
            scrollToError(descriptionError); // Scroll to the error message
            return; // Prevent form submission
        }

        // Check if the address is valid
        var isValidAddress = document.getElementById('is_valid_address').value === 'true';
        if (!isValidAddress) {
            var addressError = document.getElementById('addressError');
            addressError.textContent = 'Please enter a valid address.';
            scrollToError(addressError);
            return; // Prevent form submission
        }

        // Phone number validation
        var phoneInput = document.getElementById('phone');
        var phoneError = document.getElementById('phoneError');
        var regex = /^\(\d{3}\) \d{3}-\d{4}$/;

        // Clear any previous errors if all checks are passed
        phoneError.textContent = '';
        phoneError.style.display = 'none';

        setTimeout(() => {
            document.getElementById('loading-overlay').classList.remove('hidden');
            document.body.classList.add('no-scroll');
        }, 1000);

        // Remove all file inputs from the DOM
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.remove(); // Remove all file inputs from the DOM
        });

        form.submit(); // Submit the form only if it is valid
    }

    document.addEventListener('DOMContentLoaded', function() {

        var phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function(e) {
            var rawNumbers = e.target.value.replace(/\D/g, ''); // Remove non-digits
            if (rawNumbers.length > 10) {
                rawNumbers = rawNumbers.substring(0, 10); // Limit to 10 digits
            }
            var formattedNumber = formatPhoneNumber(rawNumbers);
            e.target.value = formattedNumber; // Set formatted value

            // Display error message if not exactly 10 digits
            updatePhoneNumberError(rawNumbers.length);
        });
    });


    document.addEventListener('DOMContentLoaded', function() {

    });

    function formatPhoneNumber(numbers) {
        var formattedNumber = '';

        // Apply formatting as user types
        if (numbers.length > 0) {
            formattedNumber += '(' + numbers.substring(0, 3);
        }
        if (numbers.length >= 4) {
            formattedNumber += ') ' + numbers.substring(3, 6);
        }
        if (numbers.length >= 7) {
            formattedNumber += '-' + numbers.substring(6, 10);
        }

        return formattedNumber;
    }

    function validateCategories() {
        const selectedCategories = document.getElementById('selected-categories').value.split(',').filter(id => id
            .trim() !== '');
        const categoryError = document.getElementById('categoryError');

        if (selectedCategories.length === 0) {
            categoryError.textContent = 'Please select at least one category.';
            scrollToError(categoryError);
            return false;
        }

        categoryError.textContent = '';
        return true;
    }

    // Function to scroll to the error message
    function scrollToError(element) {
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            }); // Smooth scroll to the element
            element.focus(); // Optionally set focus if the element can accept focus
        }
    }
</script>
