<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class FlightController extends Controller
{
    public function index()
    {
        return view('flight-booking');
    }
    
    public function search(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date',
            'passengers' => 'required|integer|min:1|max:10',
        ]);
        
        // Generate mock flight data
        $flights = $this->generateMockFlights(
            $validatedData['from_location'],
            $validatedData['to_location'],
            $validatedData['departure_date']
        );
        
        // Pass the validated data and generated flights to the view
        return view('flight-results', [
            'fromLocation' => $validatedData['from_location'],
            'toLocation' => $validatedData['to_location'],
            'departureDate' => $validatedData['departure_date'],
            'returnDate' => $validatedData['return_date'],
            'passengers' => $validatedData['passengers'],
            'flights' => $flights
        ]);
    }
    
    private function generateMockFlights($from, $to, $date)
    {
        // Define some sample airlines
        $airlines = ['SkyWings', 'AirGlobal', 'CloudJet', 'FlyHigh', 'AeroLine'];
        
        // Define some sample cities and airport codes
        $cities = [
            'NYC' => ['city' => 'New York', 'code' => 'JFK'],
            'LAX' => ['city' => 'Los Angeles', 'code' => 'LAX'],
            'LHR' => ['city' => 'London', 'code' => 'LHR'],
            'CDG' => ['city' => 'Paris', 'code' => 'CDG'],
            'DXB' => ['city' => 'Dubai', 'code' => 'DXB'],
            'HND' => ['city' => 'Tokyo', 'code' => 'HND'],
            'SIN' => ['city' => 'Singapore', 'code' => 'SIN'],
            'SYD' => ['city' => 'Sydney', 'code' => 'SYD'],
        ];
        
        $flights = [];
        
        // Generate 5-8 mock flights
        $numFlights = rand(5, 8);
        
        for ($i = 0; $i < $numFlights; $i++) {
            // Random airline
            $airline = $airlines[array_rand($airlines)];
            
            // Random flight number
            $flightNumber = $airline[0].$airline[1].rand(100, 999);
            
            // Random price between 200 and 1500
            $price = rand(200, 1500);
            
            // Random duration between 2 and 16 hours
            $hours = rand(2, 16);
            $minutes = rand(0, 59);
            $duration = $hours.'h '.$minutes.'m';
            
            // Random stops
            $stopsOptions = ['Nonstop', '1 Stop', '2 Stops'];
            $stops = $stopsOptions[array_rand($stopsOptions)];
            
            // Generate departure and arrival times
            $departureHour = rand(0, 23);
            $departureMinute = rand(0, 59) > 30 ? 0 : 30; // Round to nearest 30 mins
            $departureTime = sprintf('%02d:%02d', $departureHour, $departureMinute);
            
            // Calculate arrival time based on duration
            $depDateTime = Carbon::createFromFormat('H:i', $departureTime);
            $depDateTime->addHours($hours)->addMinutes($minutes);
            $arrivalTime = $depDateTime->format('H:i');
            
            $flights[] = [
                'airline' => $airline,
                'flightNumber' => $flightNumber,
                'price' => $price,
                'duration' => $duration,
                'stops' => $stops,
                'departure' => [
                    'code' => $cities[$from]['code'],
                    'city' => $cities[$from]['city'],
                    'time' => $departureTime
                ],
                'arrival' => [
                    'code' => $cities[$to]['code'],
                    'city' => $cities[$to]['city'],
                    'time' => $arrivalTime
                ]
            ];
        }
        
        return $flights;
    }
}