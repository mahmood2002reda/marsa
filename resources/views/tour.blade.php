<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tour->name }}</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>
    <style>
        .tour-details {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        .tour-images img {
            max-width: 100%;
            height: auto;
        }
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
    <script>
        let map;

        function initMap() {
            // Get latitude and longitude from the Blade template
            const latitude = @json($tour->latitude);
            const longitude = @json($tour->longitude);

            // Initialize the map centered at the tour's location
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: latitude, lng: longitude },
                zoom: 12
            });

            // Add a marker at the tour's location
            new google.maps.Marker({
                position: { lat: latitude, lng: longitude },
                map: map,
                title: "{{ $tour->name }}"
            });
        }
    </script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
    https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "{{ env('ONESIGNAL_APP_ID') }}",
            });
        });
    </script>

</head>
<body>
    <div class="tour-details">
        <h1>{{ $tour->name }}</h1>
        <p><strong>Description:</strong> {{ $tour->description }}</p>
        <p><strong>Duration:</strong> {{ $tour->tour_duration }} days</p>

        <!-- Display single image -->
        @if($tour->images)
            <div class="tour-images">
                <img src="{{ asset('images/tour/' . $tour->images) }}" alt="Tour Image">
            </div>
        @endif

        <p><strong>Services:</strong> {{ $tour->services }}</p>
        <p><strong>Must Know:</strong> {{ $tour->must_know }}</p>
        <p><strong>Location:</strong> {{ $tour->location }}</p>
        <p><strong>Type:</strong> {{ $tour->type }}</p>
        <p><strong>Governorate:</strong> {{ $tour->governorate }}</p>
        <p><strong>Price:</strong> ${{ $tour->price }}</p>
        <p><strong>Latitude:</strong> {{ $tour->latitude }}</p>
        <p><strong>Longitude:</strong> {{ $tour->longitude }}</p>

        <!-- Map container -->
        <div id="map"></div>
    </div>
</body>


</html>
