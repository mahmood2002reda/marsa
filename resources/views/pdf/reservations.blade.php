<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Your Reservations</h1>
    <table>
        <thead>
            <tr>
                <th>Reservation Number</th>
                <th>User Name</th>
                <th>Tour Name</th>
                <th>Number of People</th>
                <th>Number of Children</th>
                <th>Reservation Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation['reservation_number'] }}</td>
                    <td>{{ $reservation['user']['name'] }}</td>
                    <td>{{ $reservation['tour']['name'] }}</td>
                    <td>{{ $reservation['number_of_people'] }}</td>
                    <td>{{ $reservation['number_of_children'] }}</td>
                    <td>{{ $reservation['reservation_date'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
