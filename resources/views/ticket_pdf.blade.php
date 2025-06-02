<!-- resources/views/ticket_pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket {{ $booking->transaction_id }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto Condensed', sans-serif;
        }
        .ticket-container {
            width: 800px;
            height: 325px;
            background: url('{{ public_path('image/mwater.png') }}') no-repeat center;
            background-size: 80%;
            position: relative;
        }
        .ticket-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1;
        }
        .main-section, .slip-section {
            height: 100%;
            padding: 15px;
            position: relative;
            z-index: 3;
        }
        .header {
            background: #009B4E;
            padding: 8px 15px;
            color: #FFFFFF;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            font-weight: 700;
        }
        .route-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            margin-top: 10px;
        }
        .station {
            font-size: 20px;
            font-weight: 700;
            color: #111;
            text-transform: uppercase;
        }
        .train-icon {
            font-size: 28px;
            color: #009B4E;
        }
        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: 15px;
            font-size: 11px;
        }
        .label {
            font-size: 12px;
            font-weight: 400;
            color: #777;
            text-transform: uppercase;
        }
        .value {
            font-size: 15px;
            font-weight: 700;
            color: #222;
            margin-top: 3px;
            word-wrap: break-word;
        }
        .slip-header {
            font-size: 14px;
            font-weight: 700;
            color: #009B4E;
            text-align: center;
            margin-bottom: 10px;
        }
        .slip-route {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .slip-station {
            font-size: 16px;
            font-weight: 700;
            color: #111;
        }
        .barcode-main, .barcode-slip {
            height: 25px;
            width: 100px;
            background: repeating-linear-gradient(
                90deg,
                #000000 0px, #000000 2px,
                transparent 2px, transparent 4px
            );
            border-radius: 3px;
            position: absolute;
            bottom: 15px;
        }
        .barcode-main { left: 15px; }
        .barcode-slip { right: 15px; }
        .tear-effect {
            position: absolute;
            top: 0;
            left: calc(66.67% - 6px);
            width: 8px;
            height: 100%;
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
        }
        .tear-effect::after {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 2px;
            height: 100%;
            background: repeating-linear-gradient(
                to bottom,
                #CCCCCC 0px,
                #CCCCCC 4px,
                transparent 4px,
                transparent 8px
            );
            transform: translateX(-50%);
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div style="display: flex; height: 100%;">
            <div style="width: 66.67%;" class="main-section">
                <div class="header">
                    <span class="header-title">Bangladesh Railway Passenger Ticket</span>
                </div>
                <div class="route-info">
                    <span class="station">{{ $booking->from }}</span>
                    <span class="train-icon">🚂</span>
                    <span class="station">{{ $booking->to }}</span>
                </div>
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="label">Ticket No.</span>
                        <span class="value">{{ $booking->transaction_id }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Passenger</span>
                        <span class="value">{{ $booking->name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">National ID</span>
                        <span class="value">{{ $booking->national_id }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Journey Type</span>
                        <span class="value">{{ ucfirst($booking->journey_type) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Coach</span>
                        <span class="value">{{ $booking->coach ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Class</span>
                        <span class="value">{{ $booking->class }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Seat No.</span>
                        <span class="value">{{ implode(', ', json_decode($booking->selected_seats)) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Departure</span>
                        <span class="value">{{ $booking->departure_time }}, {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Issue Date/Time</span>
                        <span class="value">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, h:i A') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Total Amount</span>
                        <span class="value">{{ $booking->total_amount }}</span>
                    </div>
                </div>
                <div class="barcode-main"></div>
            </div>
            <div class="tear-effect"></div>
            <div style="width: 33.33%;" class="slip-section">
                <div class="slip-header">Passenger Copy</div>
                <div class="slip-route">
                    <span class="slip-station">{{ $booking->from }}</span>
                    <span class="slip-station">{{ $booking->to }}</span>
                </div>
                <div class="slip-details">
                    <div class="detail-item">
                        <span class="label">Ticket No.</span>
                        <span class="value">{{ $booking->transaction_id }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Passenger</span>
                        <span class="value">{{ $booking->name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Contact</span>
                        <span class="value">{{ $booking->contact_no }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Coach/Seat</span>
                        <span class="value">{{ $booking->coach ?? 'N/A' }}/{{ implode(', ', json_decode($booking->selected_seats)) }}</span>
                    </div>
                </div>
                <div class="barcode-slip"></div>
            </div>
        </div>
    </div>
</body>
</html>