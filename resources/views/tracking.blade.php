<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Train - Bangladesh Railway</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(180deg, #f1f5f9 0%, #ffffff 100%);
            min-height: 100vh;
            padding-bottom: 120px;
        }
        .hero-section {
            background: linear-gradient(135deg, #6b21a8 0%, #14b8a6 100%);
            color: white;
            padding: 5rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113.64,28.37,1200,56.86V0H0Z" fill="white"/></svg>');
            background-size: cover;
        }
        .filter-bar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 2.5rem;
        }
        .map-card {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            height: 1000px;
            opacity: 0;
            animation: fadeIn 0.6s ease forwards;
        }
        #railway-map {
            width: 100%;
            height: 100%;
            background: #f8fafc;
        }
        .train-icon {
            position: absolute;
            font-size: 3rem;
            color: #f43f5e;
            transition: transform 0.5s ease;
        }
        .station-dot {
            fill: #6b21a8;
            cursor: pointer;
            transition: fill 0.3s ease, transform 0.3s ease;
        }
        .station-dot:hover, .station-dot.active {
            fill: #14b8a6;
            transform: scale(1.5);
        }
        .station-label {
            font-size: 14px;
            fill: #1e293b;
            font-weight: 500;
            pointer-events: none;
        }
        .route-path {
            stroke-width: 5;
            stroke-dasharray: 12, 6;
            transition: stroke 0.3s ease;
        }
        .train-indicator {
            position: absolute;
            background: #ffffff;
            border: 2px solid #f43f5e;
            border-radius: 10px;
            padding: 0.75rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            pointer-events: none;
            transform: translate(-50%, -120%);
        }
        .btn-track {
            background: linear-gradient(90deg, #f43f5e, #e11d48);
            border: none;
            transition: transform 0.3s ease;
        }
        .btn-track:hover {
            background: linear-gradient(90deg, #e11d48, #be123c);
            transform: scale(1.05);
        }
        .progress {
            height: 12px;
            border-radius: 12px;
            background-color: #e2e8f0;
        }
        .progress-bar {
            background: linear-gradient(90deg, #6b21a8, #14b8a6);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .summary-card {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease forwards;
            max-width: 600px;
            margin: 2rem auto;
        }
        .loading_spinner {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .back-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #f43f5e, #e11d48);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        .back-btn:hover {
            background: linear-gradient(135deg, #e11d48, #be123c);
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }
        .icon-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Track Your Train</h1>
            <p class="lead mb-4">Explore Bangladesh’s railway network and track your train in real-time.</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="container my-5">
        <div class="filter-bar">
            <form id="trackTrainForm">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label for="train_schedule_id" class="form-label fw-medium">Select Train</label>
                        <select name="train_schedule_id" id="train_schedule_id" class="form-select" aria-label="Select Train">
                            <option value="">Select Train</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="date" class="form-label fw-medium">Travel Date</label>
                        <input type="date" name="date" id="date" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="trackTrain" class="btn btn-track text-white fw-semibold px-4 py-2 w-100">
                            <i class="bi bi-train-front-fill me-2"></i>Track Now
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="loading_spinner" style="display: none;">
            <i class="bi bi-arrow-repeat fa-spin fa-2x text-primary"></i>
            <p class="mt-2 text-gray-600 font-medium">Fetching train location...</p>
        </div>

        <!-- Map Card -->
        <div id="mapSection" class="map-card" style="display: none;">
            <svg id="railway-map" viewBox="0 0 1400 1200" preserveAspectRatio="xMidYMid meet">
                <!-- Bangladesh Outline (Simplified) -->
                <path d="M300,100 C200,150,150,300,150,450 C150,600,200,750,300,900 C400,1050,500,1100,600,1100 C700,1100,800,1050,900,900 C1000,750,1050,600,1050,450 C1050,300,1000,150,900,100 Z" fill="#e2e8f0" stroke="#94a3b8" stroke-width="2"/>

                <!-- Railway Routes -->
                <!-- Dhaka-Chittagong (Teal) -->
                <path class="route-path" d="M600,400 L600,500 L650,600 L700,700 L750,800" stroke="#14b8a6" fill="none"/>
                <!-- Dhaka-Sylhet (Purple) -->
                <path class="route-path" d="M600,400 L550,450 L500,550 L450,650 L400,750" stroke="#6b21a8" fill="none"/>
                <!-- Dhaka-Khulna (Orange) -->
                <path class="route-path" d="M600,400 L550,500 L500,600 L450,700" stroke="#f97316" fill="none"/>
                <!-- Dhaka-Rajshahi (Blue) -->
                <path class="route-path" d="M600,400 L550,450 L500,500 L450,550" stroke="#3b82f6" fill="none"/>
                <!-- Dhaka-Rangpur (Green) -->
                <path class="route-path" d="M600,400 L600,300 L600,200 L600,100" stroke="#22c55e" fill="none"/>
                <!-- Dhaka-Mymensingh (Red) -->
                <path class="route-path" d="M600,400 L600,300 L650,200" stroke="#ef4444" fill="none"/>
                <!-- Chittagong-Cox’s Bazar (Teal) -->
                <path class="route-path" d="M750,800 L800,900" stroke="#14b8a6" fill="none"/>
                <!-- Khulna-Barisal (Orange) -->
                <path class="route-path" d="M450,700 L400,800" stroke="#f97316" fill="none"/>
                <!-- Dhaka-Narayanganj (Purple) -->
                <path class="route-path" d="M600,400 L650,450" stroke="#6b21a8" fill="none"/>
                <!-- Dhaka-Tongi (Blue) -->
                <path class="route-path" d="M600,400 L600,300" stroke="#3b82f6" fill="none"/>
                <!-- Dhaka-Ishwardi (Green) -->
                <path class="route-path" d="M600,400 L550,450" stroke="#22c55e" fill="none"/>
                <!-- Chittagong-Feni (Red) -->
                <path class="route-path" d="M750,800 L700,700" stroke="#ef4444" fill="none"/>

                <!-- Stations -->
                <circle class="station-dot" cx="600" cy="400" r="10" data-station="Dhaka Junction"/>
                <text class="station-label" x="620" y="390">Dhaka J.</text>
                <circle class="station-dot" cx="600" cy="500" r="10" data-station="Brahmanbaria"/>
                <text class="station-label" x="620" y="490">Brahmanbaria</text>
                <circle class="station-dot" cx="650" cy="600" r="10" data-station="Comilla"/>
                <text class="station-label" x="670" y="590">Comilla</text>
                <circle class="station-dot" cx="700" cy="700" r="10" data-station="Feni"/>
                <text class="station-label" x="720" y="690">Feni</text>
                <circle class="station-dot" cx="750" cy="800" r="10" data-station="Chittagong Central"/>
                <text class="station-label" x="770" y="790">Chittagong C.</text>
                <circle class="station-dot" cx="800" cy="900" r="10" data-station="Cox’s Bazar"/>
                <text class="station-label" x="820" y="890">Cox’s Bazar</text>
                <circle class="station-dot" cx="550" cy="450" r="10" data-station="Bhairab Bazar"/>
                <text class="station-label" x="530" y="440">Bhairab B.</text>
                <circle class="station-dot" cx="500" cy="550" r="10" data-station="Srimangal"/>
                <text class="station-label" x="480" y="540">Srimangal</text>
                <circle class="station-dot" cx="450" cy="650" r="10" data-station="Maulvibazar"/>
                <text class="station-label" x="430" y="640">Maulvibazar</text>
                <circle class="station-dot" cx="400" cy="750" r="10" data-station="Sylhet"/>
                <text class="station-label" x="380" y="740">Sylhet</text>
                <circle class="station-dot" cx="550" cy="500" r="10" data-station="Faridpur"/>
                <text class="station-label" x="530" y="490">Faridpur</text>
                <circle class="station-dot" cx="500" cy="600" r="10" data-station="Jessore"/>
                <text class="station-label" x="480" y="590">Jessore</text>
                <circle class="station-dot" cx="450" cy="700" r="10" data-station="Khulna"/>
                <text class="station-label" x="430" y="690">Khulna</text>
                <circle class="station-dot" cx="400" cy="800" r="10" data-station="Barisal"/>
                <text class="station-label" x="380" y="790">Barisal</text>
                <circle class="station-dot" cx="550" cy="450" r="10" data-station="Ishwardi"/>
                <text class="station-label" x="530" y="440">Ishwardi</text>
                <circle class="station-dot" cx="500" cy="500" r="10" data-station="Natore"/>
                <text class="station-label" x="480" y="490">Natore</text>
                <circle class="station-dot" cx="450" cy="550" r="10" data-station="Rajshahi"/>
                <text class="station-label" x="430" y="540">Rajshahi</text>
                <circle class="station-dot" cx="600" cy="300" r="10" data-station="Parbatipur"/>
                <text class="station-label" x="620" y="290">Parbatipur</text>
                <circle class="station-dot" cx="600" cy="200" r="10" data-station="Rangpur"/>
                <text class="station-label" x="620" y="190">Rangpur</text>
                <circle class="station-dot" cx="600" cy="100" r="10" data-station="Dinajpur"/>
                <text class="station-label" x="620" y="90">Dinajpur</text>
                <circle class="station-dot" cx="600" cy="300" r="10" data-station="Tongi"/>
                <text class="station-label" x="620" y="290">Tongi</text>
                <circle class="station-dot" cx="650" cy="200" r="10" data-station="Mymensingh"/>
                <text class="station-label" x="670" y="190">Mymensingh</text>
                <circle class="station-dot" cx="650" cy="300" r="10" data-station="Gaffargaon"/>
                <text class="station-label" x="670" y="290">Gaffargaon</text>
                <circle class="station-dot" cx="650" cy="450" r="10" data-station="Narayanganj"/>
                <text class="station-label" x="670" y="440">Narayanganj</text>

                <!-- Train Icon -->
                <foreignObject id="train-icon" x="0" y="0" width="40" height="40">
                    <i class="bi bi-train-front-fill train-icon"></i>
                </foreignObject>

                <!-- Train Indicator -->
                <foreignObject id="train-indicator" x="0" y="0" width="200" height="60">
                    <div class="train-indicator">
                        <span id="indicator-text"></span>
                    </div>
                </foreignObject>
            </svg>
        </div>

        <!-- Summary Section -->
        <div id="summary" class="summary-card card mt-4" style="display: none;">
            <div class="card-body">
                <h5 class="card-title fw-bold">Train Status</h5>
                <p class="icon-text">
                    <i class="bi bi-train-front-fill"></i>
                    Train: <span id="trainName"></span>
                </p>
                <p class="icon-text">
                    <i class="bi bi-geo-alt-fill"></i>
                    Route: <span id="trainRoute"></span>
                </p>
                <p class="icon-text">
                    <i class="bi bi-pin-map-fill"></i>
                    Current Station: <span id="currentStation"></span>
                </p>
                <p class="icon-text">
                    <i class="bi bi-clock-fill"></i>
                    Status: <span id="trainStatus"></span>
                </p>
                <p class="icon-text">
                    <i class="bi bi-arrow-clockwise"></i>
                    Last Updated: <span id="lastUpdated"></span>
                </p>
                <div class="mt-3">
                    <small class="text-muted">Journey Progress</small>
                    <div class="progress mt-1">
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="noStatus" class="text-center text-muted mt-4 fs-5" style="display: none;">
            <i class="bi bi-info-circle me-2"></i>No tracking information available
        </div>
    </div>

    <!-- Back Button -->
    <button class="back-btn" onclick="window.location.href='{{ route('dashboard') }}'">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            // Station coordinates and route-specific progress
            const stations = {
                'Dhaka Junction': { x: 600, y: 400, routes: { 'Chittagong Central': 0, 'Sylhet': 0, 'Khulna': 0, 'Rajshahi': 0, 'Dinajpur': 0, 'Mymensingh': 0, 'Cox’s Bazar': 0, 'Barisal': 0, 'Rangpur': 0, 'Narayanganj': 0, 'Tongi': 0, 'Ishwardi': 0, 'Feni': 0 } },
                'Brahmanbaria': { x: 600, y: 500, routes: { 'Chittagong Central': 25 } },
                'Comilla': { x: 650, y: 600, routes: { 'Chittagong Central': 50 } },
                'Feni': { x: 700, y: 700, routes: { 'Chittagong Central': 75 } },
                'Chittagong Central': { x: 750, y: 800, routes: { 'Chittagong Central': 100, 'Cox’s Bazar': 0 } },
                'Cox’s Bazar': { x: 800, y: 900, routes: { 'Cox’s Bazar': 100 } },
                'Bhairab Bazar': { x: 550, y: 450, routes: { 'Sylhet': 25 } },
                'Srimangal': { x: 500, y: 550, routes: { 'Sylhet': 50 } },
                'Maulvibazar': { x: 450, y: 650, routes: { 'Sylhet': 75 } },
                'Sylhet': { x: 400, y: 750, routes: { 'Sylhet': 100 } },
                'Faridpur': { x: 550, y: 500, routes: { 'Khulna': 25 } },
                'Jessore': { x: 500, y: 600, routes: { 'Khulna': 50 } },
                'Khulna': { x: 450, y: 700, routes: { 'Khulna': 100, 'Barisal': 0 } },
                'Barisal': { x: 400, y: 800, routes: { 'Barisal': 100 } },
                'Ishwardi': { x: 550, y: 450, routes: { 'Rajshahi': 25 } },
                'Natore': { x: 500, y: 500, routes: { 'Rajshahi': 50 } },
                'Rajshahi': { x: 450, y: 550, routes: { 'Rajshahi': 100 } },
                'Parbatipur': { x: 600, y: 300, routes: { 'Rangpur': 25 } },
                'Rangpur': { x: 600, y: 200, routes: { 'Rangpur': 50 } },
                'Dinajpur': { x: 600, y: 100, routes: { 'Rangpur': 100 } },
                'Tongi': { x: 600, y: 300, routes: { 'Mymensingh': 25 } },
                'Gaffargaon': { x: 650, y: 300, routes: { 'Mymensingh': 50 } },
                'Mymensingh': { x: 650, y: 200, routes: { 'Mymensingh': 100 } },
                'Narayanganj': { x: 650, y: 450, routes: { 'Chittagong Central': 10 } }
            };

            // Populate train schedules
            function populateTrainSchedules() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('api.train-schedules') }}',
                    success: function (response) {
                        const trainScheduleDropdown = $('#train_schedule_id');
                        trainScheduleDropdown.empty().append(new Option('Select Train', ''));
                        response.forEach(schedule => {
                            const displayText = `${schedule.train_name} (${schedule.from_station} to ${schedule.to_station})`;
                            trainScheduleDropdown.append(new Option(displayText, schedule.id));
                        });
                    },
                    error: function (xhr) {
                        console.error('Error fetching train schedules:', xhr.status, xhr.responseText);
                        alert('Error fetching train schedules: ' + (xhr.responseJSON?.message || xhr.statusText));
                    }
                });
            }

            // Track train location
            function trackTrain() {
                const train_schedule_id = $('#train_schedule_id').val();
                const date = $('#date').val();

                if (!train_schedule_id || !date) {
                    alert('Please select both train and date.');
                    return;
                }

                $('#loadingSpinner').show();
                $('#mapSection').hide();
                $('#summary').hide();
                $('#noStatus').hide();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('api.train-status') }}',
                    data: {
                        train_schedule_id,
                        date,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#loadingSpinner').hide();
                        if (response.success && response.status) {
                            updateMap(response.status);
                            updateSummary(response.status);
                            $('#mapSection').show();
                            $('#summary').show();
                        } else {
                            $('#noStatus').text(response.message || 'No tracking information available').show();
                        }
                    },
                    error: function (xhr) {
                        $('#loadingSpinner').hide();
                        console.error('Error fetching train status:', xhr.status, xhr.responseText);
                        $('#noStatus').text('Error fetching train status: ' + (xhr.responseJSON?.message || xhr.statusText)).show();
                    }
                });
            }

            // Update map with train location
            function updateMap(status) {
                const station = stations[status.current_station] || { x: 600, y: 400 };
                const trainIcon = $('#train-icon');
                const indicator = $('#train-indicator');
                const indicatorText = $('#indicator-text');

                // Constrain train icon within SVG bounds
                const maxX = 1360, maxY = 1160; // Adjusted for viewBox 1400x1200 with padding
                const x = Math.max(20, Math.min(station.x - 20, maxX));
                const y = Math.max(20, Math.min(station.y - 20, maxY));

                trainIcon.attr('x', x);
                trainIcon.attr('y', y);

                // Update indicator
                indicator.attr('x', x + 20);
                indicator.attr('y', y - 40);
                indicatorText.text(`${status.current_station} - ${status.status}`);

                // Highlight current station
                $('.station-dot').removeClass('active');
                $(`.station-dot[data-station="${status.current_station}"]`).addClass('active');
            }

            // Update summary card
            function updateSummary(status) {
                $('#trainName').text(status.train_name);
                $('#trainRoute').text(`${status.from_station} to ${status.to_station}`);
                $('#currentStation').text(status.current_station);
                $('#trainStatus').text(status.status);
                $('#lastUpdated').text(new Date(status.last_updated).toLocaleString());
                const progress = stations[status.current_station]?.routes[status.to_station] || 0;
                $('#progressBar').css('width', `${progress}%`).attr('aria-valuenow', progress);
            }

            populateTrainSchedules();
            $('#trackTrain').on('click', trackTrain);
        });
    </script>
</body>
</html>