<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* Global Styles */
        body {
            background-color: #f8f9fa;
        }
        #bookingForm {
            position: absolute;
            top: 50%;
            left: 20%;
            transform: translate(-50%, -50%);
            margin: 20px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            will-change: transform;
        }
        .flex-container {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .flex-container > div {
            flex: 1 1 200px;
        }
        label {
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 14px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0b5ed7;
        }

        /* Popup Styles */
        .popup {
            width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            padding: 20px;
            border-radius: 0.75rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: white;
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e7e7e7;
            padding-bottom: 10px;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
        }

        .modal-body {
            padding: 10px 0;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            padding-top: 10px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .seat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 15px 0;
        }

        .seat-card {
            border: 1px solid #e7e7e7;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8f9fa;
            transition: transform 0.2s ease;
        }

        .seat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .seat-class {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .seat-availability {
            color: #0d6efd;
            margin-bottom: 10px;
        }

        .btn-book {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            width: 100%;
        }

        .btn-book:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>

<body>
    <div id="bookingForm">
        <form id="bookingFormElement" action="#" method="POST">
            <div class="flex-container">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required aria-label="Name">
                </div>
                <div>
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required aria-label="Age" min="1" max="120">
                </div>
                <div>
                    <label for="contactNo">Contact No:</label>
                    <input type="text" id="contactNo" name="contactNo" placeholder="+8801XXXXXXXXX" required pattern="^\+8801[0-9]{9}$" aria-label="Contact Number">
                </div>
                <div>
                    <label for="nationalId">National ID:</label>
                    <input type="text" id="nationalId" name="nationalId" required aria-label="National ID">
                </div>
            </div>

            <div class="flex-container">
                <div>
                    <label for="from">From:</label>
                    <select id="from" name="from" required aria-label="Departure Station"></select>
                </div>
                <div>
                    <label for="to">To:</label>
                    <select id="to" name="to" required aria-label="Arrival Station"></select>
                </div>
                <div>
                    <label for="numberOfTickets">Quantity:</label>
                    <input type="number" id="numberOfTickets" name="numberOfTickets" min="1" max="4" value="1" required aria-label="Number of Tickets">
                </div>
                <div>
                    <label for="class">Class:</label>
                    <select id="class" name="class" aria-label="Class Type">
                        <option value="AC_B">AC_B</option>
                        <option value="AC_S">AC_S</option>
                        <option value="SNIGDHA">SNIGDHA</option>
                        <option value="F_BERTH">F_BERTH</option>
                        <option value="F_SEAT">F_SEAT</option>
                        <option value="S_CHAIR">S_CHAIR</option>
                        <option value="SHOVAN">SHOVAN</option>
                        <option value="SHULOV">SHULOV</option>
                    </select>
                </div>
            </div>

            <div class="flex-container">
                <div>
                    <label for="date">Start of Journey:</label>
                    <input type="date" id="date" name="date" required aria-label="Start of Journey">
                </div>
                <div>
                    <label for="endJourney">End of Journey:</label>
                    <input type="date" id="endJourney" name="endJourney" disabled aria-label="End of Journey">
                </div>
                <div>
                    <label for="journeyType">Journey Type:</label>
                    <select id="journeyType" name="journeyType" aria-label="Journey Type">
                        <option value="oneWay">One Way</option>
                        <option value="roundTrip">Round Trip</option>
                    </select>
                </div>
            </div>

            <div class="flex-container">
                <div>
                    <label for="departureTime">Departure Time:</label>
                    <select id="departureTime" name="departureTime" required aria-label="Departure Time">
                        <option value="">Select Departure Time</option>
                    </select>
                </div>
                <div>
                    <label for="arrivalTime">Arrival Time:</label>
                    <select id="arrivalTime" name="arrivalTime" required aria-label="Arrival Time">
                        <option value="">Select Arrival Time</option>
                    </select>
                </div>
                <div>
                    <label for="ticketType">Ticket Type:</label>
                    <select id="ticketType" name="ticketType" aria-label="Ticket Type">
                        <option value="adult">Adult</option>
                        <option value="children">Children</option>
                    </select>
                </div>
            </div>
            <input type="submit" value="Submit" style="font-weight: bold;">
        </form>
    </div>

    <!-- Seat Availability Popup -->
    <div id="seatAvailabilityPopup" class="popup">
        <div class="modal-header">
            <h5 class="modal-title">Seat Availability</h5>
            <button type="button" class="close" aria-label="Close">×</button>
        </div>
        <div class="modal-body" id="seatAvailabilityContent">
            <!-- Grid cards will be populated here -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary close">Close</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            const bangladeshiStations = [
                'Dhaka Junction',
                'Chittagong Central',
                'Khulna Terminal',
                'Rajshahi Station',
                'Sylhet Junction',
                'Barisal Central',
                'Rangpur Terminal',
                'Comilla Junction',
                'Mymensingh Central',
                'Jessore Station'
            ];

            function populateDropdowns() {
                const fromDropdown = $('#from');
                const toDropdown = $('#to');

                bangladeshiStations.forEach(function (station) {
                    fromDropdown.append(new Option(station, station));
                    toDropdown.append(new Option(station, station));
                });
            }

            populateDropdowns();

            function fetchTrainTimes() {
                const from = $('#from').val();
                const to = $('#to').val();
                const date = $('#date').val();

                if (from && to && date) {
                    $.ajax({
                        type: 'POST',
                        url: '/booking/train-times',
                        data: {
                            from: from,
                            to: to,
                            date: date,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                populateTimeDropdowns(response.trainSchedules);
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching train times:', error);
                            alert('Error: ' + xhr.responseText);
                        }
                    });
                }
            }

            function populateTimeDropdowns(trainSchedules) {
                const departureTimeDropdown = $('#departureTime');
                const arrivalTimeDropdown = $('#arrivalTime');

                departureTimeDropdown.empty();
                arrivalTimeDropdown.empty();

                trainSchedules.forEach(function (schedule) {
                    const departureOption = new Option(`${schedule.departure_time} (${schedule.train_type})`, schedule.departure_time);
                    const arrivalOption = new Option(`${schedule.arrival_time} (${schedule.train_type})`, schedule.arrival_time);

                    departureTimeDropdown.append(departureOption);
                    arrivalTimeDropdown.append(arrivalOption);
                });
            }

            $('#from, #to, #date').on('change', fetchTrainTimes);

            $('#journeyType').on('change', function () {
                const journeyType = $(this).val();
                $('#endJourney').prop('disabled', journeyType !== 'roundTrip');
                if (journeyType !== 'roundTrip') {
                    $('#endJourney').val('');
                }
            });

            $('#bookingFormElement').on('submit', function (e) {
                e.preventDefault();
                const formData = {
                    from: $('#from').val(),
                    to: $('#to').val(),
                    date: $('#date').val(),
                    journeyType: $('#journeyType').val(),
                    departureTime: $('#departureTime').val(),
                    arrivalTime: $('#arrivalTime').val(),
                    class: $('#class').val(),
                    ticketType: $('#ticketType').val(),
                    numberOfTickets: $('#numberOfTickets').val(),
                    contactNo: $('#contactNo').val(),
                    name: $('#name').val(),
                    age: $('#age').val(),
                    nationalId: $('#nationalId').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                console.log('Form Data:', formData);

                $.ajax({
                    type: 'POST',
                    url: '/booking/get-seat-availability',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            let seatContent = '<div class="seat-grid">';
                            for (const [classType, availableSeats] of Object.entries(response.seatAvailability)) {
                                seatContent += `
                                    <div class="seat-card">
                                        <div class="seat-class">${classType}</div>
                                        <div class="seat-availability">${availableSeats} seats available</div>
                                        <button class="btn-book" data-class="${classType}" 
                                                data-seats="${availableSeats}">
                                            Book Now
                                        </button>
                                    </div>
                                `;
                            }
                            seatContent += '</div>';
                            $('#seatAvailabilityContent').html(seatContent);
                            $('#seatAvailabilityPopup').show();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching seat availability:', error);
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });

            // Handle Book Now button clicks
            $(document).on('click', '.btn-book', function() {
                const classType = $(this).data('class');
                const availableSeats = $(this).data('seats');
                const numberOfTickets = $('#numberOfTickets').val();
                
                if (parseInt(availableSeats) >= parseInt(numberOfTickets)) {
                    alert(`Booking ${numberOfTickets} ticket(s) for ${classType}`);
                    // Uncomment and modify the following lines to implement actual booking
                    // $('#class').val(classType);
                    // $('#bookingFormElement').submit();
                } else {
                    alert(`Not enough seats available! Requested: ${numberOfTickets}, Available: ${availableSeats}`);
                }
            });

            // Close popup
            $(document).on('click', '.close', function() {
                $('#seatAvailabilityPopup').hide();
            });
        });
    </script>
</body>
</html>