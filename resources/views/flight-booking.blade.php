<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Flight Booking</title>

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
            
            .booking-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
            }
            
            .booking-card {
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 4px 12px rgba(0, 102, 204, 0.1);
                padding: 2rem;
                margin: 2rem 0;
                border: 1px solid #e1f5fe;
            }
            
            .form-group {
                margin-bottom: 1.5rem;
            }
            
            label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: 500;
                color: #0d3b66;
            }
            
            .input-group {
                display: flex;
                gap: 1rem;
            }
            
            .input-field {
                flex: 1;
                padding: 0.75rem;
                border: 1px solid #bbdefb;
                border-radius: 0.375rem;
                font-size: 1rem;
                background-color: #f0f9ff;
            }
            
            .input-field:focus {
                outline: none;
                border-color: #29b6f6;
                box-shadow: 0 0 0 3px rgba(41, 182, 246, 0.2);
            }
            
            .date-picker {
                position: relative;
            }
            
            .calendar-icon {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                color: #4fc3f7;
            }
            
            .btn-book {
                background: linear-gradient(135deg, #29b6f6 0%, #039be5 100%);
                color: white;
                border: none;
                padding: 0.75rem 2rem;
                border-radius: 0.375rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 2px 4px rgba(0, 102, 204, 0.2);
            }
            
            .btn-book:hover {
                background: linear-gradient(135deg, #039be5 0%, #0288d1 100%);
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 102, 204, 0.3);
            }
            
            .trip-type {
                display: flex;
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .trip-option {
                padding: 0.5rem 1rem;
                border: 1px solid #bbdefb;
                border-radius: 0.375rem;
                cursor: pointer;
                transition: all 0.2s;
                background-color: #e1f5fe;
            }
            
            .trip-option.active {
                background: linear-gradient(135deg, #29b6f6 0%, #039be5 100%);
                color: white;
                border-color: #039be5;
            }
        </style>
    @endif
</head>
<body>
    <div class="booking-container">
        <header>
            <h1 class="text-3xl font-bold text-center mb-2">Book Your Flight</h1>
            <p class="text-center text-[#706f6c]">Find the best deals on flights worldwide</p>
        </header>

        <main>
            <div class="booking-card">
                <div class="trip-type">
                    <div class="trip-option active" onclick="setTripType('round')">Round Trip</div>
                    <div class="trip-option" onclick="setTripType('one-way')">One Way</div>
                </div>

                <form id="bookingForm" action="/search-flights" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="fromLocation">From</label>
                        <select id="fromLocation" name="from_location" class="input-field">
                            <option value="">Select departure city</option>
                            <option value="NYC">New York (JFK)</option>
                            <option value="LAX">Los Angeles (LAX)</option>
                            <option value="LHR">London (Heathrow)</option>
                            <option value="CDG">Paris (Charles de Gaulle)</option>
                            <option value="DXB">Dubai (Dubai Intl)</option>
                            <option value="HND">Tokyo (Haneda)</option>
                            <option value="SIN">Singapore (Changi)</option>
                            <option value="SYD">Sydney (Kingsford Smith)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="toLocation">To</label>
                        <select id="toLocation" name="to_location" class="input-field">
                            <option value="">Select destination city</option>
                            <option value="NYC">New York (JFK)</option>
                            <option value="LAX">Los Angeles (LAX)</option>
                            <option value="LHR">London (Heathrow)</option>
                            <option value="CDG">Paris (Charles de Gaulle)</option>
                            <option value="DXB">Dubai (Dubai Intl)</option>
                            <option value="HND">Tokyo (Haneda)</option>
                            <option value="SIN">Singapore (Changi)</option>
                            <option value="SYD">Sydney (Kingsford Smith)</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <div class="form-group">
                            <label for="departureDate">Departure</label>
                            <div class="date-picker">
                                <input type="date" id="departureDate" name="departure_date" class="input-field w-full">
                                <span class="calendar-icon">📅</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="returnDate">Return</label>
                            <div class="date-picker">
                                <input type="date" id="returnDate" name="return_date" class="input-field w-full">
                                <span class="calendar-icon">📅</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="passengers">Passengers</label>
                        <select id="passengers" name="passengers" class="input-field">
                            <option value="1">1 Passenger</option>
                            <option value="2">2 Passengers</option>
                            <option value="3">3 Passengers</option>
                            <option value="4">4 Passengers</option>
                            <option value="5">5+ Passengers</option>
                        </select>
                    </div>

                    <div class="text-center mt-6">
                        <button type="submit" class="btn-book">Search Flights</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('departureDate').min = today;
        document.getElementById('returnDate').min = today;

        // Update return date min when departure date changes
        document.getElementById('departureDate').addEventListener('change', function() {
            document.getElementById('returnDate').min = this.value;
        });

        // Handle form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const from = document.getElementById('fromLocation').value;
            const to = document.getElementById('toLocation').value;
            const departure = document.getElementById('departureDate').value;
            const returnDate = document.getElementById('returnDate').value;
            
            if (!from || !to) {
                alert('Please select both departure and destination cities');
                return;
            }
            
            if (!departure) {
                alert('Please select a departure date');
                return;
            }
            
            if (document.querySelector('.trip-option.active').textContent === 'Round Trip' && !returnDate) {
                alert('Please select a return date for round trip');
                return;
            }
            
            // Submit the form
            this.submit();
        });

        // Toggle trip type
        function setTripType(type) {
            document.querySelectorAll('.trip-option').forEach(option => {
                option.classList.remove('active');
            });
            
            if (type === 'round') {
                document.querySelector('.trip-option:nth-child(1)').classList.add('active');
                document.getElementById('returnDate').disabled = false;
                document.querySelector('label[for="returnDate"]').style.opacity = '1';
                document.getElementById('returnDate').style.opacity = '1';
            } else {
                document.querySelector('.trip-option:nth-child(2)').classList.add('active');
                document.getElementById('returnDate').disabled = true;
                document.querySelector('label[for="returnDate"]').style.opacity = '0.5';
                document.getElementById('returnDate').style.opacity = '0.5';
            }
        }
    </script>
</body>
</html>