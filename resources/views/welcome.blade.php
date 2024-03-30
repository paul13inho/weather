<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center">
<div class="max-w-md w-full p-8 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-semibold mb-4 text-center">Weather App</h1>
    <form action="{{ route('weather.get-weather') }}" method="post" class="mb-4">
        @csrf
        <input type="text" name="city" id="city" placeholder="Enter City Name" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:border-blue-500">
        <input type="submit" value="Get Weather" class="w-full mt-2 px-4 py-2 bg-blue-500 text-white rounded-md cursor-pointer hover:bg-blue-600 transition duration-300">
    </form>
    @if(isset($data))
        @if(isset($data['data'][0]))
            <div class="weather-info">
                <form action="/add-city" method="post" class="mb-4 flex items-center">
                    @csrf
                    <h2 class="text-xl font-semibold flex-grow">{{ $data['data'][0]['city_name'] ?? 'Unknown' }}, {{ $data['data'][0]['country_code'] ?? 'Unknown' }}</h2>
                    <input type="hidden" name="city" value="{{ $data['data'][0]['city_name'] ?? 'Unknown' }}">
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md cursor-pointer hover:bg-green-600 transition duration-300"><i class="fa-solid fa-heart-circle-plus"></i></button>
                </form>
                <p>Temperature: {{ $data['data'][0]['temp'] ?? 'Unknown' }}°C</p>
                <p>Weather: {{ $data['data'][0]['weather']['description'] ?? 'Unknown' }}</p>
            </div>
        @else
            <p class="text-red-500">No weather data available for the provided city.</p>
        @endif
    @endif
</div>

{{--FAVORITES--}}
@php
    $cities = $cities ?? "";
@endphp

@if(!is_null($cities) && count($cities) > 0)
    <div class="max-w-md mt-8 bg-white rounded-lg shadow-md p-4">
        <h2 class="text-xl font-semibold mb-2">My Favorites</h2>
        <ul>
            @foreach($cities as $city)
                <li class="capitalize flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="mr-2">{{ $city }}</span>
                    <div class="flex gap-2">
                        <button type="button" onclick="setCity('{{ $city }}')" class="px-3 py-1 bg-blue-500 text-white rounded-md cursor-pointer hover:bg-blue-600 transition duration-300 flex items-center">
                            <i class="fas fa-check mr-1"></i>
                        </button>
                        <form action="{{ route('remove') }}" method="post" class="inline">
                            @csrf
                            <input type="hidden" name="city" value="{{ $city }}">
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md cursor-pointer hover:bg-red-600 transition duration-300 flex items-center">
                                <i class="fas fa-trash-alt mr-1"></i>
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <p class="mt-4 text-gray-600">No cities found.</p>
@endif

<script>
    function setCity(city){
        document.getElementById('city').value = city;
        document.querySelector('form').submit();
    }
</script>
</body>
</html>
