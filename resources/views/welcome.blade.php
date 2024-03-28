<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>




<div class="container">
    <h1>Weather App</h1>
    <form action="/weather" method="post">
        @csrf
        <input type="text" name="city" placeholder="Enter City Name">
        <input type="submit" value="Get Weather">
    </form>
    @if(isset($data))
        @if(isset($data['data'][0]))
            <div class="weather-info">
                <h2>{{ $data['data'][0]['city_name'] ?? 'Unknown' }}, {{ $data['data'][0]['country_code'] ?? 'Unknown' }}</h2>
                <p>Temperature: {{ $data['data'][0]['temp'] ?? 'Unknown' }}°C</p>
                <p>Weather: {{ $data['data'][0]['weather']['description'] ?? 'Unknown' }}</p>
            </div>
        @else
            <p>No weather data available for the provided city.</p>
        @endif

    @endif
</div>









</body>
</html>
