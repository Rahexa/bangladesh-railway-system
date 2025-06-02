<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Ticket Booking</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
            background-color: #f4f4f4; /* Light gray background */
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .train-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .train-name {
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .route {
            font-size: 1.2em;
            color: #555; /* Darker gray for less important info */
            margin-bottom: 10px;
        }

        .departure, .arrival {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px; /* Reduced margin */
        }

        .class-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive grid */
            gap: 20px;
        }

        .class-card {
            border: 1px solid #ddd; /* Light border */
            padding: 15px;
            border-radius: 8px;
            box-sizing: border-box; /* Include padding in width */
            transition: transform 0.2s ease-in-out; /* Smooth hover effect */
        }
        .class-card:hover {
            transform: scale(1.02); /* Slightly enlarge on hover */
        }


        .class-name {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .fare {
            font-size: 1.1em;
            color: #007bff; /* Blue for price */
            margin-bottom: 10px;
        }

        .availability {
            color: #555;
            margin-bottom: 10px;
        }

        .book-button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s; /* Smooth hover effect */
        }
        .book-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* Responsive adjustments */
        @media (max-width: 500px) {
            .class-options {
                grid-template-columns: 1fr; /* Single column on small screens */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="train-info">
            <div class="train-name">HANALATA EXPRESS (791)</div>
            <div class="route">Dhaka to Rajshahi</div>
            <div class="departure"><span>03 Apr, 01:30 PM</span></div>
            <div class="arrival"><span>05 Apr, 04:35 PM</span></div>
        </div>

        <div class="class-options">
            <div class="class-card">
                <div class="class-name">Economy Seat</div>
                <div class="fare">BDT 340</div>
                <div class="availability">131 Seats Available</div>
                <button class="book-button">Book Now</button>
            </div>
            <div class="class-card">
                <div class="class-name">Comfort Seat</div>
                <div class="fare">BDT 656</div>
                <div class="availability">187 Seats Available</div>
                <button class="book-button">Book Now</button>
            </div>
            <div class="class-card">
                <div class="class-name">AC Cabin</div>
                <div class="fare">BDT 782</div>
                <div class="availability">36 Seats Available</div>
                <button class="book-button">Book Now</button>
            </div>

             <div class="class-card">
                <div class="class-name">Economy Seat</div>
                <div class="fare">BDT 375</div>
                <div class="availability">406 Seats Available</div>
                <button class="book-button">Book Now</button>
            </div>
            <div class="class-card">
                <div class="class-name">Comfort Seat</div>
                <div class="fare">BDT 725</div>
                <div class="availability">210 Seats Available</div>
                <button class="book-button">Book Now</button>
            </div>
            <div class="class-card">
                <div class="class-name">AC Cabin</div>
                <div class="fare">BDT 865</div>
                <div class="availability">20 Seats Available</div>
                <button class="book-button">Book Now</button>
            </div>
        </div>
    </div>
</body>
</html>