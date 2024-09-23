<!DOCTYPE html>
<html>
<head>
    <title>Tours in {{ $governorate }} for Type: {{ $type }}</title>
</head>
<body>
    <h1>Tours in {{ $governorate }} for Type: {{ $type }}</h1>

    <!-- عرض نفس المناطق لتصفية حسب المنطقة -->
    <h2>Filter by Governorate</h2>
    <ul>
        @foreach($governorates as $gov)
            <li>
                <a href="{{ route('tours.byTypeAndGovernorate', ['type' => $type, 'governorate' => $gov]) }}">
                    {{ $gov }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- عرض الرحلات المرتبطة بالنوع والمنطقة -->
    <h3>Tours:</h3>
    <ul>
        @foreach($tours as $tour)
            <li>
                <strong>{{ $tour->name }}</strong><br>
                Description: {{ $tour->description }}<br>
                Duration: {{ $tour->tour_duration }} days<br>
                Price: ${{ $tour->price }}
            </li>
        @endforeach
    </ul>

    <a href="{{ route('tours.byType', $type) }}">Back to all tours for {{ $type }}</a>
</body>
</html>
