<!DOCTYPE html>
<html>
<head>
    <title>Create Tour</title>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
    <script>
        let map;
        let marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 30.0444, lng: 31.2357 }, // Default center (Cairo, Egypt)
                zoom: 8
            });

            const input = document.getElementById('location');
            const searchBox = new google.maps.places.SearchBox(input);

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            searchBox.addListener('places_changed', function() {
                const places = searchBox.getPlaces();

                if (places.length === 0) {
                    return;
                }

                if (marker) {
                    marker.setMap(null);
                }

                const bounds = new google.maps.LatLngBounds();

                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    marker = new google.maps.Marker({
                        map: map,
                        title: place.name,
                        position: place.geometry.location,
                        draggable: true
                    });

                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();

                    google.maps.event.addListener(marker, 'dragend', function() {
                        document.getElementById('latitude').value = marker.getPosition().lat();
                        document.getElementById('longitude').value = marker.getPosition().lng();
                    });

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });

                map.fitBounds(bounds);
            });

            map.addListener('click', function(event) {
                if (marker) {
                    marker.setMap(null);
                }

                marker = new google.maps.Marker({
                    position: event.latLng,
                    map: map,
                    draggable: true
                });

                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();

                google.maps.event.addListener(marker, 'dragend', function() {
                    document.getElementById('latitude').value = marker.getPosition().lat();
                    document.getElementById('longitude').value = marker.getPosition().lng();
                });
            });
        }
    </script>
</head>
<body>
    <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Arabic Translations -->
        <h2>Arabic Translation</h2>
        <div>
            <label for="name_ar">Tour Name (AR):</label>
            <input type="text" id="name_ar" name="translations[ar][name]" required>
        </div>

        <div>
            <label for="description_ar">Description (AR):</label>
            <textarea id="description_ar" name="translations[ar][description]" required></textarea>
        </div>

        <div>
            <label for="tour_duration_ar">Tour Duration (days) (AR):</label>
            <input type="number" id="tour_duration_ar" name="translations[ar][tour_duration]" required>
        </div>

        <div>
            <label for="services_ar">Services (AR):</label>
            <textarea id="services_ar" name="translations[ar][services]"></textarea>
        </div>

        <div>
            <label for="must_know_ar">Must Know (AR):</label>
            <textarea id="must_know_ar" name="translations[ar][must_know]"></textarea>
        </div>

        <div>
            <label for="location_ar">Location (AR):</label>
            <input type="text" id="location_ar" name="translations[ar][location]" required>
        </div>

        <div>
            <label for="type_ar">Tour Type (AR):</label>
            <input type="text" id="type_ar" name="translations[ar][type]" required>
        </div>

        <div>
            <label for="governorate_ar">Governorate (AR):</label>
            <input type="text" id="governorate_ar" name="translations[ar][governorate]" required>
        </div>

        <!-- English Translations -->
        <h2>English Translation (Optional)</h2>
        <div>
            <label for="name_en">Tour Name (EN):</label>
            <input type="text" id="name_en" name="translations[en][name]">
        </div>

        <div>
            <label for="description_en">Description (EN):</label>
            <textarea id="description_en" name="translations[en][description]"></textarea>
        </div>

        <div>
            <label for="tour_duration_en">Tour Duration (days) (EN):</label>
            <input type="number" id="tour_duration_en" name="translations[en][tour_duration]">
        </div>

        <div>
            <label for="services_en">Services (EN):</label>
            <textarea id="services_en" name="translations[en][services]"></textarea>
        </div>

        <div>
            <label for="must_know_en">Must Know (EN):</label>
            <textarea id="must_know_en" name="translations[en][must_know]"></textarea>
        </div>

        <div>
            <label for="location_en">Location (EN):</label>
            <input type="text" id="location_en" name="translations[en][location]">
        </div>

        <div>
            <label for="type_en">Tour Type (EN):</label>
            <input type="text" id="type_en" name="translations[en][type]">
        </div>

        <div>
            <label for="governorate_en">Governorate (EN):</label>
            <input type="text" id="governorate_en" name="translations[en][governorate]">
        </div>

        <!-- Common Fields -->
        <h2>Common Fields</h2>
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
        </div>

        <div>
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required>
        </div>

        <div>
            <label for="images">Images:</label>
            <input type="file" id="images" name="TourImages[]" multiple required>
        </div>

        <div>
            <label for="longitude">Longitude:</label>
            <input type="text" id="longitude" name="longitude" required readonly>
        </div>

        <div>
            <label for="latitude">Latitude:</label>
            <input type="text" id="latitude" name="latitude" required readonly>
        </div>

        <div id="map"></div>

        <button type="submit">Create Tour</button>
    </form>
</body>
</html>
