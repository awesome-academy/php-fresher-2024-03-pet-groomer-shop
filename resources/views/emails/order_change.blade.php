<!DOCTYPE html>
<html>

<head>
    <title>Payment Successful</title>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .header {
            background: #2278f9;
            color: rgb(255, 255, 255);
            padding: 10px 0;
            text-align: center;
        }

        .content {
            padding: 20px;
            background: #f9f9f9;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Order Status Update: {{ $order->order_id }}</h1>
        </div>
        <div class="content">
            <h2>Dear {{ $order->user()->first()->full_name }},</h2>
            <p>Your order has been changed to {{ $order->order_status_name }}.</p>
            <p><strong>Order Details:</strong></p>
            <ul>
                <li><strong>Order ID:</strong> {{ $order->order_id }}</li>
                <li><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</li>
                <li><strong>Total Amount:</strong> ${{ number_format($order->order_total_price, 2) }}</li>
                <li><strong>See Detail:</strong> <a
                        href="{{ route('care-order-history.show', ['care_order_history' => $order->order_id]) }}">
                        <i>here</i></a></li>
            </ul>
            <p>If you have any questions about your order, please contact us at support@example.com.</p>
            <p>Thank you for choosing our service!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Sun Asterisk. All rights reserved.
        </div>
    </div>
</body>

</html>
