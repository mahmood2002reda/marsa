@extends('layouts.app')

@section('content')
<script>
   Request permission to show notifications
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
                // Get the FCM token
                messaging.getToken({ vapidKey: 'BChunPYwr0z9lcMR-OGcKkFt7oZxseRmZHSWChciugX-8lZL3Aiwk0ZfNGoGCpz2cPK3t8M4YXrN4EhjzEvVWSg' }).then((currentToken) => {
                    if (currentToken) {
                        console.log('FCM Token:', currentToken);
    
                        // Send the token to the server
                        storeFcmToken(currentToken);
                    } else {
                        console.log('No registration token available. Request permission to generate one.');
                    }
                }).catch((err) => {
                    console.log('An error occurred while retrieving token. ', err);
                });
            } else {
                console.log('Unable to get permission to notify.');
            }
        });
    
        // Function to send the FCM token to your Laravel backend
        function storeFcmToken(token) {
            fetch('/api/store-fcm-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                body: JSON.stringify({ fcm_token: token })
            })
            .then(response => response.json())
            .then(data => console.log('Token stored successfully:', data))
            .catch(error => console.error('Error storing token:', error));
        }
    </script>


@endsection