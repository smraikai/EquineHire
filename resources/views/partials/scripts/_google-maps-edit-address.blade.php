<script>
    function initAutocompleteAddress() {
        var addressInput = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(addressInput, {
            types: ['geocode'],
            componentRestrictions: {
                country: 'us'
            }
        });

        // Address Validation Reset
        addressInput.addEventListener('input', function() {
            if (addressInput.value.trim() === '') {
                document.getElementById('is_valid_address').value = 'false';
                document.getElementById('address-icon-valid').classList.add('hidden');
                document.getElementById('address-icon-invalid').classList.remove('hidden');
            }
        });
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();

            // Address Validation
            if (!place.geometry || !place.geometry.location) {
                // User entered an invalid address or cleared the field
                addressInput.value = '';
                document.getElementById('addressError').textContent = 'Please enter a valid address.';
                // Set the input field value to false
                document.getElementById('is_valid_address').value = 'false';
                // Hide the icon
                document.getElementById('address-icon').classList.add('hidden');
                return;
            }

            document.getElementById('addressError').textContent = '';

            // Extract city, state, and zip code from the address components
            var city = '';
            var state = '';
            var zipCode = '';
            var latitude = place.geometry.location.lat(); // Capture latitude
            var longitude = place.geometry.location.lng(); // Capture longitude

            for (var i = 0; i < place.address_components.length; i++) {
                var component = place.address_components[i];
                if (component.types.includes('locality')) {
                    city = component.long_name;
                }
                if (component.types.includes('administrative_area_level_1')) {
                    state = component.long_name;
                }
                if (component.types.includes('postal_code')) {
                    zipCode = component.long_name;
                }
            }

            // Set the values of the city, state, and zip code fields
            document.getElementById('city').value = city;
            document.getElementById('state').value = state;
            document.getElementById('zip_code').value = zipCode;
            document.getElementById('latitude').value = latitude; // Set latitude
            document.getElementById('longitude').value = longitude; // Set longitude

            // Check if city has a value before setting is_valid_address to true
            if (city.trim() !== '') {
                document.getElementById('is_valid_address').value = 'true';
                document.getElementById('address-icon-valid').classList.remove('hidden');
                document.getElementById('address-icon-invalid').classList.add('hidden');
            } else {
                document.getElementById('is_valid_address').value = 'false';
                document.getElementById('address-icon-valid').classList.add('hidden');
                document.getElementById('address-icon-invalid').classList.remove('hidden');
            }
        });
    }

    window.addEventListener('load', function() {
        if (document.getElementById('address')) {
            initAutocompleteAddress();
        }
    });
</script>
