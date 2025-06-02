<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success - Bangladesh Railway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #28a745; text-align: center; }
        .details { margin-top: 20px; }
        .btn-dashboard { display: block; width: 200px; margin: 20px auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Successful!</h1>
        <div class="details">
            <p><strong>Transaction ID:</strong> {{ $tranId }}</p>
            <p><strong>Total Amount:</strong> {{ $totalAmount }} BDT</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-dashboard">Back to Dashboard</a>
    </div>
</body>
</html>