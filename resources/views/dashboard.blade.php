<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bangladesh Railway</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e8ecef;
            line-height: 1.6;
            color: #2d3748;
        }
        header {
            background: linear-gradient(135deg, rgba(92, 106, 151, 0.95), #393b65 50%, #5c6a97),
                        url('https://st4.depositphotos.com/3570295/20491/i/450/depositphotos_204913566-stock-photo-moving-train-track-double-exposure.jpg');
            background-size: cover;
            background-position: center;
            height: 21vh;
            padding: 20px;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            position: relative;
        }
        header h1 {
            font-size: 3rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #b3e5fc;
            animation: fadeIn 1.2s ease-in-out;
        }
        nav {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 15px;
        }
        nav a {
            text-decoration: none;
            color: #fff;
            font-weight: 600;
            padding: 10px 22px;
            background: linear-gradient(135deg, #4c51bf, #667eea);
            border-radius: 12px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }
        nav a:hover {
            background: linear-gradient(135deg, #ed8936, #f6ad55);
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .hero-image {
            width: 100%;
            max-height: 650px;
            object-fit: cover;
            filter: brightness(85%);
            transition: transform 0.4s ease;
        }
        .hero-image:hover {
            transform: scale(1.015);
        }
        .news-ticker-container {
            background-color: rgba(57, 59, 101, 0.9);
            color: #34d399;
            padding: 10px;
            position: absolute;
            top: 22vh;
            left: 0;
            right: 0;
            z-index: 10;
            font-weight: 500;
            overflow: hidden;
            white-space: nowrap;
            animation: ticker-scroll 20s linear infinite;
        }
        @keyframes ticker-scroll {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .menu-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            cursor: pointer;
            z-index: 1000;
        }
        .menu-icon div {
            width: 30px;
            height: 3px;
            background-color: #fff;
            margin: 6px 0;
            transition: all 0.3s ease;
        }
        .dropdown-menu {
            display: none;
            position: fixed;
            top: 70px;
            right: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 220px;
            z-index: 1000;
            animation: fadeIn 0.25s ease-out;
            overflow: hidden;
        }
        .dropdown-menu.show {
            display: block;
        }
        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            color: #2d3748;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s ease;
        }
        .dropdown-menu a:hover {
            background-color: #f0f4f8;
        }
        .dropdown-menu i {
            font-size: 18px;
            color: #4c51bf;
        }
        #clock {
            position: absolute;
            top: 20px;
            right: 140px;
            font-size: 1.4rem;
            font-weight: 500;
            color: #fff;
        }
        #bookingInstructions {
            position: absolute;
            top: 55%;
            right: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            padding: 12px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            transform: translateY(-50%);
            animation: fadeIn 1s ease;
            border: 1px solid rgba(92, 106, 151, 0.2);
        }
        #bookingInstructions h2 {
            font-size: 1.4rem;
            color: #393b65;
            margin-bottom: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        #bookingInstructions .instructions-list {
            display: none;
            font-size: 0.95rem;
            color: #4a5568;
            line-height: 1.3;
        }
        #bookingInstructions .instructions-list.show {
            display: block;
        }
        #bookingInstructions p {
            margin-bottom: 4px;
        }
        .cute-btn {
            background: linear-gradient(135deg, #4c51bf, #667eea);
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }
        .cute-btn:hover {
            background: linear-gradient(135deg, #ed8936, #f6ad55);
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .cute-btn i {
            color: #fff;
            font-size: 14px;
        }
        @media (max-width: 768px) {
            header { height: 30vh; }
            header h1 { font-size: 2rem; }
            nav { flex-direction: column; gap: 8px; padding: 10px; }
            nav a { width: 100%; text-align: center; }
            #bookingInstructions { position: static; margin: 20px auto; max-width: 90%; transform: none; }
            #clock { font-size: 1.1rem; right: 90px; }
            .news-ticker-container { top: 25vh; }
        }
    </style>
</head>
<body>
    <header>
        <h1>Bangladesh Railway</h1>
        <div id="clock"></div>
        <div class="menu-icon" onclick="toggleMenu();">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <nav>
            <a href="{{ route('dashboard') }}">Home</a>
            <a href="javascript:void(0);" onclick="showBookingForm()">Booking</a>
            <a href="{{ route('seat.availability') }}">Seats Availability</a>
            <a href="{{ url('/trainlist') }}">Train List</a>
            <a href="{{ url('/tracking') }}">Train Route Tracking</a>
            <a href="{{ route('tickets') }}">My Booking</a>
            <a href="{{ route('about-us') }}">About Us</a>
            <a href="https://www.google.com.bd/maps/search/bangladesh+all+rail+station/@23.5033387,90.50561,7z?entry=ttu" target="_blank">Map</a>
        </nav>
    </header>
    <div class="news-ticker-container">
        <div class="news-item">🚂 <b>Welcome to Bangladesh Railway *** The iconic 'Padma Express' will arrive at Dhaka Station at 10:45 AM and depart at 11:15 AM! Plan your journey accordingly! 🚆</b></div>
    </div>
    <img src="https://dhz-coxb-railway.com/wp-content/uploads/2021/05/Picture25.jpg" alt="Bangladesh Railway Train" class="hero-image">
    <div id="bookingInstructions">
        <h2>
            Booking Instructions
            <button class="cute-btn" onclick="toggleInstructions()">
                <i class="bi bi-info-circle"></i>
            </button>
        </h2>
        <div class="instructions-list" id="instructionsList">
            <p>1. Fill out the form with your details.</p>
            <p>2. Select your departure and destination stations.</p>
            <p>3. Choose the date of your journey.</p>
            <p>4. Select the class and ticket type.</p>
            <p>5. Choose your payment method and proceed with payment.</p>
            <p>6. If applicable, enter the transaction ID.</p>
            <p>7. Click "Submit" to confirm your booking.</p>
        </div>
    </div>
    <div id="bookingFormContainer" style="display: none;">
        @include('bookingform')
    </div>
    <div class="dropdown-menu" id="dropdownMenu">
        <a href="{{ route('profile') }}">
            <i class="bi bi-person-circle"></i> My Account
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours() % 12 || 12).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const period = now.getHours() < 12 ? 'AM' : 'PM';
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds} ${period}`;
            setTimeout(updateClock, 1000);
        }
        updateClock();
        function toggleMenu() {
            document.getElementById('dropdownMenu').classList.toggle('show');
        }
        function showBookingForm() {
            const bookingFormContainer = document.getElementById('bookingFormContainer');
            bookingFormContainer.style.display = bookingFormContainer.style.display === 'block' ? 'none' : 'block';
        }
        function toggleInstructions() {
            const instructionsList = document.getElementById('instructionsList');
            instructionsList.classList.toggle('show');
        }
        document.addEventListener('click', function (event) {
            const menu = document.getElementById('dropdownMenu');
            const icon = document.querySelector('.menu-icon');
            if (!menu.contains(event.target) && !icon.contains(event.target)) {
                menu.classList.remove('show');
            }
        });
    </script>
</body>
</html>