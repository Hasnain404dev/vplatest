<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>visionplus</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('frontend/assets/imgs/theme/favicon.svg')); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('frontend/assets/imgs/theme/vp_favicon.png')); ?>" />

    
    
    <link rel="stylesheet" href="<?php echo e(asset('frontend/assets/css/prescription.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('frontend/assets/css/lensesPrescription.css')); ?>" />


</head>


<body>

    <!-- Popup Modal -->
    
    <div class="success-popup" id="successPopup">
        <p>
            Thank you for your order! It has been successfully submitted. You'll
            receive a confirmation soon.
        </p>
    </div>
    <?php echo $__env->yieldContent('content'); ?>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <h5 class="mb-10">Sharpening your vision… Please wait</h5>
                    <div class="loader">
                        <div class="bar bar1"></div>
                        <div class="bar bar2"></div>
                        <div class="bar bar3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this script to handle the preloader -->
    <script>
        window.addEventListener('load', function () {
            document.getElementById('preloader-active').style.display = 'none';
        });
    </script>

    <!-- Elegant WhatsApp Floating Button -->
    <a href="https://wa.me/923391339339?text=Hi%20Vision%20Plus%20Optical,%20I%20need%20assistance."
        class="whatsapp-float" target="_blank" aria-label="Chat on WhatsApp">
        <!-- WhatsApp Icon SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-whatsapp"
            viewBox="0 0 16 16">
            <path
                d="M13.601 2.326A7.875 7.875 0 0 0 8.005 0C3.582 0 .007 3.575 0 7.994a7.942 7.942 0 0 0 1.104 4.04L.058 16l4.124-1.08a7.973 7.973 0 0 0 3.823.974h.004c4.422 0 8.005-3.575 8.005-7.994a7.93 7.93 0 0 0-2.413-5.574ZM8.005 14.6a6.56 6.56 0 0 1-3.356-.923l-.24-.143-2.447.64.654-2.386-.156-.246a6.556 6.556 0 0 1 5.547-9.842h.003a6.559 6.559 0 0 1 6.548 6.548c0 3.623-2.956 6.552-6.553 6.552Zm3.666-4.967c-.2-.1-1.18-.582-1.364-.648-.183-.065-.317-.1-.45.1-.134.2-.516.648-.633.782-.116.134-.233.15-.433.05-.2-.1-.843-.31-1.604-.991-.593-.528-.993-1.177-1.11-1.376-.117-.2-.012-.3.088-.4.09-.09.2-.233.3-.35.1-.117.134-.2.2-.333.067-.134.034-.25-.017-.35-.05-.1-.45-1.084-.616-1.484-.162-.39-.327-.334-.45-.34l-.383-.006a.737.737 0 0 0-.533.25c-.183.2-.7.683-.7 1.667 0 .983.717 1.935.817 2.067.1.133 1.41 2.15 3.42 3.015.478.206.85.33 1.14.422.48.153.917.132 1.263.08.385-.057 1.18-.48 1.347-.944.167-.465.167-.865.117-.95-.05-.084-.183-.133-.383-.233Z" />
        </svg>
    </a>
    <!-- End Elegant WhatsApp Floating Button -->
    <!--Live sales notification  start-->
    
    <!--Live sales notification  End-->


    
    <script src="<?php echo e(asset('frontend/assets/js/prescription.js')); ?>"></script>


    <!--Start of Tawk.to Script-->
     <script type="text/javascript">
    //     var Tawk_API = Tawk_API || {},
    //         Tawk_LoadStart = new Date();
    //     (function () {
    //         var s1 = document.createElement("script"),
    //             s0 = document.getElementsByTagName("script")[0];
    //         s1.async = true;
    //         s1.src = "https://embed.tawk.to/680094e91d1b06190d6f921f/1ip14bchr";
    //         s1.charset = "UTF-8";
    //         s1.setAttribute("crossorigin", "*");
    //         s0.parentNode.insertBefore(s1, s0);
    //     })();
    // </script>
    <!--End of Tawk.to Script-->

    <!--Live sales notification  start-->
    
    <!--Live sales notification  End-->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\frontend\layouts\prescriptionApp.blade.php ENDPATH**/ ?>