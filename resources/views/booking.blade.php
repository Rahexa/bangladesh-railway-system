<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400,600,700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #a7f3d0, #6ee7b7); /* Modern green gradient */
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .popup {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(20px) scale(0.95);
            opacity: 0;
        }

        #transactionSuccessPopup.show {
            display: block;
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .popup-content {
            background: linear-gradient(145deg, #ffffff, #f8fafc); /* Subtle white gradient */
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15), 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            width: 100%;
            max-width: 480px;
            position: relative;
        }

        .popup-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(to right, #10b981, #059669); /* Decorative top bar */
        }

        .icon-circle {
            background: #d1fae5; /* Softer green */
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 1.8s ease-in-out infinite;
            border: 2px solid #10b981;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .details-box {
            background: #ecfdf5; /* Modern light green */
            border-radius: 16px;
            padding: 1.75rem;
            border: 1px solid #a7f3d0;
            transition: transform 0.3s ease;
        }

        .details-box:hover {
            transform: translateY(-4px);
        }

        .btn-modern {
            background: linear-gradient(90deg, #10b981, #34d399); /* Vibrant gradient */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-modern:hover {
            background: linear-gradient(90deg, #059669, #10b981);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
        }

        .btn-modern:active {
            transform: translateY(0);
        }

        .text-green-accent {
            color: #10b981;
            transition: color 0.3s ease;
        }

        .text-green-accent-hover:hover {
            color: #047857;
        }

        .highlight-text {
            background: linear-gradient(90deg, #10b981, #34d399);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 700;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #d1fae5, transparent);
            margin: 1.5rem 0;
        }
    </style>
</head>
<body>
    <!-- Transaction Success Popup -->
    <div id="transactionSuccessPopup" class="popup">
        <div class="popup-content">
            <div class="relative p-8 text-center">
                <div class="icon-circle mx-auto mb-6">
                    <i class="fas fa-check text-4xl text-green-600 animate-bounce"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Payment Successful!</h2>
                <p class="text-gray-600 mb-6 text-lg leading-relaxed">Your booking is confirmed. <span class="highlight-text text-green-accent-hover">Ready for your adventure?</span></p>
                <div class="divider"></div>
                <div class="details-box mb-6">
                    <div class="flex items-center justify-between mb-5">
                        <span class="text-sm font-medium text-gray-600 flex items-center gap-2">
                            <i class="fas fa-receipt text-green-accent"></i> Transaction ID
                        </span>
                        <span id="transactionId" class="text-sm font-mono text-gray-800 break-all">{{ request()->query('tranId', 'N/A') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600 flex items-center gap-2">
                            <i class="fas fa-wallet text-green-accent"></i> Total Amount
                        </span>
                        <span id="transactionTotal" class="text-xl font-bold text-green-600">{{ request()->query('total_amount') ? '৳' . request()->query('total_amount') : 'N/A' }}</span>
                    </div>
                </div>
                <button id="closeSuccessBtnBottom" class="w-full btn-modern text-white">
                    <i class="fas fa-arrow-right"></i> Go to Dashboard
                </button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            const urlParams = new URLSearchParams(window.location.search);
            const tranId = urlParams.get('tranId');
            const status = urlParams.get('status');
            const totalAmount = urlParams.get('total_amount');

            if (status === 'success' && tranId && totalAmount) {
                $('#transactionId').text(tranId);
                $('#transactionTotal').text(`৳${totalAmount}`);
                $('#transactionSuccessPopup').addClass('show');
            }

            $('#closeSuccessBtnBottom').on('click', function () {
                $('#transactionSuccessPopup').removeClass('show');
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 500); // Matches transition duration
            });
        });
    </script>
</body>
</html>