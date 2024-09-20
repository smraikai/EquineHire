<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&loading=async"
    async defer></script>
<script>
    function initAutocompleteLocation() {
        var locationInput = document.getElementById('location');
        var autocomplete = new google.maps.places.Autocomplete(locationInput);

        // Check if the location input is empty
        if (!locationInput.value.trim()) {
            // Attempt to get cached location
            var cachedLocation = getCachedLocation();
            if (cachedLocation) {
                locationInput.value = cachedLocation;
            } else {
                var apiURL =
                    'https://www.googleapis.com/geolocation/v1/geolocate?key={{ config('services.google.maps_api_key') }}';
                fetch(apiURL, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        var geocoder = new google.maps.Geocoder();
                        var latlng = {
                            lat: data.location.lat,
                            lng: data.location.lng
                        };

                        geocoder.geocode({
                            'location': latlng
                        }, function(results, status) {
                            if (status === 'OK' && results[0]) {
                                var city = '',
                                    state = '';
                                results[0].address_components.forEach(component => {
                                    if (component.types.includes('locality')) {
                                        city = component.long_name;
                                    }
                                    if (component.types.includes('administrative_area_level_1')) {
                                        state = component.short_name;
                                    }
                                });

                                if (city && state) {
                                    var formattedAddress = city + ', ' + state;
                                    locationInput.value = formattedAddress;
                                    cacheLocation(formattedAddress);
                                } else {
                                    locationInput.value = "Location not specific enough";
                                }
                            } else {
                                console.error('Geocoder failed due to: ' + status);
                                locationInput.value = "Geocoder error: " + status;
                            }
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching geolocation:", error);
                        locationInput.value = "Error fetching location";
                    });
            }
        }
    }

    function cacheLocation(location) {
        const locationData = {
            location: location,
            timestamp: new Date().getTime()
        };
        localStorage.setItem('userLocation', JSON.stringify(locationData));
    }

    function getCachedLocation() {
        const locationData = JSON.parse(localStorage.getItem('userLocation'));
        const HOUR = 1000 * 60 * 60;
        if (locationData && (new Date().getTime() - locationData.timestamp < HOUR)) {
            return locationData.location;
        }
        return null;
    }

    window.addEventListener('load', function() {
        if (document.getElementById('location')) {
            initAutocompleteLocation();
        }
    });
</script>
