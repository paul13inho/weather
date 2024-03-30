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
    <form action="{{ route('weather.get-weather') }}" method="post">
        @csrf
        <input type="text" name="city" id="city" placeholder="Enter City Name">
        <input type="submit" value="Get Weather">
    </form>
    @if(isset($data))
        @if(isset($data['data'][0]))
            <div class="weather-info">
                <form action="/add-city" method="post" class="flex space-x-16">
                    @csrf
                    <h2 class="flex justify-center items-center">{{ $data['data'][0]['city_name'] ?? 'Unknown' }}, {{ $data['data'][0]['country_code'] ?? 'Unknown' }}</h2>
                    <input type="hidden" name="city" value="{{ $data['data'][0]['city_name'] ?? 'Unknown' }}">
                    <input type="submit" value="Favorite" class="bg-red-600 text-white py-1 px-8 rounded">
                </form>
                <p>Temperature: {{ $data['data'][0]['temp'] ?? 'Unknown' }}°C</p>
                <p>Weather: {{ $data['data'][0]['weather']['description'] ?? 'Unknown' }}</p>
            </div>
        @else
            <p>No weather data available for the provided city.</p>
        @endif

    @endif
</div>

@php
    $cities = $cities ?? "";
@endphp

@if(!is_null($cities) && count($cities) > 0)
    <h2>City List</h2>
    <ul>
        @foreach($cities as $city)
            <form action="{{route('set.remove')}}" method="post" class="flex justify-between my-1">
                @csrf
                <li class="capitalize">{{ $city }}</li>
                <input type="hidden" name="citySet" value="{{$city}}">
                <input type="hidden" name="cityRemove" value="{{$city}}">
                <div>
                    <input type="submit" name="action" value="Set" onclick="setCity('{{$city}}')" class="bg-green-600 text-white py-1 px-8 rounded">
                    <input type="submit" name="action" value="Remove" class="bg-red-600 text-white py-1 px-8 rounded">
                </div>
            </form>
        @endforeach
    </ul>
@else
    <p>No cities found.</p>
@endif


<script>
    function setCity(city){
        document.getElementById('city').value = city;
    }
</script>

</body>
</html>
