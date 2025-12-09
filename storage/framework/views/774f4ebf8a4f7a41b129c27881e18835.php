<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h2>Thank You for Your Order!</h2>
    <p>Hi <?php echo e($order->first_name); ?>,</p>

    <p>We have received your order <strong>#<?php echo e($order->order_number); ?></strong>.</p>
    <p><strong>Total:</strong>PKR <?php echo e(number_format($order->total_amount, 2)); ?></p>
    <p><strong>Payment Method:</strong> <?php echo e($order->payment_method); ?></p>

    <p>We will notify you once your order is being processed or shipped.</p>

    <br>
    <p>Best regards,</p>
    <p><strong>QR Media Hub Team</strong></p>
</body>
</html>
<?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views/emails/customer_order_confirmation.blade.php ENDPATH**/ ?>