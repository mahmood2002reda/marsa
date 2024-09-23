@extends('layouts.app')

@section('content')
    <h1>Create a New Tour</h1>

    <!-- Display success or error messages -->
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tours.store') }}" method="POST">
        @csrf
        
        <!-- Common Fields -->
        <div>
            <label for="tour_duration">Tour Duration:</label>
            <input type="text" id="tour_duration" name="tour_duration" required>
        </div>

        <div>
            <label for="images">Images (URL):</label>
            <input type="text" id="images" name="images" required>
        </div>

        <div>
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
        </div>

        <div>
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required>
        </div>

        <div>
            <label for="governorate">Governorate:</label>
            <input type="text" id="governorate" name="governorate" required>
        </div>

        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
        </div>

        <div>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>
        </div>

        <hr>

        <!-- Arabic Translations -->
        <h2>Arabic Translations</h2>
        <div>
            <label for="name_ar">Name (Arabic):</label>
            <input type="text" id="name_ar" name="translations[ar][name]" required>
        </div>

        <div>
            <label for="description_ar">Description (Arabic):</label>
            <textarea id="description_ar" name="translations[ar][description]" required></textarea>
        </div>

        <div>
            <label for="services_ar">Services (Arabic):</label>
            <input type="text" id="services_ar" name="translations[ar][services]" required>
        </div>

        <div>
            <label for="must_know_ar">Must Know (Arabic):</label>
            <input type="text" id="must_know_ar" name="translations[ar][must_know]" required>
        </div>

        <hr>

        <!-- English Translations -->
        <h2>English Translations</h2>
        <div>
            <label for="name_en">Name (English):</label>
            <input type="text" id="name_en" name="translations[en][name]" >
        </div>

        <div>
            <label for="description_en">Description (English):</label>
            <textarea id="description_en" name="translations[en][description]" ></textarea>
        </div>

        <div>
            <label for="services_en">Services (English):</label>
            <input type="text" id="services_en" name="translations[en][services]" >
        </div>

        <div>
            <label for="must_know_en">Must Know (English):</label>
            <input type="text" id="must_know_en" name="translations[en][must_know]" >
        </div>

        <div>
            <button type="submit">Create Tour</button>
        </div>
    </form>

    <a href="{{ route('tours.index') }}">Back to Tours List</a>
@endsection
