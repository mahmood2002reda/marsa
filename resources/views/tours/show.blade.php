@extends('layouts.app')

@section('content')
    <tour-details :tour="{{ $tour }}" locale="{{ $locale }}"></tour-details>
@endsection
