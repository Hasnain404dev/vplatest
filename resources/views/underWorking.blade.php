<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Under Construction</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .uc-gradient-bg {
            background: linear-gradient(135deg, #c8dcd7 0%, #377b6b 100%);
            min-height: 100vh;
        }
        
        .uc-glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .uc-bounce-icon {
            animation: uc-bounce 2s infinite;
        }
        
        .uc-fade-up {
            animation: uc-fadeUp 1s ease-out;
        }
        
        .uc-progress-custom {
            background: rgba(255, 255, 255, 0.2);
            height: 12px;
        }
        
        .uc-progress-bar-custom {
            background: linear-gradient(90deg, #80d5c0 0%, #4da591 100%);
            width: 75%;
            animation: uc-progressFill 2s ease-out;
        }
        
        .uc-text-gradient {
            background: linear-gradient(45deg, #ffffff, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .uc-social-hover:hover {
            color: #3a3a39 !important;
            transform: translateY(-3px);
        }
        
        @keyframes uc-bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-15px); }
            60% { transform: translateY(-8px); }
        }
        
        @keyframes uc-fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes uc-progressFill {
            from { width: 0%; }
            to { width: 75%; }
        }
    </style>
</head>
<body class="uc-gradient-bg">
    <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100 p-4">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-lg-8 col-xl-6">
             
                <div class="text-center text-white">
                    
                 
                    <div class="mb-5 uc-fade-up">
                        <i class="bi bi-cone-striped display-1 text-warning uc-bounce-icon"></i>
                    </div>
                 
                    <h1 class="display-2 fw-bold mb-4 uc-text-gradient uc-fade-up">
                        We're Building Something Amazing
                    </h1>
                    
                    
                    <h2 class="h3 mb-4 text-white  fw-light uc-fade-up">
                        Our website is under construction
                    </h2>
                    
                    
                    <p class="lead mb-5 text-white fw-500 uc-fade-up">
                        We're working hard to bring you an incredible experience. 
                        Our team is putting the finishing touches on something special that will be worth the wait.
                    </p>
                    
                    
                    <div class="mb-5 uc-fade-up">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-semibold text-white fs-5">Development Progress</span>
                            <span class="fw-semibold text-white fs-5">90%</span>
                        </div>
                        <div class="progress uc-progress-custom rounded-pill">
                            <div class="progress-bar uc-progress-bar-custom rounded-pill"></div>
                        </div>
                    </div>
                    
                   
                    <div class="row g-4 mb-5 uc-fade-up">
                        <div class="col-md-4">
                            <div class="uc-glass-card rounded-4 p-4 h-100">
                                <i class="bi bi-rocket-takeoff fs-1 text-info mb-3"></i>
                                <h5 class="text-white mb-2 fw-semibold">Fast & Modern</h5>
                                <small class="text-white-50">Built with latest technologies for optimal performance</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="uc-glass-card rounded-4 p-4 h-100">
                                <i class="bi bi-shield-check fs-1 text-success mb-3"></i>
                                <h5 class="text-white mb-2 fw-semibold">Secure & Safe</h5>
                                <small class="text-white-50">Your data and privacy are our top priorities</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="uc-glass-card rounded-4 p-4 h-100">
                                <i class="bi bi-phone fs-1 text-warning mb-3"></i>
                                <h5 class="text-white mb-2 fw-semibold">Mobile Ready</h5>
                                <small class="text-white-50">Perfect experience across all devices and screen sizes</small>
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="uc-glass-card rounded-4 p-4 p-md-5 mb-5 uc-fade-up">
                        <h3 class="h4 mb-3 text-white fw-semibold">
                            <i class="bi bi-clock me-2 text-info"></i>
                            Coming Soon
                        </h3>
                        <p class="mb-0 text-white-50 fs-5">
                            We're putting the final touches on our new website. 
                            Thank you for your patience as we work to deliver something extraordinary.
                        </p>
                    </div>
                    
                 
                    <div class="mb-4 uc-fade-up">
                        <h5 class="text-white mb-4 fw-semibold">Follow Us</h5>
                        <div class="d-flex justify-content-center gap-4">
                            <a href="https://www.facebook.com/VisionPlusOpticianPK" target="_blank" class="text-white fs-2 text-decoration-none uc-social-hover transition" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                      
                            <a href="https://www.instagram.com/visionplusopticianspk/" target="_blank" class="text-white fs-2 text-decoration-none uc-social-hover transition" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                         
                            <a href="https://www.youtube.com/@VisionPlusOptician" target="_blank" class="text-white fs-2 text-decoration-none uc-social-hover transition" title="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                    
                  
                
                    
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>