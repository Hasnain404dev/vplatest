<!DOCTYPE html>
<html>
<head>
    <title>Contact Us Message</title>
</head>
<body>
    <h2>Contact Us Submission</h2>
    <p><strong>Name:</strong> <?php echo e($contact->name); ?></p>
    <p><strong>Email:</strong> <?php echo e($contact->email); ?></p>
    <?php if($contact->telephone): ?>
        <p><strong>Phone:</strong> <?php echo e($contact->telephone); ?></p>
    <?php endif; ?>
    <p><strong>Subject:</strong> <?php echo e($contact->subject); ?></p>
    <p><strong>Message:</strong></p>
    <p><?php echo e($contact->message); ?></p>
</body>
</html>
<?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\emails\contact.blade.php ENDPATH**/ ?>