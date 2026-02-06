<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Flight Search Results</title>

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
                background: linear-gradient(135deg, #e0f7fa 0%, #f5fcff 100%);
                color: #0d3b66;
            }
            
            .results-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
            }
            
            .search-summary {
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 4px 12px rgba(0, 102, 204, 0.1);
                padding: 1.5rem;
                margin: 1rem 0 2rem;
                border-left: 4px solid #4fc3f7;
            }
            
            .flight-card {
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 4px 12px rgba(0, 102, 204, 0.1);
                padding: 1.5rem;
                margin-bottom: 1rem;
                transition: transform 0.2s, box-shadow 0.2s;
                border: 1px solid #bbdefb;
            }
            
            .flight-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 16px rgba(0, 102, 204, 0.15);
                border-color: #81d4fa;
            }
            
            .flight-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #e1f5fe;
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
                color: #0288d1;
            }
            
            .airline-logo {
                width: 40px;
                height: 40px;
                background: linear-gradient(135deg, #81d4fa 0%, #4fc3f7 100%);
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
                color: #4fc3f7;
                font-size: 0.9rem;
            }
            
            .price {
                font-size: 1.5rem;
                font-weight: bold;
                color: #0288d1;
            }
            
            .btn-select {
                background: linear-gradient(135deg, #29b6f6 0%, #039be5 100%);
                color: white;
                border: none;
                padding: 0.5rem 1.5rem;
                border-radius: 0.375rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 2px 4px rgba(0, 102, 204, 0.2);
            }
            
            .btn-select:hover {
                background: linear-gradient(135deg, #039be5 0%, #0288d1 100%);
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 102, 204, 0.3);
            }
            
            .filters {
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 4px 12px rgba(0, 102, 204, 0.1);
                padding: 1.5rem;
                margin-bottom: 2rem;
                border: 1px solid #e1f5fe;
            }
            
            .filter-group {
                display: flex;
                gap: 1rem;
                margin-bottom: 1rem;
                flex-wrap: wrap;
            }
            
            .filter-option {
                padding: 0.5rem 1rem;
                border: 1px solid #bbdefb;
                border-radius: 0.375rem;
                cursor: pointer;
                transition: all 0.2s;
                background-color: #e1f5fe;
            }
            
            .filter-option.active {
                background: linear-gradient(135deg, #29b6f6 0%, #039be5 100%);
                color: white;
                border-color: #039be5;
            }
            
            .sort-options {
                display: flex;
                gap: 1rem;
                margin-top: 1rem;
            }
            
            .sort-option {
                padding: 0.5rem 1rem;
                border: 1px solid #bbdefb;
                border-radius: 0.375rem;
                cursor: pointer;
                transition: all 0.2s;
                background-color: #e1f5fe;
            }
            
            .sort-option.active {
                background: linear-gradient(135deg, #29b6f6 0%, #039be5 100%);
                color: white;
                border-color: #039be5;
            }
        </style>
    @endif
</head>
<body>
    <div class="results-container">
        <header>
            <h1 class="text-3xl font-bold text-center mb-2">Available Flights</h1>
            <p class="text-center text-[#706f6c]">Based on your search criteria</p>
        </header>

        <main>
            <div class="search-summary">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold">{{ $fromLocation }} to {{ $toLocation }}</h2>
                        <p class="text-[#706f6c]">
                            Departure: {{ \Carbon\Carbon::parse($departureDate)->format('M d, Y') }}
                            @if($returnDate)
                            | Return: {{ \Carbon\Carbon::parse($returnDate)->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-[#706f6c]">{{ $passengers }} passenger{{ $passengers > 1 ? 's' : '' }}</p>
                        <a href="/" class="text-[#f53003] underline">Modify search</a>
                    </div>
                </div>
            </div>

            <div class="filters">
                <h3 class="text-lg font-semibold mb-3">Filters</h3>
                
                <div class="filter-group">
                    <div class="filter-option active">All Airlines</div>
                    <div class="filter-option">Direct Flights</div>
                    <div class="filter-option">Morning Flights</div>
                    <div class="filter-option">Afternoon Flights</div>
                    <div class="filter-option">Evening Flights</div>
                </div>
                
                <div class="sort-options">
                    <span class="text-[#706f6c] mr-2">Sort by:</span>
                    <div class="sort-option active">Price (Low to High)</div>
                    <div class="sort-option">Duration</div>
                    <div class="sort-option">Departure Time</div>
                    <div class="sort-option">Arrival Time</div>
                </div>
            </div>

            <div class="flight-results">
                @foreach($flights as $flight)
                <div class="flight-card">
                    <div class="flight-header">
                        <div class="airline-info flex items-center">
                            <div class="airline-logo">✈️</div>
                            <div>
                                <h3 class="font-semibold">{{ $flight['airline'] }}</h3>
                                <p class="text-sm text-[#706f6c]">Flight {{ $flight['flightNumber'] }}</p>
                            </div>
                        </div>
                        <div class="price">${{ $flight['price'] }}</div>
                    </div>
                    
                    <div class="flight-details">
                        <div class="route-info">
                            <div>
                                <div class="airport-code">{{ $flight['departure']['code'] }}</div>
                                <div>{{ $flight['departure']['time'] }}</div>
                                <div class="text-sm text-[#706f6c]">{{ $flight['departure']['city'] }}</div>
                            </div>
                            
                            <div class="airline-logo">→</div>
                            
                            <div>
                                <div class="airport-code">{{ $flight['arrival']['code'] }}</div>
                                <div>{{ $flight['arrival']['time'] }}</div>
                                <div class="text-sm text-[#706f6c]">{{ $flight['arrival']['city'] }}</div>
                            </div>
                        </div>
                        
                        <div class="time-info">
                            <div>{{ $flight['duration'] }}</div>
                            <div class="duration">{{ $flight['stops'] }}</div>
                        </div>
                        
                        <div>
                            <button class="btn-select">Select</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>

    <script>
        // Add interactivity to filter and sort options
        document.querySelectorAll('.filter-option, .sort-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from siblings
                this.parentElement.querySelectorAll('.active').forEach(active => {
                    active.classList.remove('active');
                });
                
                // Add active class to clicked element
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>