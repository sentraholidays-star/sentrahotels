<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-w-7xl;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            max-width: 600px;
        }
        .email-header {
            background-color: #101415;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
            color: #c5a059;
        }
        .email-body {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .booking-details {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 20px;
            margin-top: 20px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 12px;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 12px;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .detail-label {
            font-weight: bold;
            width: 140px;
            color: #6b7280;
        }
        .detail-value {
            color: #111827;
            font-weight: 500;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #9ca3af;
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>SENTRA HOTELS</h1>
            <p style="margin-top: 10px; font-size: 14px;">Luxury Hotel Desk</p>
        </div>
        
        <div class="email-body">
            @if($isAdmin)
                <h2>New Booking Request Received!</h2>
                <p>A new reservation request has been submitted via the website.</p>
            @else
                <h2>Dear {{ $bookingData['customer_name'] }},</h2>
                <p>Thank you for choosing Sentra Hotels. We have successfully received your reservation request. Our travel consultant will process your request and contact you shortly with the best corporate rate available.</p>
            @endif

            <div class="booking-details">
                <h3 style="margin-top: 0; color: #101415; border-bottom: 2px solid #c5a059; padding-bottom: 10px; display: inline-block;">Booking Summary</h3>
                
                <div class="detail-row">
                    <div class="detail-label">Hotel</div>
                    <div class="detail-value">{{ $bookingData['hotel_name'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Check-in</div>
                    <div class="detail-value">{{ $bookingData['check_in'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Check-out</div>
                    <div class="detail-value">{{ $bookingData['check_out'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Room Type</div>
                    <div class="detail-value">{{ $bookingData['room_type'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Number of Rooms</div>
                    <div class="detail-value">{{ $bookingData['room_count'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Meals</div>
                    <div class="detail-value">{{ $bookingData['meals'] }}</div>
                </div>
                
                <h3 style="margin-top: 25px; color: #101415; border-bottom: 2px solid #c5a059; padding-bottom: 10px; display: inline-block;">Guest Information</h3>
                <div class="detail-row">
                    <div class="detail-label">Name</div>
                    <div class="detail-value">{{ $bookingData['customer_name'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $bookingData['email'] }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Phone/WhatsApp</div>
                    <div class="detail-value">{{ $bookingData['phone'] }}</div>
                </div>
            </div>

            @if(!$isAdmin)
                <p style="margin-top: 30px;">If you have any urgent inquiries, please do not hesitate to contact our customer support via WhatsApp.</p>
            @endif
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} Sentra Hotels. All rights reserved.<br>
            Reservation & Corporate Desk
        </div>
    </div>
</body>
</html>
