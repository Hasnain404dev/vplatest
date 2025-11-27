<!DOCTYPE html>
<html>
<head>
    <title>New Order Received</title>
</head>
<body>
    <h2>New Order Placed</h2>
    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Customer:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Phone:</strong> {{ $order->phone }}</p>
    <p><strong>Total:</strong>PKR {{ number_format($order->total_amount, 2) }}</p>
    <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    <hr>
    <p>Check the admin panel for full order details.</p>
</body>
</html>
