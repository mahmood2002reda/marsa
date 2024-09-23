<!DOCTYPE html>
<html>
<head>
    <title>Tours for Type: {{ $type }}</title>
</head>
<body>
    <h1>Tours for Type: {{ $type }}</h1>

    <!-- عرض المناطق لتصفية الرحلات حسب المنطقة -->
    <h2>Filter by Governorate</h2>
    <ul>
        @foreach($governorates as $governorate)
            <li>
                <a href="{{ route('tours.byTypeAndGovernorate', ['type' => $type, 'governorate' => $governorate]) }}">
                    {{ $governorate }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- عرض الرحلات المرتبطة بالنوع -->
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
</body>
</html>
