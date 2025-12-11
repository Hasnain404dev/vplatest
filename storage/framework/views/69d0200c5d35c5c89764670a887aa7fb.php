<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order #<?php echo e($order->order_number); ?></title>
    <style>
        /* Compact print styling for single page */
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            margin: 0;
            padding: 5mm;
        }
        
        .print-header {
            text-align: center;
            margin-bottom: 5mm;
            padding-bottom: 3mm;
            border-bottom: 1px solid #ddd;
        }
        
        .print-header img {
            height: 20mm;
        }
        
        .print-section {
            margin-bottom: 5mm;
        }
        
        h3 {
            font-size: 11pt;
            margin: 3mm 0;
            padding-bottom: 1mm;
            border-bottom: 1px solid #eee;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-bottom: 3mm;
        }
        
        th, td {
            padding: 2mm;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .prescription-details {
            margin-top: 2mm;
            padding: 2mm;
            background-color: #f8f9fa;
            border-left: 3px solid #0d6efd;
        }
        
        .prescription-table {
            font-size: 8pt;
        }
        
        .text-right {
            text-align: right;
        }
        
        .compact-row {
            margin-bottom: 1mm;
        }
        
        @page {
            size: A4 portrait;
            margin: 5mm;
        }
        
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>
    
    <script>
        // Auto-print and close after 500ms
        window.onload = function() {
            setTimeout(function() {
                window.print();
                setTimeout(function() {
                    window.close();
                }, 500);
            }, 500);
        };
    </script>
</body>
</html><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\layouts\print.blade.php ENDPATH**/ ?>