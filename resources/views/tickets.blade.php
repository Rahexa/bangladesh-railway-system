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
            padding: 30px;
            min-height: 100vh;
            margin: 0;
        }
        .tickets-wrapper {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .ticket-grid {
            display: flex;
            flex-direction: column;
            gap: 30px;
            align-items: center;
        }
        .ticket-item {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .ticket-container {
            width: 600px;
            height: 250px;
            background: url('{{ asset('image/mwater.png') }}') no-repeat center;
            background-size: 60%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
            position: relative;
            border-radius: 8px;
            overflow: hidden;
        }
        .ticket-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            z-index: 1;
        }
        .left, .right {
            margin: 0;
            padding: 0;
            list-style: none;
            position: absolute;
            top: 0;
            font-size: 10px;
            line-height: 14px;
            color: #FFFFFF;
            z-index: 3;
        }
        .left { left: -10px; }
        .right { right: -10px; }
        .left li, .right li {
            width: 10px;
            height: 14px;
            text-align: center;
            background: #009B4E;
        }
        .main-section, .slip-section {
            height: 100%;
            padding: 10px;
            position: relative;
            z-index: 3;
            background: transparent;
        }
        .header {
            background: #009B4E;
            padding: 6px 12px;
            color: #FFFFFF;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 5px 5px 0 0;
            font-size: 13px;
            font-weight: 700;
        }
        .route-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
            margin-top: 8px;
        }
        .station {
            font-size: 18px;
            font-weight: 700;
            color: #111;
            text-transform: uppercase;
        }
        .train-icon {
            font-size: 24px;
            color: #009B4E;
        }
        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px;
            margin-top: 10px;
            font-size: 10px;
        }
        .label {
            font-size: 11px;
            font-weight: 400;
            color: #777;
            text-transform: uppercase;
        }
        .value {
            font-size: 13px;
            font-weight: 700;
            color: #222;
            margin-top: 2px;
            word-wrap: break-word;
        }
        .slip-header {
            font-size: 13px;
            font-weight: 700;
            color: #009B4E;
            text-align: center;
            margin-bottom: 8px;
        }
        .slip-route {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .slip-station {
            font-size: 14px;
            font-weight: 700;
            color: #111;
        }
        .barcode-main, .barcode-slip {
            height: 20px;
            width: 80px;
            background: repeating-linear-gradient(
                90deg,
                #000000 0px, #000000 2px,
                transparent 2px, transparent 4px
            );
            border-radius: 2px;
            position: absolute;
            bottom: 10px;
        }
        .barcode-main { left: 10px; }
        .barcode-slip { right: 10px; }
        .tear-effect {
            position: absolute;
            top: 0;
            left: calc(66.67% - 5px);
            width: 6px;
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
            width: 1px;
            height: 100%;
            background: repeating-linear-gradient(
                to bottom,
                #CCCCCC 0px,
                #CCCCCC 3px,
                transparent 3px,
                transparent 6px
            );
            transform: translateX(-50%);
            z-index: 7;
        }
        .no-booking {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            font-size: 16px;
            color: #555;
            margin-top: 30px;
            height: 80vh;
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
            width: 600px;
            height: 250px;
            background: #E8ECEF;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .download-btn {
            margin-top: 10px;
            padding: 6px 18px;
            background: linear-gradient(135deg, #009B4E, #34d399);
            color: #FFFFFF;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .download-btn:hover {
            background: linear-gradient(135deg, #34d399, #009B4E);
            transform: scale(1.03);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }
        .back-dashboard-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 6px 18px;
            background: linear-gradient(135deg, #009B4E, #34d399);
            color: #FFFFFF;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            z-index: 1000;
        }
        .back-dashboard-btn:hover {
            background: linear-gradient(135deg, #34d399, #009B4E);
            transform: scale(1.03);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
            color: #FFFFFF;
        }
        @media (max-width: 768px) {
            .tickets-wrapper {
                padding: 15px;
            }
            .ticket-container, .ticket-placeholder {
                width: 100%;
                height: 220px;
            }
            .station, .slip-station {
                font-size: 14px;
            }
            .train-icon {
                font-size: 20px;
            }
            .details-grid {
                font-size: 9px;
            }
            .label {
                font-size: 10px;
            }
            .value {
                font-size: 12px;
            }
            .barcode-main, .barcode-slip {
                height: 18px;
                width: 70px;
            }
        }
    </style>
</head>
<body>
    <div class="tickets-wrapper">
        @if (isset($message))
            <div class="no-booking">
                {{ $message }} <br>
                <a href="{{ route('dashboard') }}">Book a ticket now</a>
            </div>
        @else
            <div class="ticket-grid">
                @for ($i = 0; $i < 6; $i++)
                    @if (isset($bookings[$i]))
                        <div class="ticket-item">
                            <div class="ticket-container card" id="ticket-{{ $bookings[$i]->id }}">
                                <ul class="left">
                                    <li><</li><li><</li><li><</li><li><</li><li><</li>
                                    <li><</li><li><</li><li><</li><li><</li><li><</li>
                                    <li><</li><li><</li>
                                </ul>
                                <ul class="right">
                                    <li>></li><li>></li><li>></li><li>></li><li>></li>
                                    <li>></li><li>></li><li>></li><li>></li><li>></li>
                                    <li>></li><li>></li>
                                </ul>
                                <div class="row g-0 h-100">
                                    <div class="col-8 main-section">
                                        <div class="header">
                                            <span class="header-title">Bangladesh Railway Ticket</span>
                                        </div>
                                        <div class="route-info">
                                            <span class="station">{{ $bookings[$i]->from }}</span>
                                            <i class="bi bi-train-front train-icon"></i>
                                            <span class="station">{{ $bookings[$i]->to }}</span>
                                        </div>
                                        <div class="details-grid">
                                            <div class="detail-item">
                                                <span class="label">Ticket No.</span>
                                                <span class="value">{{ $bookings[$i]->transaction_id }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Passenger</span>
                                                <span class="value">{{ $bookings[$i]->name }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">National ID</span>
                                                <span class="value">{{ $bookings[$i]->national_id }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Train Name</span>
                                                <span class="value">{{ $bookings[$i]->train_name }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Journey Type</span>
                                                <span class="value">{{ ucfirst($bookings[$i]->journey_type) }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Coach</span>
                                                <span class="value">{{ $bookings[$i]->coach ?? 'N/A' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Class</span>
                                                <span class="value">{{ $bookings[$i]->class }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Seat No.</span>
                                                <span class="value">{{ implode(', ', json_decode($bookings[$i]->selected_seats)) }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Departure</span>
                                                <span class="value">{{ $bookings[$i]->departure_time }}, {{ \Carbon\Carbon::parse($bookings[$i]->date)->format('d M Y') }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Issue Date/Time</span>
                                                <span class="value">{{ \Carbon\Carbon::parse($bookings[$i]->created_at)->format('d M Y, h:i A') }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Total Amount</span>
                                                <span class="value">{{ $bookings[$i]->total_amount }}</span>
                                            </div>
                                        </div>
                                        <div class="barcode-main"></div>
                                    </div>
                                    <div class="tear-effect"></div>
                                    <div class="col-4 slip-section">
                                        <div class="slip-header">Passenger Copy</div>
                                        <div class="slip-route">
                                            <span class="slip-station">{{ $bookings[$i]->from }}</span>
                                            <span class="slip-station">{{ $bookings[$i]->to }}</span>
                                        </div>
                                        <div class="slip-details">
                                            <div class="detail-item">
                                                <span class="label">Ticket No.</span>
                                                <span class="value">{{ $bookings[$i]->transaction_id }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Passenger</span>
                                                <span class="value">{{ $bookings[$i]->name }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Train Name</span>
                                                <span class="value">{{ $bookings[$i]->train_name }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Contact</span>
                                                <span class="value">{{ $bookings[$i]->contact_no }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Coach/Seat</span>
                                                <span class="value">{{ $bookings[$i]->coach ?? 'N/A' }}/{{ implode(', ', json_decode($bookings[$i]->selected_seats)) }}</span>
                                            </div>
                                        </div>
                                        <div class="barcode-slip"></div>
                                    </div>
                                </div>
                            </div>
                            <button class="download-btn" onclick="downloadTicket('ticket-{{ $bookings[$i]->id }}', '{{ $bookings[$i]->transaction_id }}')">
                                <i class="bi bi-download me-2"></i>Download Ticket
                            </button>
                        </div>
                    @else
                        <div class="ticket-item">
                            <div class="ticket-placeholder">
                                No Ticket Available
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        @endif
    </div>
    <a href="/dashboard" class="back-dashboard-btn">
        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
    </a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        function downloadTicket(ticketId, transactionId) {
            console.log('Download button clicked for ID:', ticketId);
            const ticketElement = document.getElementById(ticketId);
            if (!ticketElement) {
                console.error('Ticket element not found:', ticketId);
                alert('Ticket not found. Please try again.');
                return;
            }

            html2canvas(ticketElement, {
                scale: 1,
                backgroundColor: '#F0F2F5'
            }).then(canvas => {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'mm',
                    format: [160, 70]
                });

                const imgData = canvas.toDataURL('image/png');
                const imgWidth = 160;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                pdf.save(`ticket_${transactionId}.pdf`);
                console.log('PDF downloaded:', `ticket_${transactionId}.pdf`);
            }).catch(error => {
                console.error('Error generating PDF:', error);
                alert('Failed to generate PDF. Please try again.');
            });
        }
    </script>
</body>
</html>