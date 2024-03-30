<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class WeatherController extends Controller
{
    public function getHistory(){
        return History::pluck('city')->toArray();
    }
    public function index()
    {
        $cities = $this->getHistory();
        return view('welcome', ['cities' => $cities]);
    }

    public function getWeather(Request $request)
    {
        $apiKey = env('WEATHERBIT_API_KEY');
        $city = $request->input('city');

        $client = new Client();
        $response = $client->get("https://api.weatherbit.io/v2.0/current?key=$apiKey&city=$city");
        $data = json_decode($response->getBody(), true);

        $cities = $this->getHistory();

        return view('welcome', compact('data', 'cities'));
    }

    public function addCity(Request $request){

        $request->validate([
            'city' => 'required|string|max:255',
        ]);

        History::create([
            'city' => $request->input('city'),
        ]);

        return redirect()->back()->with('success', 'City added successfully.');
    }

    public function setRemove(Request $request){

        $action = $request->input('action');
        $citySet = $request->input('citySet');
        $cityRemove = $request->input('cityRemove');

        if ($action === 'Set'){
            History::create([
                'city' => $citySet,
            ]);
            return redirect()->back();
        } elseif ($action === 'Remove'){
            History::where('city', $cityRemove)->delete();
            return redirect()->back();
        }




    }







}
