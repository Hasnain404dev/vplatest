<?php $__env->startSection('content'); ?>
<h2>Password Reset Request</h2>

<p>Hello!</p>

<p>You are receiving this email because we received a password reset request for your account.</p>

<div style="text-align: center; margin: 30px 0;">
    <a href="<?php echo e($actionUrl); ?>" class="button" style="color: #ffff;">Reset Password</a>
</div>

<p>This password reset link will expire in 60 minutes.</p>

<p>If you did not request a password reset, no further action is required.</p>

<p>Best regards,<br>
<strong>VisionPlus Opticians Team</strong></p>

<hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">

<p style="font-size: 12px; color: #666;">
    If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:<br>
    <a href="<?php echo e($actionUrl); ?>" style="color: #007bff;"><?php echo e($actionUrl); ?></a>
</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\emails\password-reset.blade.php ENDPATH**/ ?>