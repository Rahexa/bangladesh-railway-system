<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Availability - Railway System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            min-height: 100vh;
            padding-bottom: 100px;
        }
        .hero-section {
            background: linear-gradient(135deg, #003087 0%, #00a3b5 100%);
            color: white;
            padding: 5rem 0;
            text-align: center;
            border-radius: 0 0 60px 60px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }
        .filter-bar {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
            z-index: 1000;
            margin-bottom: 2.5rem;
        }
        .seat-card {
            background-color: #ffffff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0;
            animation: fadeIn 0.6s ease forwards;
        }
        .seat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        .seat-card.unavailable {
            background-color: #fee2e2;
            border: 1px solid #f87171;
        }
        .seat-card .badge {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
            border-radius: 12px;
        }
        .btn-search {
            background: linear-gradient(90deg, #f59e0b, #d97706);
            border: none;
            transition: background 0.3s ease;
        }
        .btn-search:hover {
            background: linear-gradient(90deg, #d97706, #b45309);
        }
        .btn-refresh {
            background: linear-gradient(90deg, #f59e0b, #d97706);
            border: none;
            transition: background 0.3s ease;
        }
        .btn-refresh:hover {
            background: linear-gradient(90deg, #d97706, #b45309);
        }
        .progress {
            height: 10px;
            border-radius: 12px;
            background-color: #e2e8f0;
        }
        .progress-bar {
            background-color: #00a3b5;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .seat-card:nth-child(1) { animation-delay: 0.1s; }
        .seat-card:nth-child(2) { animation-delay: 0.2s; }
        .seat-card:nth-child(3) { animation-delay: 0.3s; }
        .icon-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .summary {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .filter-btn {
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-weight: 600;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .filter-btn.active {
            background: linear-gradient(90deg, #3b82f6, #1e40af);
            color: #fff;
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
            background: linear-gradient(135deg, #10b981, #059669);
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
            background: linear-gradient(135deg, #059669, #047857);
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Check Seat Availability</h1>
            <p class="lead mb-4">View real-time seat options for your train journey.</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="container my-5">
        <div class="filter-bar">
            <form id="seatAvailabilityForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="train_schedule_id" class="form-label fw-medium">Select Train</label>
                        <select name="train_schedule_id" id="train_schedule_id" class="form-select" aria-label="Select Train">
                            <option value="">Select Train</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="coach" class="form-label fw-medium">Coach</label>
                        <select name="coach" id="coach" class="form-select" aria-label="Select Coach">
                            <option value="">Select Coach</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label fw-medium">Travel Date</label>
                        <input type="date" name="date" id="date" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="checkAvailability" class="btn btn-search text-white fw-semibold px-4 py-2 w-100">
                            <i class="bi bi-train-front-fill me-2"></i>Check Now
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="loading_spinner" style="display: none;">
            <i class="bi bi-arrow-repeat fa-spin fa-2x text-primary"></i>
            <p class="mt-2 text-gray-600 font-medium">Fetching seat availability...</p>
        </div>

        <!-- Summary Section -->
        <div id="summary" class="summary" style="display: none;">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div class="mb-3 mb-md-0">
                    <span class="icon-text">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        Available: <span id="availableCount" class="text-success fw-bold">0</span>
                    </span>
                    <span class="icon-text ms-4">
                        <i class="bi bi-x-circle-fill text-danger"></i>
                        Booked: <span id="bookedCount" class="text-danger fw-bold">0</span>
                    </span>
                </div>
                <div>
                    <button class="filter-btn bg-gray-200 active" data-filter="all">All</button>
                    <button class="filter-btn bg-gray-200" data-filter="available">Available</button>
                    <button class="filter-btn bg-gray-200" data-filter="booked">Booked</button>
                    <button id="refreshBtn" class="btn-refresh text-white px-3 py-2 ms-2">
                        <i class="bi bi-arrow-repeat me-2"></i>Refresh
                    </button>
                </div>
            </div>
            <div class="mt-3">
                <small class="text-muted">Seat Availability</small>
                <div class="progress mt-1">
                    <div id="availabilityProgress" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <!-- Seat Grid -->
        <div id="seatAvailability" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="display: none;"></div>
        <div id="noAvailability" class="text-center text-muted mt-4 fs-5" style="display: none;">
            <i class="bi bi-info-circle me-2"></i>Error fetching seat availability
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
    let allSeats = [];
    let selectedCoachName = ''; // Store the selected coach name

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
                console.error('Error fetching train schedules:', xhr.responseText);
                alert('Error fetching train schedules.');
            }
        });
    }

    function populateCoaches() {
        $.ajax({
            type: 'GET',
            url: '{{ route('api.coaches') }}',
            success: function (response) {
                const coachDropdown = $('#coach');
                coachDropdown.empty().append(new Option('Select Coach', ''));
                response.forEach(coach => {
                    coachDropdown.append(new Option(`${coach.coach_name} (${coach.class_name})`, coach.coach_name));
                });
            },
            error: function (xhr) {
                console.error('Error fetching coaches:', xhr.responseText);
                alert('Error fetching coaches.');
            }
        });
    }

    function fetchSeatAvailability() {
        const train_schedule_id = $('#train_schedule_id').val();
        selectedCoachName = $('#coach').val(); // Store the selected coach name
        const date = $('#date').val();

        if (!train_schedule_id || !selectedCoachName || !date) {
            alert('Please select all fields before checking availability.');
            return;
        }

        $('#loadingSpinner').show();
        $('#seatAvailability').hide();
        $('#noAvailability').hide();
        $('#summary').hide();

        $.ajax({
            type: 'POST',
            url: '{{ route('api.seat-availability') }}',
            data: {
                train_schedule_id,
                coach_name: selectedCoachName,
                date,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#loadingSpinner').hide();
                if (response.success && response.seats.length > 0) {
                    allSeats = response.seats;
                    renderSeats(allSeats, selectedCoachName); // Pass coach name to renderSeats
                    updateSummary();
                    $('#summary').show();
                    $('#seatAvailability').show();
                } else {
                    $('#noAvailability').text(response.message || 'No seats available for this selection').show();
                }
            },
            error: function (xhr) {
                $('#loadingSpinner').hide();
                console.error('Error fetching seat availability:', xhr.responseText);
                $('#noAvailability').text('Error fetching seat availability').show();
            }
        });
    }

    function renderSeats(seats, coachName) {
        let seatContent = '';
        seats.forEach(seat => {
            const isAvailable = seat.status === 'available';
            seatContent += `
                <div class="col">
                    <div class="seat-card card h-100 ${!isAvailable ? 'unavailable' : ''}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0 fw-bold">${seat.seat_number}</h5>
                                <span class="badge ${isAvailable ? 'bg-success' : 'bg-danger'}">
                                    ${isAvailable ? 'Available' : 'Booked'}
                                </span>
                            </div>
                            <p class="card-text icon-text">
                                <i class="bi bi-chair"></i>
                                Coach: ${coachName} <!-- Use the passed coachName -->
                            </p>
                        </div>
                    </div>
                </div>
            `;
        });
        $('#seatAvailability').html(seatContent);
    }

    function updateSummary() {
        const availableCount = allSeats.filter(seat => seat.status === 'available').length;
        const bookedCount = allSeats.filter(seat => seat.status === 'booked').length;
        const totalCount = allSeats.length;
        const availablePercentage = totalCount ? (availableCount / totalCount * 100) : 0;
        $('#availableCount').text(availableCount);
        $('#bookedCount').text(bookedCount);
        $('#availabilityProgress').css('width', `${availablePercentage}%`).attr('aria-valuenow', availableCount);
    }

    function filterSeats(status) {
        let filteredSeats = allSeats;
        if (status === 'available') {
            filteredSeats = allSeats.filter(seat => seat.status === 'available');
        } else if (status === 'booked') {
            filteredSeats = allSeats.filter(seat => seat.status === 'booked');
        }
        renderSeats(filteredSeats, selectedCoachName); // Pass coach name to renderSeats
    }

    populateTrainSchedules();
    populateCoaches();

    $('#checkAvailability').on('click', fetchSeatAvailability);

    $('#refreshBtn').on('click', fetchSeatAvailability);

    $('.filter-btn').on('click', function () {
        $('.filter-btn').removeClass('active bg-gray-200').addClass('bg-gray-200');
        $(this).addClass('active').removeClass('bg-gray-200');
        const filter = $(this).data('filter');
        filterSeats(filter);
    });
});
    </script>
</body>
</html>