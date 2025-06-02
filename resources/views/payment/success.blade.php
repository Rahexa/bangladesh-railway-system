<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Include your existing styles here -->
    <style>
        /* Copy your existing styles from the booking form HTML here */
        body { background-color: #f8f9fa; font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        #bookingForm { position: absolute; top: 50%; left: 20%; transform: translate(-50%, -50%); margin: 20px auto; padding: 20px; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 450px; will-change: transform; }
        /* ... (rest of your styles) */
    </style>
</head>
<body>
    <!-- Include your booking form HTML here -->
    @include('booking.form') <!-- Assuming you extract the form into a separate file -->

    <!-- Transaction Success Popup -->
    <div id="transactionSuccessPopup" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[400px] h-[250px] bg-white rounded-lg shadow-lg z-[1002]">
        <div class="p-4 flex flex-col h-full justify-center items-center">
            <h5 class="text-lg font-semibold text-gray-800 flex items-center mb-4"><i class="bi bi-check-circle text-green-600 mr-2"></i> Transaction Successful</h5>
            <p class="success-message mb-2">Payment completed successfully!</p>
            <p><strong>Transaction ID:</strong> <span id="transactionId">{{ $tran_id }}</span></p>
            <p><strong>Total Payment:</strong> <span id="transactionTotal">৳{{ $amount }}</span></p>
            <button type="button" id="closeSuccessBtn" class="mt-4 bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700 transition">Close</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Show the success popup immediately on page load
            $('#transactionSuccessPopup').css('display', 'block');

            $('#closeSuccessBtn').on('click', function () {
                $('#transactionSuccessPopup').hide();
                window.location.href = '/booking'; // Redirect to booking page after closing
            });
        });
    </script>
</body>
</html>