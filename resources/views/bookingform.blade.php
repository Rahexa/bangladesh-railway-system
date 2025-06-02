<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Inter', sans-serif; 
        }
        #otpMessage {
            display: block;
            min-height: 16px;
            text-align: left;
            font-size: 0.75rem;
            color: #4b5563;
            margin-bottom: 4px;
        }
        #bookingForm { 
            position: absolute; 
            top: 50%; 
            left: 20%; 
            transform: translate(-50%, -50%); 
            margin-top: 55px;
            padding: 20px; 
            background: #ffffff; 
            border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
            max-width: 450px; 
            will-change: transform; 
        }
        .flex-container { 
            display: flex; 
            gap: 20px; 
            margin-bottom: 15px; 
            flex-wrap: nowrap; 
        }
        .flex-container > div { 
            flex: 1; 
            min-width: 0; 
        }
        label { 
            font-weight: 600; 
            color: #2d3748; 
            font-size: 14px; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
        }
        input[type="text"], input[type="number"], input[type="date"], select { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #e2e8f0; 
            border-radius: 6px; 
            font-size: 14px; 
            box-sizing: border-box; 
            background: linear-gradient(145deg, #ffffff, #f7fafc); 
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05); 
            transition: border-color 0.2s ease, box-shadow 0.2s ease; 
            font-family: 'Inter', sans-serif; 
        }
        input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus, select:focus { 
            border-color: #3182ce; 
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.2); 
            outline: none; 
        }
        input[type="date"]:disabled { 
            background-color: #edf2f7; 
            color: #a0aec0; 
        }
        input[type="submit"] { 
            width: 100%; 
            padding: 10px; 
            background: linear-gradient(90deg, #3182ce, #63b3ed); 
            color: white; 
            border: none; 
            border-radius: 6px; 
            font-size: 16px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: background 0.3s ease; 
            font-family: 'Inter', sans-serif; 
        }
        input[type="submit"]:hover { 
            background: linear-gradient(90deg, #2b6cb0, #4299e1); 
        }
        .popup { 
            width: 600px; 
            height: 400px; 
            padding: 15px; 
            border-radius: 12px; 
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); 
            background: linear-gradient(135deg, #ffffff, #f1f5f9); 
            display: none; 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            z-index: 1000; 
            overflow: hidden; 
        }
        .modal-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-bottom: 2px solid #e7e7e7; 
            padding-bottom: 8px; 
            margin-bottom: 10px; 
        }
        .modal-title { 
            font-size: 1.25rem; 
            font-weight: 700; 
            color: #1e293b; 
        }
        .total-seats { 
            background-color: #28a745; 
            color: white; 
            padding: 1px 4px; 
            border-radius: 12px; 
            font-size: 0.6rem; 
            font-weight: 600; 
            margin-left: 6px; 
            white-space: nowrap; 
        }
        .seat-class.selected .total-seats { 
            color: white; 
            background-color: #28a745; 
        }
        .modal-body { 
            padding: 0; 
            height: calc(100% - 70px); 
        }
        .modal-footer { 
            display: flex; 
            justify-content: flex-end; 
            padding-top: 10px; 
        }
        .btn-secondary { 
            background-color: #6b7280; 
            color: white; 
            border: none; 
            padding: 0.4rem 0.8rem; 
            border-radius: 6px; 
            font-size: 0.75rem; 
            font-weight: 600; 
            transition: background-color 0.3s ease; 
        }
        .btn-secondary:hover { 
            background-color: #4b5563; 
        }
        .seat-grid { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 6px; 
            margin: 0; 
            height: 100%; 
            background-color: #f8fafc; 
            padding: 10px; 
            border-radius: 8px; 
        }
        .seat-card { 
            border: none; 
            border-radius: 8px; 
            padding: 8px; 
            background: #ffffff; 
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1); 
            transition: transform 0.2s ease, box-shadow 0.2s ease; 
            min-height: 90px; 
            font-size: 0.75rem; 
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
        }
        .seat-card:hover:not(.sold-out) { 
            transform: translateY(-3px); 
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15); 
        }
        .seat-class { 
            font-weight: 700; 
            color: #1e293b; 
            margin-bottom: 4px; 
            text-transform: uppercase; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
        }
        .seat-class.ac-b { 
            font-size: 0.85rem; 
        }
        .seat-class.selected { 
            color: #3182ce; 
        }
        .seat-availability { 
            color: #3182ce; 
            margin-bottom: 4px; 
            font-weight: 500; 
            background-color: rgba(49, 130, 206, 0.1); 
            padding: 2px 6px; 
            border-radius: 4px; 
            display: inline-block; 
        }
        .sold-out .seat-availability { 
            background-color: #ffcccc; 
            color: #dc2626; 
            font-weight: 600; 
        }
        .sold-out { 
            cursor: not-allowed; 
            opacity: 0.8; 
        }
        .sold-out .btn-book { 
            pointer-events: none; 
            background: #6b7280; 
            opacity: 0.6; 
        }
        .action-row { 
            display: flex; 
            align-items: center; 
            justify-content: flex-end; 
            gap: 6px; 
        }
        .seat-price { 
            font-weight: 700; 
            color: #28a745; 
            font-size: 0.85rem; 
        }
        .btn-book { 
            background: linear-gradient(90deg, #3182ce, #63b3ed); 
            color: white; 
            border: none; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 0.7rem; 
            font-weight: 600; 
            cursor: pointer; 
            transition: background 0.3s ease; 
        }
        .btn-book:hover { 
            background: linear-gradient(90deg, #2b6cb0, #4299e1); 
        }
        .route-icon { 
            margin-right: 8px; 
            color: #3182ce; 
        }
        #seatSelectionPopup { 
            width: 900px; 
            height: 500px; 
            padding: 20px; 
            border-radius: 12px; 
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); 
            background: #ffffff; 
            display: none; 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            z-index: 1001; 
        }
        .seat { 
            width: 30px; 
            height: 30px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 8px; 
            flex-direction: column; 
            background-color: #d1d5db; 
            margin: 0; 
        }
        .seat i.ph.ph-chair { 
            font-size: 16px; 
            line-height: 1; 
        }
        .seat span { 
            font-size: 8px; 
            line-height: 1; 
        }
        .available { 
            color: black; 
        }
        .booked { 
            background-color: #f87171; 
            color: white; 
            cursor: not-allowed; 
        }
        .selected { 
            background-color: transparent; 
            color: black; 
        }
        .selected span { 
            color: #3182ce; 
        }
        .seat-dark-green-hover { 
            transition: background-color 0.3s ease; 
        }
        .seat-dark-green-hover:hover:not(.booked) { 
            background-color: #006400; 
            color: white; 
        }
        .seat-dark-green-hover:hover:not(.booked) span { 
            color: white; 
        }
        .seat-dark-green-selected { 
            background-color: #006400; 
            color: white; 
        }
        .seat-dark-green-selected span { 
            color: white; 
        }
        .gap { 
            width: 12px; 
            height: 40px; 
        }
        .coach-button { 
            width: 90px; 
            padding: 5px; 
            border-radius: 8px; 
            background: linear-gradient(90deg, #4ade80, #68d391); 
            color: white; 
            font-size: 10px; 
            text-align: center; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
            font-family: 'Inter', sans-serif; 
        }
        .coach-button.selected { 
            background: linear-gradient(90deg, #6b7280, #4b5563); 
            border: 2px solid #4b5563; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15); 
        }
        .coach-button:not(.selected):hover { 
            background: linear-gradient(90deg, #34d399, #48bb78); 
        }
        .button-container { 
            display: flex; 
            justify-content: flex-end; 
            gap: 8px; 
            margin-top: 8px; 
        }
        .cancel-button { 
            padding: 6px 12px; 
            background: linear-gradient(90deg, #ef4444, #f87171); 
            color: white; 
            border-radius: 4px; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            height: 32px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 14px; 
        }
        .cancel-button:hover { 
            background: linear-gradient(90deg, #dc2626, #ef4444); 
        }
        .proceed-button { 
            padding: 6px 12px; 
            background: linear-gradient(90deg, #3182ce, #63b3ed); 
            color: white; 
            border-radius: 4px; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            height: 32px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 14px; 
        }
        .proceed-button:hover { 
            background: linear-gradient(90deg, #2b6cb0, #4299e1); 
        }
        .coach-selection { 
            padding: 8px; 
            min-height: 50px; 
        }
        .seat-selection { 
            padding: 8px; 
            height: 200px; 
            overflow-y: hidden; 
        }
        .seat-container { 
            display: flex; 
            flex-direction: column; 
            gap: 2px; 
            padding: 0 5px; 
            width: 100%; 
            min-height: 180px; 
        }
        #transactionSuccessPopup { 
            width: 450px; 
            height: 300px; 
            border-radius: 12px; 
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); 
            background: #ffffff; 
            display: none; 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            z-index: 1002; 
            overflow: hidden; 
        }
        #transactionFailPopup, #transactionCancelPopup, #ticketLimitPopup { 
            width: 400px; 
            height: 280px; 
            padding: 20px; 
            border-radius: 12px; 
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); 
            background: #ffffff; 
            display: none; 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            z-index: 1002; 
        }
        #paymentConfirmationPopup { 
            width: 650px; 
            height: 450px; 
            background: linear-gradient(135deg, #f7fafc, #edf2f7); 
            border-radius: 16px; 
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); 
            display: none; 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            z-index: 1000; 
            padding: 20px; 
            overflow: hidden; 
        }
        #paymentConfirmationContent {
            display: grid;
            grid-template-columns: repeat(3, 1fr); 
            gap: 10px;
            padding: 10px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        #paymentConfirmationContent div {
            font-size: 0.9rem;
            color: #2d3748;
        }
        #paymentConfirmationContent .font-medium {
            font-weight: 600;
        }
        #paymentConfirmationContent .text-green-600 {
            font-weight: 700;
        }
        .success-message { 
            color: #28a745; 
            font-weight: 600; 
            text-align: center; 
        }
        .fail-message { 
            color: #dc2626; 
            font-weight: 600; 
            text-align: center; 
        }
        .cancel-message { 
            color: #6b7280; 
            font-weight: 600; 
            text-align: center; 
        }
        .limit-message { 
            color: #f59e0b; 
            font-weight: 600; 
            text-align: center; 
        }
        #alertPopup { 
            width: 350px; 
            height: 280px; 
            background: #ffffff; 
            border-radius: 12px; 
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); 
            display: none; 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            z-index: 1003; 
            padding: 20px; 
            text-align: center; 
        }
        .alert-icon { 
            color: #e53e3e; 
            font-size: 2rem; 
            margin-bottom: 10px; 
        }
        .close-seat-selection {
            color: #6b7280;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .close-seat-selection:hover {
            color: #4b5563;
        }
        .highlight-update {
            animation: highlight 1s ease-in-out;
        }
        @keyframes highlight {
            0% { background-color: #fefcbf; }
            100% { background-color: #f8fafc; }
        }
    </style>
</head>
<body>
    <div id="bookingForm">
        <form id="bookingFormElement" action="{{ route('booking.store') }}" method="POST" novalidate>
            @csrf
            <div class="flex-container">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required aria-label="Name" value="{{ Auth::user() ? Auth::user()->first_name : '' }}">
                </div>
                <div>
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required aria-label="Age" min="1" max="120">
                </div>
                <div>
                    <label for="contact_no">Contact No:</label>
                    <input type="text" id="contact_no" name="contact_no" placeholder="+8801XXXXXXXXX" required pattern="^\+8801[0-9]{9}$" aria-label="Contact Number" value="{{ Auth::user() ? Auth::user()->mobile : '' }}">
                </div>
                <div>
                    <label for="national_id">National ID:</label>
                    <input type="text" id="national_id" name="national_id" required aria-label="National ID">
                </div>
            </div>
            <div class="flex-container">
                <div>
                    <label for="from">From:</label>
                    <select id="from" name="from" required aria-label="Departure Station">
                        <option value="">Select Station</option>
                    </select>
                </div>
                <div>
                    <label for="to">To:</label>
                    <select id="to" name="to" required aria-label="Arrival Station">
                        <option value="">Select Station</option>
                    </select>
                </div>
                <div>
                    <label for="number_of_tickets">Quantity:</label>
                    <input type="number" id="number_of_tickets" name="number_of_tickets" min="1" max="4" value="1" required aria-label="Number of Tickets">
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
                    <label for="date">Start Journey:</label>
                    <input type="date" id="date" name="date" required aria-label="Start of Journey">
                </div>
                <div>
                    <label for="end_journey">End Journey:</label>
                    <input type="date" id="end_journey" name="end_journey" disabled aria-label="End of Journey">
                </div>
                <div>
                    <label for="journey_type">Journey Type:</label>
                    <select id="journey_type" name="journey_type" aria-label="Journey Type">
                        <option value="oneWay">One Way</option>
                        <option value="roundTrip">Round Trip</option>
                    </select>
                </div>
            </div>
            <div class="flex-container">
                <div>
                    <label for="train_schedule_id">Train Schedule:</label>
                    <select id="train_schedule_id" name="train_schedule_id" required aria-label="Train Schedule">
                        <option value="">Select Train</option>
                    </select>
                </div>
                <div>
                    <label for="ticket_type">Ticket Type:</label>
                    <select id="ticket_type" name="ticket_type" aria-label="Ticket Type">
                        <option value="adult">Adult</option>
                        <option value="children">Children</option>
                    </select>
                </div>
            </div>
            <input type="hidden" id="selected_seats" name="selected_seats" value="[]">
            <input type="hidden" id="coach" name="coach" value="">
            <input type="submit" value="Submit" style="font-weight: bold;">
        </form>
    </div>

    <div id="seatAvailabilityPopup" class="popup">
        <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-train-front route-icon"></i><span id="selectedRoute"></span></h5>
            <button type="button" class="close" aria-label="Close">×</button>
        </div>
        <div class="modal-body" id="seatAvailabilityContent"></div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary close">Close</button></div>
    </div>

    <div id="seatSelectionPopup" class="popup">
        <div class="flex flex-col h-full">
            <div class="flex justify-between items-center mb-3">
                <h5 class="text-lg font-semibold text-gray-800">Select Coach and Seats</h5>
                <button type="button" class="close-seat-selection" aria-label="Close">×</button>
            </div>
            <div class="container mx-auto p-4 flex-grow">
                <div class="grid grid-cols-4 gap-3">
                    <div class="col-span-4 bg-white coach-selection rounded-lg shadow-lg">
                        <h2 class="text-base font-semibold mb-2">কোচ নির্বাচন (Select Coach)</h2>
                        <div class="flex justify-center gap-3 flex-wrap" id="coachContainer"></div>
                    </div>
                    <div class="col-span-4 bg-white seat-selection rounded-lg shadow-lg">
                        <h2 class="text-base font-semibold mb-3">আসন পরিচিতি (Seat Selection)</h2>
                        <div id="seat-container" class="seat-container"></div>
                    </div>
                </div>
            </div>
            <div class="button-container">
                <button id="cancel-button" class="cancel-button">Cancel</button>
                <button id="checkout-button" class="proceed-button">Proceed to Payment</button>
            </div>
        </div>
    </div>

    <div id="paymentConfirmationPopup">
        <div class="flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-xl font-semibold text-gray-800 flex items-center"><i class="bi bi-wallet2 text-blue-600 mr-2"></i> Confirm Payment</h5>
                <button type="button" class="close-payment text-gray-500 hover:text-gray-700 text-2xl">×</button>
            </div>
            <div id="paymentConfirmationContent">
                <div><span class="font-medium">Name:</span> <span id="payName"></span></div>
                <div><span class="font-medium">Contact:</span> <span id="payContact"></span></div>
                <div><span class="font-medium">Email:</span> <span id="payEmail"></span></div>
                <div><span class="font-medium">From:</span> <span id="payFrom"></span></div>
                <div><span class="font-medium">To:</span> <span id="payTo"></span></div>
                <div><span class="font-medium">Train:</span> <span id="payTrainName"></span></div>
                <div><span class="font-medium">Date:</span> <span id="payDate"></span></div>
                <div><span class="font-medium">Departure:</span> <span id="payDep"></span></div>
                <div><span class="font-medium">Arrival:</span> <span id="payArr"></span></div>
                <div><span class="font-medium">Class:</span> <span id="payClass"></span></div>
                <div><span class="font-medium">Quantity:</span> <span id="payTickets"></span></div>
                <div><span class="font-medium">Ticket Type:</span> <span id="payTicketType"></span></div>
                <div><span class="font-medium">Seats:</span> <span id="paySeats"></span></div>
                <div><span class="font-medium">Coach:</span> <span id="payCoach"></span></div>
                <div><span class="font-medium">Total:</span> <span id="payTotal" class="text-green-600 font-bold"></span></div>
            </div>
            <div class="mt-4 flex flex-col gap-2">
                <span id="otpMessage" class="text-xs text-gray-600 block"></span>
                <div class="flex items-center gap-3">
                    <input type="text" id="otpInput" maxlength="6" class="w-24 p-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="OTP">
                    <button id="verifyOtpBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition">Verify</button>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-4">
                <button type="button" class="close-payment bg-gray-500 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-600 transition">Cancel</button>
                <button type="button" id="confirmPaymentBtn" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 transition" disabled>Confirm</button>
            </div>
        </div>
    </div>
    <div id="transactionSuccessPopup" class="popup">
        <div class="p-6 flex flex-col h-full justify-between">
            <div>
                <h5 class="text-lg font-semibold success-message">Payment Successful!</h5>
                <p class="text-center mt-4">Transaction ID: <span id="transactionId"></span></p>
                <p class="text-center">Total Amount: <span id="transactionTotal"></span></p>
            </div>
            <div class="flex justify-center">
                <button id="closeSuccessBtnBottom" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Close</button>
            </div>
        </div>
    </div>
    <div id="transactionFailPopup" class="popup">
        <div class="flex flex-col h-full justify-between">
            <div>
                <h5 class="text-lg font-semibold fail-message">Payment Failed</h5>
                <p class="text-center mt-4" id="failReason"></p>
            </div>
            <div class="flex justify-center">
                <button id="closeFailBtn" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Close</button>
            </div>
        </div>
    </div>
    <div id="transactionCancelPopup" class="popup">
        <div class="flex flex-col h-full justify-between">
            <div>
                <h5 class="text-lg font-semibold cancel-message">Payment Cancelled</h5>
                <p class="text-center mt-4">Your payment was cancelled.</p>
            </div>
            <div class="flex justify-center">
                <button id="closeCancelBtn" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>
    <div id="ticketLimitPopup" class="popup">
        <div class="flex flex-col h-full justify-between p-6">
            <div class="text-center">
                <i class="fas fa-exclamation-circle alert-icon text-yellow-500"></i>
                <h5 class="text-lg font-semibold limit-message">Ticket Limit Exceeded</h5>
                <p class="text-center mt-4 text-gray-700" id="limitReason"></p>
            </div>
            <div class="flex justify-center mt-4">
                <button id="closeLimitBtn" class="bg-yellow-600 text-white px-6 py-2 rounded-md hover:bg-yellow-700 transition duration-300">Close</button>
            </div>
        </div>
    </div>
    <div id="alertPopup">
        <div class="flex flex-col h-full justify-between">
            <div>
                <i class="fas fa-exclamation-triangle alert-icon"></i>
                <h5 class="text-lg font-semibold text-red-600">Incomplete Form</h5>
                <p class="text-center mt-2 text-gray-700" id="alertMessage">Please fill all required fields before submitting.</p>
            </div>
            <div class="flex justify-center">
                <button id="closeAlertBtn" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Close</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
    console.log('jQuery loaded:', typeof $ !== 'undefined' ? 'Yes' : 'No');

    let selectedSeats = [];
    let selectedCoachButton = null;
    let bookingData = {};
    let generatedOtp = null;
    let ticketLimitExceeded = false;
    let isSubmitting = false; // Flag to prevent multiple submissions

    // Generate a unique transaction ID
    function generateTransactionId() {
        return 'SSLCZ_BOOK_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
    }

    const bangladeshiStations = [
        'Dhaka Junction', 'Chittagong Central', 'Khulna Terminal', 'Rajshahi Station',
        'Sylhet Junction', 'Barisal Central', 'Rangpur Terminal', 'Comilla Junction',
        'Mymensingh Central', 'Jessore Station', 'Dinajpur Station', "Cox's Bazar",
        'Tarakandi', 'Kishoreganj', 'Dewanganj', 'Mohanganj', 'Benapole', 'Chilahati',
        'Nilphamari', 'Santahar', 'Panchagarh', 'Lalmonirhat', 'Kurigram', 'Noakhali',
        'Feni', 'Bhairab Bazaar', 'Netrokona', 'Srimangal', 'Bandarban', 'Rangamati'
    ];

    function populateStationDropdowns() {
        const fromDropdown = $('#from');
        const toDropdown = $('#to');
        fromDropdown.find('option:not(:first)').remove();
        toDropdown.find('option:not(:first)').remove();
        bangladeshiStations.forEach(station => {
            fromDropdown.append(new Option(station, station));
            toDropdown.append(new Option(station, station));
        });
    }

    populateStationDropdowns();

    let trainSchedules = [];

    function fetchTrainSchedules() {
        const from = $('#from').val();
        const to = $('#to').val();
        const date = $('#date').val();

        if (from && to && date && from !== to) {
            console.log('Fetching train schedules for:', { from, to, date });
            $.ajax({
                type: 'POST',
                url: '{{ route("booking.get-train-schedules") }}',
                data: { from, to, date, _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    console.log('Train schedules response:', response);
                    if (response.success) {
                        trainSchedules = response.trainSchedules;
                        populateTrainScheduleDropdown(trainSchedules);
                    } else {
                        alert(response.message || 'No trains available for this route and date.');
                        $('#train_schedule_id').empty().append(new Option('No Trains Available', ''));
                    }
                },
                error: function (xhr) {
                    console.error('Error fetching train schedules:', xhr.status, xhr.responseText);
                    alert('Error fetching train schedules: ' + (xhr.responseJSON?.message || xhr.statusText));
                }
            });
        } else {
            $('#train_schedule_id').empty().append(new Option('Select From, To, and Date First', ''));
        }
    }

    function populateTrainScheduleDropdown(schedules) {
        const trainScheduleDropdown = $('#train_schedule_id');
        trainScheduleDropdown.empty().append(new Option('Select Train', ''));
        schedules.forEach(schedule => {
            const displayText = `${schedule.train_name} (${schedule.departure_time} - ${schedule.arrival_time})`;
            const option = new Option(displayText, schedule.id);
            option.dataset.trainName = schedule.train_name;
            option.dataset.departureTime = schedule.departure_time;
            option.dataset.arrivalTime = schedule.arrival_time;
            trainScheduleDropdown.append(option);
        });
    }

    function fetchSeatAvailability() {
        if (ticketLimitExceeded) {
            $('#ticketLimitPopup').css('display', 'block');
            return;
        }
        console.log('Fetching seat availability with bookingData:', bookingData);
        $.ajax({
            type: 'POST',
            url: '{{ route("booking.get-seat-availability") }}',
            data: bookingData,
            success: function (response) {
                console.log('Seat availability response:', response);
                if (response.success) {
                    let seatContent = '<div class="seat-grid">';
                    const allClassTypes = ['AC_B', 'AC_S', 'SNIGDHA', 'F_BERTH', 'F_SEAT', 'S_CHAIR', 'SHOVAN', 'SHULOV'];
                    const selectedClass = bookingData.class;

                    const classAvailability = {};
                    allClassTypes.forEach(classType => {
                        classAvailability[classType] = { total: 0, available: 0 };
                    });
                    response.coaches.forEach(coach => {
                        if (coach.class_name === selectedClass) {
                            classAvailability[selectedClass].total += coach.total_seats;
                            classAvailability[selectedClass].available += coach.available_seats;
                        }
                    });

                    allClassTypes.forEach(classType => {
                        const totalSeats = classAvailability[classType].total || 0;
                        const availableSeats = classAvailability[classType].available || 0;
                        const price = response.ticketPrice?.[classType] || '500';
                        const isSelected = classType === selectedClass ? 'selected' : '';
                        const isACB = classType === 'AC_B' ? 'ac-b' : '';
                        const isSoldOut = availableSeats === 0 ? 'sold-out' : '';
                        const availabilityText = availableSeats === 0 ? 'Sold Out' : `${availableSeats} seats available`;

                        seatContent += `
                            <div class="seat-card ${isSoldOut}">
                                <div class="seat-class ${isACB} ${isSelected}">
                                    ${classType}
                                    <span class="total-seats">${totalSeats} seats</span>
                                </div>
                                <div class="seat-availability">${availabilityText}</div>
                                <div class="action-row">
                                    <div class="seat-price">৳${price}</div>
                                    <button class="btn-book" data-class="${classType}" 
                                            data-seats="${availableSeats}" data-price="${price}">
                                        Book Now
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                    seatContent += '</div>';
                    $('#seatAvailabilityContent').html(seatContent).addClass('highlight-update');
                    $('#seatAvailabilityPopup').css('display', 'block');
                    console.log('Seat availability popup displayed');
                    setTimeout(() => $('#seatAvailabilityContent').removeClass('highlight-update'), 1000);
                } else {
                    $('#alertPopup').css('display', 'block');
                    $('#alertMessage').text(response.message || 'Failed to fetch seat availability.');
                }
            },
            error: function (xhr) {
                console.error('AJAX error for seat availability:', xhr.status, xhr.responseText);
                $('#alertPopup').css('display', 'block');
                $('#alertMessage').text(xhr.responseJSON?.message || 'Error fetching seat availability.');
            }
        });
    }

    $('#from, #to, #date').on('change', fetchTrainSchedules);

    $('#train_schedule_id').on('change', function () {
        const selectedOption = $(this).find(':selected');
        bookingData.train_schedule_id = this.value;
        bookingData.train_name = selectedOption.data('trainName');
        bookingData.departure_time = selectedOption.data('departureTime');
        bookingData.arrival_time = selectedOption.data('arrivalTime');
        console.log('Updated bookingData with train selection:', bookingData);
    });

    $('#journey_type').on('change', function () {
        const journeyType = $(this).val();
        $('#end_journey').prop('disabled', journeyType !== 'roundTrip');
        if (journeyType !== 'roundTrip') $('#end_journey').val('');
        bookingData.journey_type = journeyType;
    });

    $('#number_of_tickets').on('change', function () {
        ticketLimitExceeded = false; // Reset flag when number of tickets changes
    });

    $('#bookingFormElement').on('submit', function (e) {
        e.preventDefault();
        if (isSubmitting) return; // Prevent multiple submissions
        isSubmitting = true;
        console.log('Form submission triggered');

        const submitButton = $(this).find('input[type="submit"]');
        submitButton.prop('disabled', true);

        bookingData = {
            from: $('#from').val(),
            to: $('#to').val(),
            date: $('#date').val(),
            journey_type: $('#journey_type').val(),
            train_schedule_id: $('#train_schedule_id').val(),
            class: $('#class').val(),
            ticket_type: $('#ticket_type').val(),
            number_of_tickets: $('#number_of_tickets').val(),
            contact_no: $('#contact_no').val(),
            name: $('#name').val(),
            age: $('#age').val(),
            national_id: $('#national_id').val(),
            transaction_id: generateTransactionId(), // Assign transaction ID early
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        const selectedTrain = $('#train_schedule_id option:selected');
        bookingData.train_name = selectedTrain.data('trainName');
        bookingData.departure_time = selectedTrain.data('departureTime');
        bookingData.arrival_time = selectedTrain.data('arrivalTime');

        console.log('Form data:', bookingData);

        if (!bookingData.from || !bookingData.to || !bookingData.date || !bookingData.journey_type || 
            !bookingData.train_schedule_id || !bookingData.class || !bookingData.ticket_type || 
            !bookingData.number_of_tickets || !bookingData.contact_no || !bookingData.name || 
            !bookingData.age || !bookingData.national_id || 
            bookingData.from === '' || bookingData.to === '' || bookingData.train_schedule_id === '') {
            $('#alertPopup').css('display', 'block');
            isSubmitting = false;
            submitButton.prop('disabled', false);
            return;
        }

        if (bookingData.from === bookingData.to) {
            $('#alertPopup').css('display', 'block');
            $('#alertMessage').text('Departure and arrival stations cannot be the same.');
            isSubmitting = false;
            submitButton.prop('disabled', false);
            return;
        }

        // Check ticket limit after form submission
        $.ajax({
            type: 'POST',
            url: '{{ route("booking.check-ticket-limit") }}',
            data: {
                number_of_tickets: bookingData.number_of_tickets,
                date: bookingData.date,
                transaction_id: bookingData.transaction_id,
                _token: bookingData._token
            },
            success: function (limitResponse) {
                if (!limitResponse.success) {
                    $('#limitReason').text(limitResponse.message || 'You have exceeded the ticket limit of 4 for this date.');
                    $('#ticketLimitPopup').css('display', 'block');
                    ticketLimitExceeded = true;
                    isSubmitting = false;
                    submitButton.prop('disabled', false);
                    return;
                }

                ticketLimitExceeded = false;
                $('#selectedRoute').text(`${bookingData.from} to ${bookingData.to}`);
                fetchSeatAvailability();
                isSubmitting = false;
                submitButton.prop('disabled', false);
            },
            error: function (xhr) {
                console.error('AJAX error for ticket limit check:', xhr.status, xhr.responseText);
                $('#limitReason').text(xhr.responseJSON?.message || 'Error checking ticket limit.');
                $('#ticketLimitPopup').css('display', 'block');
                ticketLimitExceeded = true;
                isSubmitting = false;
                submitButton.prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.btn-book', function () {
        if (ticketLimitExceeded) {
            $('#ticketLimitPopup').css('display', 'block');
            return;
        }
        console.log('Book Now clicked');
        const classType = $(this).data('class');
        const availableSeats = $(this).data('seats');
        const price = $(this).data('price');
        const numberOfTickets = $('#number_of_tickets').val();

        console.log('Book Now data:', { classType, availableSeats, price, numberOfTickets });

        if (parseInt(availableSeats) < parseInt(numberOfTickets)) {
            $('#alertPopup').css('display', 'block');
            $('#alertMessage').text(`Not enough seats available! Requested: ${numberOfTickets}, Available: ${availableSeats}`);
            return;
        }

        bookingData.class = classType;
        bookingData.pricePerTicket = parseFloat(price);
        bookingData.amount = parseFloat(price) * parseInt(numberOfTickets);
        bookingData.selected_seats = [];
        bookingData.coach = null;

        console.log('Booking data for seat selection:', bookingData);

        $.ajax({
            type: 'POST',
            url: '{{ route("booking.get-seat-availability") }}',
            data: bookingData,
            success: function (response) {
                console.log('Seat selection response:', response);
                if (response.success && response.coaches) {
                    $('#seatAvailabilityPopup').css('display', 'none');
                    displayCoaches(response.coaches);
                    $('#seatSelectionPopup').css('display', 'block');
                    console.log('Seat selection popup displayed');
                } else {
                    $('#alertPopup').css('display', 'block');
                    $('#alertMessage').text(response.message || 'Failed to fetch coaches.');
                }
            },
            error: function (xhr) {
                console.error('AJAX error for seat selection:', xhr.status, xhr.responseText);
                $('#alertPopup').css('display', 'block');
                $('#alertMessage').text(xhr.responseJSON?.message || 'Error fetching coaches.');
            }
        });
    });

    function displayCoaches(coaches) {
        console.log('Displaying coaches:', coaches);
        const coachContainer = $('#coachContainer');
        coachContainer.empty();
        coaches.forEach((coach, index) => {
            const coachName = coach.coach_name;
            const totalSeats = coach.total_seats || 40;
            const availableSeats = coach.available_seats;
            if (availableSeats > 0) {
                const buttonHtml = `
                    <button class="coach-button" data-coach="${coachName}" data-index="${index}" data-total-seats="${totalSeats}">
                        <div class="text-xs text-center">${coachName} (${availableSeats}/${totalSeats} seats)</div>
                    </button>
                `;
                coachContainer.append(buttonHtml);
            }
        });

        $('.coach-button').off('click').on('click', function () {
            if (ticketLimitExceeded) {
                $('#ticketLimitPopup').css('display', 'block');
                return;
            }
            console.log('Coach button clicked');
            const coachName = $(this).data('coach');
            const totalSeats = $(this).data('totalSeats');
            bookingData.coach = coachName;
            bookingData.total_seats = totalSeats;
            fetchAndDisplaySeats(coachName, this);
        });
    }

    function fetchAndDisplaySeats(coachName, button) {
        console.log('Fetching seats for coach:', coachName);
        if (selectedCoachButton) $(selectedCoachButton).removeClass('selected');
        $(button).addClass('selected');
        selectedCoachButton = button;

        const seatContainer = $('#seat-container');
        seatContainer.empty().css({ 'display': 'flex', 'min-height': '180px' });
        selectedSeats = [];

        console.log('Booking data before AJAX:', bookingData);

        $.ajax({
            type: 'POST',
            url: '{{ route("seats.status") }}',
            data: {
                train_schedule_id: bookingData.train_schedule_id,
                coach_name: coachName,
                date: bookingData.date,
                from: bookingData.from,
                to: bookingData.to,
                _token: bookingData._token
            },
            success: function (seatResponse) {
                console.log('Seat status response:', seatResponse);
                renderSeats(seatResponse, coachName, button);
            },
            error: function (xhr) {
                console.error('AJAX error fetching seat status:', xhr.status, xhr.responseText);
                $('#alertPopup').css('display', 'block');
                $('#alertMessage').text(xhr.responseJSON?.message || 'Error fetching seat statuses.');
                renderFallbackSeats(coachName, button);
            }
        });
    }

    function renderSeats(seatResponse, coachName, button) {
        const seatContainer = $('#seat-container');
        const totalSeats = bookingData.total_seats || 40;
        const seatsPerRow = 14;

        console.log('Rendering seats, total seats:', totalSeats);

        if (seatResponse.success && seatResponse.seats && seatResponse.seats.length > 0) {
            const seats = seatResponse.seats.sort((a, b) => {
                const numA = parseInt(a.seat_number.split('-')[2] || 0);
                const numB = parseInt(b.seat_number.split('-')[2] || 0);
                return numA - numB;
            });

            for (let row = 0; row < Math.ceil(totalSeats / seatsPerRow); row++) {
                const rowDiv = $('<div>').addClass('flex justify-center items-center gap-3');
                for (let col = 0; col < seatsPerRow; col++) {
                    const seatNumber = row * seatsPerRow + col + 1;
                    if (seatNumber > totalSeats) break;
                    if (col === seatsPerRow / 2) rowDiv.append($('<div>').addClass('gap'));

                    const fullSeatName = `${coachName}-${seatNumber}`;
                    const seatStatus = seats.find(s => s.seat_number === fullSeatName)?.status || 'available';
                    const isBooked = seatStatus === 'booked';

                    console.log(`Rendering seat: ${fullSeatName}, Status: ${seatStatus}`);

                    const seat = $('<button>')
                        .html(`<i class="ph ph-chair"></i><span>${fullSeatName}</span>`)
                        .addClass('seat seat-dark-green-hover')
                        .addClass(isBooked ? 'booked' : 'available');

                    if (!isBooked) {
                        seat.on('click', function () { toggleSeat(this); });
                    } else {
                        seat.prop('disabled', true).css('pointer-events', 'none');
                    }

                    rowDiv.append(seat);
                }
                seatContainer.append(rowDiv);
            }
        } else {
            console.warn('No valid seat data, rendering fallback seats');
            renderFallbackSeats(coachName, button);
            $('#alertPopup').css('display', 'block');
            $('#alertMessage').text('No seat data available from server. Displaying default seat grid.');
        }

        const availableSeats = seatResponse.seats ? seatResponse.seats.filter(s => s.status === 'available').length : totalSeats;
        $(button).text(`${coachName} (${availableSeats}/${totalSeats} seats)`);
        updateCheckoutButton();
    }

    function renderFallbackSeats(coachName, button) {
        const seatContainer = $('#seat-container');
        const totalSeats = bookingData.total_seats || 40;
        const seatsPerRow = 14;

        console.log('Rendering fallback seats, total seats:', totalSeats);

        for (let row = 0; row < Math.ceil(totalSeats / seatsPerRow); row++) {
            const rowDiv = $('<div>').addClass('flex justify-center items-center gap-3');
            for (let col = 0; col < seatsPerRow; col++) {
                const seatNumber = row * seatsPerRow + col + 1;
                if (seatNumber > totalSeats) break;
                if (col === seatsPerRow / 2) rowDiv.append($('<div>').addClass('gap'));

                const fullSeatName = `${coachName}-${seatNumber}`;
                const seat = $('<button>')
                    .html(`<i class="ph ph-chair"></i><span>${fullSeatName}</span>`)
                    .addClass('seat seat-dark-green-hover available')
                    .on('click', function () { toggleSeat(this); });

                rowDiv.append(seat);
            }
            seatContainer.append(rowDiv);
        }

        $(button).text(`${coachName} (${totalSeats}/${totalSeats} seats)`);
        updateCheckoutButton();
    }

    function toggleSeat(seat) {
        if (ticketLimitExceeded) {
            $('#ticketLimitPopup').css('display', 'block');
            return;
        }
        console.log('Toggle seat clicked');
        const $seat = $(seat);
        const seatNumber = $seat.find('span').text();

        if ($seat.hasClass('available')) {
            if (selectedSeats.length >= parseInt(bookingData.number_of_tickets)) {
                $('#alertPopup').css('display', 'block');
                $('#alertMessage').text(`You can only select ${bookingData.number_of_tickets} seat(s).`);
                return;
            }
            $seat.removeClass('available').addClass('selected seat-dark-green-selected');
            selectedSeats.push(seatNumber);
        } else if ($seat.hasClass('selected')) {
            $seat.removeClass('selected seat-dark-green-selected').addClass('available');
            selectedSeats = selectedSeats.filter(s => s !== seatNumber);
        }
        $('#selected_seats').val(JSON.stringify(selectedSeats));
        updateCheckoutButton();
    }

    function updateCheckoutButton() {
        console.log('Updating checkout button, selected seats:', selectedSeats.length);
        $('.button-container').toggle(selectedSeats.length > 0);
        $('#checkout-button').prop('disabled', selectedSeats.length !== parseInt(bookingData.number_of_tickets));
    }

    $('#checkout-button').on('click', function () {
        if (ticketLimitExceeded) {
            $('#ticketLimitPopup').css('display', 'block');
            return;
        }
        console.log('Checkout button clicked');
        if (!bookingData.coach) {
            $('#alertPopup').css('display', 'block');
            $('#alertMessage').text('Please select a coach before proceeding.');
            return;
        }
        if (selectedSeats.length !== parseInt(bookingData.number_of_tickets)) {
            $('#alertPopup').css('display', 'block');
            $('#alertMessage').text(`Please select exactly ${bookingData.number_of_tickets} seat(s). Currently selected: ${selectedSeats.length}`);
            return;
        }
        bookingData.selected_seats = selectedSeats;
        $('#coach').val(bookingData.coach);
        $('#selected_seats').val(JSON.stringify(bookingData.selected_seats));
        showPaymentConfirmation();
    });

    $('#verifyOtpBtn').on('click', function () {
        if (ticketLimitExceeded) {
            $('#ticketLimitPopup').css('display', 'block');
            return;
        }
        console.log('Verify OTP clicked');
        const enteredOtp = $('#otpInput').val().trim();
        const messageEl = $('#otpMessage');

        if (!enteredOtp || enteredOtp.length !== 6) {
            messageEl.text('Please enter a 6-digit OTP').addClass('text-red-600').removeClass('text-green-600');
            return;
        }

        if (enteredOtp === generatedOtp) {
            messageEl.text('OTP Verified Successfully!').addClass('text-green-600').removeClass('text-red-600');
            $('#confirmPaymentBtn').prop('disabled', false);
        } else {
            messageEl.text('Invalid OTP. Please try again.').addClass('text-red-600').removeClass('text-green-600');
        }
    });

    // Debounce function to prevent multiple rapid clicks
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    $('#confirmPaymentBtn').on('click', debounce(function () {
        if (ticketLimitExceeded) {
            $('#ticketLimitPopup').css('display', 'block');
            return;
        }
        if (isSubmitting) return; // Prevent multiple submissions
        isSubmitting = true;
        console.log('Confirm Payment clicked');
        const $this = $(this);
        $this.prop('disabled', true); // Disable button immediately

        if (!bookingData.selected_seats || bookingData.selected_seats.length === 0) {
            console.error('Selected seats missing or empty!');
            $('#alertPopup').css('display', 'block');
            $('#alertMessage').text('Please select seats before proceeding.');
            isSubmitting = false;
            $this.prop('disabled', false);
            return;
        }

        // Ensure transaction_id is included
        if (!bookingData.transaction_id) {
            bookingData.transaction_id = generateTransactionId();
        }
        console.log('Initiating booking with bookingData:', bookingData);

        $.ajax({
            type: 'POST',
            url: '{{ route("booking.store") }}',
            data: bookingData,
            success: function (response) {
                console.log('Booking store response:', response);
                if (response.success) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("payment.initiate") }}',
                        data: JSON.stringify(bookingData),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (paymentResponse) {
                            console.log('Payment initiation response:', paymentResponse);
                            if (paymentResponse.success && paymentResponse.url) {
                                console.log('Redirecting to:', paymentResponse.url);
                                // Clear bookingData to prevent resubmission
                                bookingData = { _token: $('meta[name="csrf-token"]').attr('content') };
                                selectedSeats = [];
                                $('#selected_seats').val('[]');
                                $('#coach').val('');
                                window.location.href = paymentResponse.url;
                            } else {
                                $('#failReason').text(paymentResponse.message || 'Failed to initiate payment.');
                                $('#transactionFailPopup').css('display', 'block');
                                isSubmitting = false;
                                $this.prop('disabled', false);
                            }
                        },
                        error: function (xhr) {
                            console.error('Error initiating payment:', xhr.status, xhr.responseText);
                            handlePaymentError(xhr);
                            isSubmitting = false;
                            $this.prop('disabled', false);
                        }
                    });
                } else {
                    $('#failReason').text(response.message || 'Failed to create booking.');
                    $('#transactionFailPopup').css('display', 'block');
                    isSubmitting = false;
                    $this.prop('disabled', false);
                }
            },
            error: function (xhr) {
                console.error('Error storing booking:', xhr.status, xhr.responseText);
                handlePaymentError(xhr);
                isSubmitting = false;
                $this.prop('disabled', false);
            }
        });
    }, 500)); // Increased debounce time to 500ms for reliability

    function handlePaymentError(xhr) {
        if (xhr.status === 403) {
            $('#limitReason').text(xhr.responseJSON?.message || 'You have exceeded the ticket limit of 4 for this date.');
            $('#ticketLimitPopup').css('display', 'block');
            ticketLimitExceeded = true;
        } else if (xhr.status === 401) {
            window.location.href = '/login';
        } else {
            $('#failReason').text(xhr.responseJSON?.message || 'Error processing booking.');
            $('#transactionFailPopup').css('display', 'block');
        }
    }

    function cancelSelection() {
        console.log('Cancel selection clicked');
        $('#seat-container').empty();
        selectedSeats = [];
        if (selectedCoachButton) $(selectedCoachButton).removeClass('selected');
        selectedCoachButton = null;
        bookingData.coach = null;
        bookingData.selected_seats = [];
        $('#selected_seats').val('[]');
        $('#coach').val('');
        updateCheckoutButton();
        $('#seatSelectionPopup').css('display', 'none');
        fetchSeatAvailability();
    }

    $('#cancel-button').on('click', cancelSelection);

    $(document).on('click', '.close', function () {
        console.log('Close seat availability popup clicked');
        $('#seatAvailabilityPopup').css('display', 'none');
    });

    $(document).on('click', '.close-seat-selection', function () {
        console.log('Close seat selection popup clicked');
        cancelSelection();
    });

    $(document).on('click', '.close-payment', function () {
        console.log('Close payment confirmation popup clicked');
        $('#paymentConfirmationPopup').css('display', 'none');
        $('#seatSelectionPopup').css('display', 'block');
        generatedOtp = null;
        $('#otpInput').val('');
        $('#otpMessage').text('').removeClass('text-green-600 text-red-600');
        $('#confirmPaymentBtn').prop('disabled', true);
    });

    $('#closeSuccessBtnBottom').on('click', function () {
        console.log('Close success popup clicked');
        $('#transactionSuccessPopup').css('display', 'none');
        fetchSeatAvailability();
    });

    $('#closeFailBtn').on('click', function () {
        console.log('Close fail popup clicked');
        $('#transactionFailPopup').css('display', 'block');
        fetchSeatAvailability();
    });

    $('#closeCancelBtn').on('click', function () {
        console.log('Close cancel popup clicked');
        $('#transactionCancelPopup').css('display', 'none');
        fetchSeatAvailability();
    });

    $('#closeLimitBtn').on('click', function () {
        console.log('Close limit popup clicked');
        $('#ticketLimitPopup').css('animation', 'fadeOut 0.3s ease-in-out');
        setTimeout(() => {
            $('#ticketLimitPopup').css({
                'display': 'none',
                'animation': 'fadeIn 0.3s ease-in-out'
            });
            ticketLimitExceeded = false;
        }, 300);
    });

    $('#closeAlertBtn').on('click', function () {
        console.log('Close alert popup clicked');
        $('#alertPopup').css('display', 'none');
    });

    function showPaymentConfirmation() {
        console.log('Showing payment confirmation');
        if (!bookingData || !bookingData.selected_seats || bookingData.selected_seats.length === 0) {
            $('#alertPopup').css('display', 'block');
            $('#alertMessage').text('Booking data is missing or no seats selected. Please try again.');
            return;
        }

        const totalAmount = parseFloat(bookingData.pricePerTicket) * parseInt(bookingData.number_of_tickets);

        $('#payName').text(bookingData.name);
        $('#payContact').text(bookingData.contact_no);
        $('#payFrom').text(bookingData.from);
        $('#payTo').text(bookingData.to);
        $('#payTrainName').text(bookingData.train_name);
        $('#payDate').text(bookingData.date);
        $('#payDep').text(bookingData.departure_time);
        $('#payArr').text(bookingData.arrival_time);
        $('#payClass').text(bookingData.class);
        $('#payTickets').text(bookingData.number_of_tickets);
        $('#payTicketType').text(bookingData.ticket_type);
        $('#paySeats').text(bookingData.selected_seats.join(', '));
        $('#payCoach').text(bookingData.coach || 'Not selected');
        $('#payTotal').text(`৳${totalAmount.toFixed(2)}`);

        $('#otpInput').val('');
        $('#otpMessage').text('Requesting OTP...').removeClass('text-green-600 text-red-600').addClass('text-gray-600');
        $('#confirmPaymentBtn').prop('disabled', true);

        $.ajax({
            type: 'GET',
            url: '{{ route("booking.get-user-email") }}',
            success: function (response) {
                console.log('Get user email response:', response);
                if (response.success && response.email) {
                    bookingData.email = response.email;
                    $('#payEmail').text(bookingData.email);

                    generatedOtp = Math.floor(100000 + Math.random() * 900000).toString();
                    console.log('Generated OTP:', generatedOtp);

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("booking.send-otp") }}',
                        data: {
                            otp: generatedOtp,
                            _token: bookingData._token
                        },
                        success: function (otpResponse) {
                            console.log('Send OTP response:', otpResponse);
                            if (otpResponse.success) {
                                $('#otpMessage').text(`A 6-digit OTP has been sent to ${bookingData.email}. Please check your inbox or spam folder.`).removeClass('text-red-600').addClass('text-gray-600');
                            } else {
                                $('#otpMessage').text(otpResponse.message || 'Failed to send OTP. Please try again.').addClass('text-red-600').removeClass('text-gray-600');
                            }
                        },
                        error: function (xhr) {
                            console.error('Error sending OTP:', xhr.status, xhr.responseText);
                            $('#otpMessage').text(xhr.responseJSON?.message || 'Error sending OTP. Please try again.').addClass('text-red-600').removeClass('text-gray-600');
                        }
                    });
                } else {
                    $('#payEmail').text('Not available');
                    $('#otpMessage').text(response.message || 'Unable to fetch email. Please ensure you are logged in.').addClass('text-red-600').removeClass('text-gray-600');
                }
            },
            error: function (xhr) {
                console.error('Error fetching user email:', xhr.status, xhr.responseText);
                $('#payEmail').text('Not available');
                $('#otpMessage').text(xhr.responseJSON?.message || 'Error fetching email. Please ensure you are logged in.').addClass('text-red-600').removeClass('text-gray-600');
            }
        });

        $('#seatSelectionPopup').css('display', 'none');
        $('#paymentConfirmationPopup').css('display', 'block');
        console.log('Payment confirmation popup displayed');
    }

    function checkPaymentStatus() {
        if (window.location.pathname !== '/booking') return;
        console.log('Checking payment status');
        const urlParams = new URLSearchParams(window.location.search);
        const tranId = urlParams.get('tranId');
        const status = urlParams.get('status');
        const totalAmount = urlParams.get('total_amount');

        if (status === 'success' && tranId && totalAmount) {
            $('#transactionId').text(tranId);
            $('#transactionTotal').text(`৳${totalAmount}`);
            $('#transactionSuccessPopup').css('display', 'block');
        } else if (status === 'fail' && tranId) {
            $('#failReason').text('Payment Failed for Transaction ID: ' + tranId);
            $('#transactionFailPopup').css('display', 'block');
        } else if (status === 'cancel' && tranId) {
            $('#transactionCancelPopup').css('display', 'block');
        }
    }

    checkPaymentStatus();
});
    </script>
</body>
</html>