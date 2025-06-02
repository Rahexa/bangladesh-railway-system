<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bangladesh Railway Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #F0F2F5;
            font-family: 'Roboto Condensed', sans-serif;
            padding: 20px;
            min-height: 100vh;
            margin: 0;
            position: relative; /* Add this for proper positioning of fixed button */
            padding-bottom: 80px; /* Add padding to prevent button from overlapping content */
        }
        .tickets-wrapper {
            max-width: 1650px;
            margin: 0 auto;
        }
        .ticket-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .ticket-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .ticket-container {
            width: 800px;
            height: 325px;
            background: url('{{ asset('image/mwater.png') }}') no-repeat center;
            background-size: 80%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            border-radius: 10px;
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
        .left, .right {
            margin: 0;
            padding: 0;
            list-style: none;
            position: absolute;
            top: 0;
            font-size: 12px;
            line-height: 16px;
            color: #FFFFFF;
            z-index: 3;
        }
        .left { left: -12px; }
        .right { right: -12px; }
        .left li, .right li {
            width: 12px;
            height: 16px;
            text-align: center;
            background: #009B4E;
        }
        .main-section, .slip-section {
            height: 100%;
            padding: 15px;
            position: relative;
            z-index: 3;
            background: transparent;
        }
        .header {
            background: #009B4E;
            padding: 8px 15px;
            color: #FFFFFF;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 5px 5px 0 0;
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
            z-index: 5;
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
        }
        .tear-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 6;
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
            z-index: 7;
        }
        .no-booking {
            text-align: center;
            font-size: 18px;
            color: #555;
            margin-top: 20px;
        }
        .no-booking a {
            color: #009B4E;
            text-decoration: none;
            font-weight: 600;
        }
        .no-booking a:hover {
            text-decoration: underline;
        }
        .ticket-placeholder {
            width: 800px;
            height: 325px;
            background: #E8ECEF;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .download-btn {
            margin-top: 10px;
            padding: 8px 20px;
            background: linear-gradient(135deg, #009B4E, #34d399);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }
        .download-btn:hover {
            background: linear-gradient(135deg, #34d399, #009B4E);
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .back-dashboard-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 25px;
            background: linear-gradient(135deg, #009B4E, #34d399);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            z-index: 1000;
        }
        .back-dashboard-btn:hover {
            background: linear-gradient(135deg, #34d399, #009B4E);
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            color: #FFFFFF;
        }
    </style>
    <script>
        function downloadTicket(ticketId) {
            var ticketElement = document.getElementById(ticketId);
            if (!ticketElement) {
                alert('Ticket not found. Please try again.');
                return;
            }
            var ticketHtml = ticketElement.outerHTML;
            var printWindow = window.open('', '_blank', 'width=800,height=325');
            if (!printWindow) {
                alert('Please allow popups for this site to download the ticket.');
                return;
            }
            printWindow.document.write('<!DOCTYPE html><html><head><title>Ticket Download</title>');
            printWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">');
            printWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">');
            printWindow.document.write('<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">');
            printWindow.document.write('<style>' + document.querySelector('style').innerHTML + ' body { margin: 0; padding: 0; } .ticket-container { margin: 0 auto; }</style>');
            printWindow.document.write('</head><body>' + ticketHtml);
            printWindow.document.write('<script>window.onload = function() { setTimeout(() => window.print(), 500); }</script>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
        }
    </script>
</head>
<body>
    <div class="tickets-wrapper">
        @if (isset($message))
            <div class="no-booking">
                {{ $message }} <br>
                <a href="{{ route('booking') }}">Book a ticket now</a>
            </div>
        @else
            <div class="ticket-grid">
                @for ($i = 0; $i < 4; $i++)
                    @if (isset($bookings[$i]))
                        <div class="ticket-item">
                            <div class="ticket-container card" id="ticket-{{ $bookings[$i]->id }}">
                                <!-- Ticket Design Here (Omitted for brevity) -->
                            </div>
                            <button class="download-btn" onclick="downloadTicket('ticket-{{ $bookings[$i]->id }}')">
                                <i class="bi bi-download me-2"></i>Download Ticket
                            </button>
                        </div>
                    @else
                        <div class="ticket-placeholder">
                            No Ticket Available
                        </div>
                    @endif
                @endfor
            </div>
        @endif
    </div>

    <!-- Fixed Back to Dashboard Button -->
    <a href="{{ route('dashboard') }}" class="back-dashboard-btn">
        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>