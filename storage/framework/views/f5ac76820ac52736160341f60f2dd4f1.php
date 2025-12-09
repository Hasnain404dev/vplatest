<!DOCTYPE html>
<html>
<head>
    <title>New Order Received</title>
</head>
<body>
    <h2>New Order Placed</h2>
    <p><strong>Order Number:</strong> <?php echo e($order->order_number); ?></p>
    <p><strong>Customer:</strong> <?php echo e($order->first_name); ?> <?php echo e($order->last_name); ?></p>
    <p><strong>Email:</strong> <?php echo e($order->email); ?></p>
    <p><strong>Phone:</strong> <?php echo e($order->phone); ?></p>
    <p><strong>Total:</strong>PKR <?php echo e(number_format($order->total_amount, 2)); ?></p>
    <p><strong>Payment Method:</strong> <?php echo e($order->payment_method); ?></p>
    <p><strong>Status:</strong> <?php echo e(ucfirst($order->status)); ?></p>

    <hr>
    <p>Check the admin panel for full order details.</p>
</body>
</html>
<?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views/emails/admin_order_notification.blade.php ENDPATH**/ ?>