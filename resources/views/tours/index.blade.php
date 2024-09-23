<!-- resources/views/tours/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Tours List ({{ $locale }})</h1>

    <ul>
        @foreach($tours as $tour)
            <li>
                <a href="{{ route('tours.show', $tour->id) }}">
                    <!-- Check if translation exists for the selected locale, fallback to English ('en') -->
                    @if(dd($tour->translate($locale)))
                        {{ $tour->translate($locale)->name }}
                    @else
                        {{ $tour->translate('en')->name }}
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
@endsection
