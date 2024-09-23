<!DOCTYPE html>
<html>
<head>
    <title>Available Types</title>
</head>
<body>
    <h1>Available Types</h1>
    <ul>
        @foreach($types as $type)
            <li>
                <a href="{{ route('tours.byType', $type) }}">{{ $type }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
