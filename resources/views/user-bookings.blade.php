<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Your Bookings</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Tailwind CSS styles */
            body {
                font-family: 'Instrument Sans', sans-serif;
                background: linear-gradient(135deg, #e0f2f1 0%, #d1f0ea 100%);
                color: #2e7d32;
            }
            
            .bookings-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
            }
            
            .booking-card {
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 4px 12px rgba(46, 125, 50, 0.1);
                padding: 1.5rem;
                margin-bottom: 1.5rem;
                border: 1px solid #a5d6a7;
            }
            
            .booking-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #c8e6c9;
            }
            
            .flight-details {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .route-info {
                display: flex;
                align-items: center;
                gap: 1rem;
            }
            
            .airport-code {
                font-weight: bold;
                font-size: 1.2rem;
                color: #2e7d32;
            }
            
            .airline-logo {
                width: 40px;
                height: 40px;
                background: linear-gradient(135deg, #81c784 0%, #66bb6a 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 1rem;
                color: white;
                font-weight: bold;
            }
            
            .time-info {
                text-align: center;
                min-width: 120px;
            }
            
            .duration {
                text-align: center;
                color: #66bb6a;
                font-size: 0.9rem;
            }
            
            .price {
                font-size: 1.5rem;
                font-weight: bold;
                color: #2e7d32;
            }
            
            .btn-manage {
                background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%);
                color: white;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 2px 4px rgba(46, 125, 50, 0.2);
            }
            
            .btn-manage:hover {
                background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(46, 125, 50, 0.3);
            }
            
            .booking-status {
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 500;
            }
            
            .status-confirmed {
                background-color: #e8f5e9;
                color: #2e7d32;
            }
            
            .status-pending {
                background-color: #fff8e1;
                color: #f57f17;
            }
            
            .status-cancelled {
                background-color: #ffebee;
                color: #c62828;
            }
            
            .booking-summary {
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 4px 12px rgba(46, 125, 50, 0.1);
                padding: 1.5rem;
                margin: 1rem 0 2rem;
                border-left: 4px solid #66bb6a;
            }
            
            .section-title {
                font-size: 1.5rem;
                font-weight: 600;
                margin: 1.5rem 0 1rem;
                color: #2e7d32;
            }
        </style>
    @endif
</head>
<body>
    <div class="bookings-container">
        <header>
            <h1 class="text-3xl font-bold text-center mb-2">Your Bookings</h1>
            <p class="text-center text-[#706f6c]">Manage your upcoming trips</p>
        </header>

        <main>
            <div class="booking-summary">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold">Active Bookings</h2>
                        <p class="text-[#706f6c]">You have {{ count($bookings) }} active booking{{ count($bookings) != 1 ? 's' : '' }}</p>
                    </div>
                    <div class="text-right">
                        <a href="/" class="text-[#039be5] underline">Book a new flight</a>
                    </div>
                </div>
            </div>

            @if(count($bookings) > 0)
                @foreach($bookings as $booking)
                <div class="booking-card">
                    <div class="booking-header">
                        <div class="airline-info flex items-center">
                            <div class="airline-logo">✈️</div>
                            <div>
                                <h3 class="font-semibold">{{ $booking['airline'] }}</h3>
                                <p class="text-sm text-[#706f6c]">Booking ID: {{ $booking['bookingId'] }}</p>
                            </div>
                        </div>
                        <div>
                            <span class="booking-status status-confirmed">Confirmed</span>
                        </div>
                    </div>
                    
                    <div class="flight-details">
                        <div class="route-info">
                            <div>
                                <div class="airport-code">{{ $booking['departure']['code'] }}</div>
                                <div>{{ $booking['departure']['time'] }}</div>
                                <div class="text-sm text-[#706f6c]">{{ $booking['departure']['city'] }}</div>
                            </div>
                            
                            <div class="airline-logo">→</div>
                            
                            <div>
                                <div class="airport-code">{{ $booking['arrival']['code'] }}</div>
                                <div>{{ $booking['arrival']['time'] }}</div>
                                <div class="text-sm text-[#706f6c]">{{ $booking['arrival']['city'] }}</div>
                            </div>
                        </div>
                        
                        <div class="time-info">
                            <div>{{ $booking['duration'] }}</div>
                            <div class="duration">{{ $booking['stops'] }}</div>
                        </div>
                        
                        <div>
                            <button class="btn-manage" onclick="viewBooking('{{ $booking['bookingId'] }}')">Manage</button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="booking-card text-center py-8">
                    <h3 class="text-xl font-semibold mb-2">No Active Bookings</h3>
                    <p class="text-[#706f6c] mb-4">You don't have any active bookings at the moment</p>
                    <a href="/" class="btn-manage inline-block">Book a Flight Now</a>
                </div>
            @endif
        </main>
    </div>

    <script>
        function viewBooking(bookingId) {
            alert(`Viewing details for booking: ${bookingId}`);
            // In a real application, this would navigate to the booking details page
        }
    </script>
</body>
</html>