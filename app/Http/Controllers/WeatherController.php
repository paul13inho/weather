<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class WeatherController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function getWeather(Request $request)
    {
        $apiKey = env('WEATHERBIT_API_KEY');
        $city = $request->input('city');

        $client = new Client();
        $response = $client->get("https://api.weatherbit.io/v2.0/current?key=$apiKey&city=$city");
        $data = json_decode($response->getBody(), true);

        return view('welcome', compact('data'));
    }
}
