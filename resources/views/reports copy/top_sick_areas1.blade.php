<!DOCTYPE html>
<html>
<head>
    <title>Top 10 Highest Morbidity Areas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Adjusted for correct spacing */
            border-bottom: 2px solid #000;
            padding: 10px 20px;
        }
        .header .icon {
            width: 80px;
            margin-right: 20px;
        }
        .header .title {
            text-align: center;
            flex: 1;
        }
        .header .title h1 {
            font-size: 18px;
            margin: 0;
            text-transform: uppercase;
        }
        .header .title h2 {
            font-size: 14px;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <!-- Icon on the left -->
        <img src="{{ public_path('img/logo2.png') }}" alt="Health Icon" class="icon">
        <!-- Centered Title -->
        <div class="title">
            <h1>Provincial Health Office of Leyte</h1>
            <h2>Top 10 Highest Mortality Municipalities</h2>
            <h2>{{ $rhuName}}</h2>
            <h2>{{ $currentMonth2 }} {{ $currentYear }}</h2>
        </div>
    </div>

    <!-- Table Content -->
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Municipality Name</th>
                <th>Number of Cases</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topSickAreas as $index => $area)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $area['facility_name'] }}</td>
                    <td>{{ $area['death_count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Generated on {{ now()->format('F d, Y') }}
    </div>
</body>
</html>
