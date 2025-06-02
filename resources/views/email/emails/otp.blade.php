<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP for Ticket Booking</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #3182ce;">Ticket Booking OTP</h2>
        <p>Dear Customer,</p>
        <p>Your One-Time Password (OTP) for completing your ticket booking is:</p>
        <h3 style="background-color: #f8f9fa; padding: 10px; text-align: center; border-radius: 5px;">{{ $otp }}</h3>
        <p>Please enter this OTP in the booking form to proceed with your payment. This OTP is valid for 10 minutes.</p>
        <p>If you did not request this OTP, please ignore this email or contact our support team.</p>
        <p>Thank you for choosing our service!</p>
        <p>Best regards,<br>Ticket Booking Team</p>
    </div>
</body>
</html>