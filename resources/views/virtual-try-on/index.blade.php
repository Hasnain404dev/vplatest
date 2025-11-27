@extends('frontend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="d-flex justify-content-between mt-4">
                        <h3>{{ $product->name }}</h3>
                        <div class="product-meta">
                            <a href="{{ route('frontend.productDetail', $product->slug) }}"
                                class="btn btn-sm btn-outline-secondary">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <div class="try-on-container position-relative mx-auto  virtualTryOnSection">
                            <video id="video" width="640" height="480" autoplay playsinline
                                style="transform: scaleX(-1); display: block;"></video>
                            <canvas id="canvas" width="640" height="480"
                                style="position: absolute; top: 0; left: 0; transform: scaleX(-1); pointer-events: none;"></canvas>
                        </div> --}}

                        <div class="try-on-container position-relative mx-auto virtualTryOnSection">
                            <video id="video" autoplay playsinline></video>
                            <canvas id="canvas"></canvas>
                        </div>

                        <!-- Move loading and error messages here, above size controls -->
                        <div id="error-message" class="alert alert-danger mt-3" style="display: none;"></div>
                        <div id="loading-message" class="alert alert-info mt-3">
                            <p>Initializing virtual try-on system...</p>
                            <p>Please make sure:</p>
                            <ul>
                                <li>You're using Chrome or Edge browser</li>
                                <li>Camera permissions are enabled</li>
                                <li>You're on a secure (HTTPS) connection</li>
                            </ul>
                        </div>

                        <!-- Size Controls -->
                        <div class="controls mt-3 p-3 bg-light rounded">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Frame Width</label>
                                    <input type="range" class="form-range" id="widthControl" min="0.5" max="1.5"
                                        step="0.01" value="1.10">
                                    <span id="widthValue">110%</span> of face width
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Frame Height</label>
                                    <input type="range" class="form-range" id="heightControl" min="0.5"
                                        max="1.2" step="0.01" value="0.85">
                                    <span id="heightValue">85%</span> of face height
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Vertical Position</label>
                                    <input type="range" class="form-range" id="positionControl" min="0.05"
                                        max="0.3" step="0.01" value="0.05">
                                    <span id="positionValue">05%</span> adjustment
                                </div>
                            </div>
                        </div>

                        <div id="error-message" class="alert alert-danger mt-3" style="display: none;"></div>
                        <div id="loading-message" class="alert alert-info mt-3">
                            <p>Initializing virtual try-on system...</p>
                            <p>Please make sure:</p>
                            <ul>
                                <li>You're using Chrome or Edge browser</li>
                                <li>Camera permissions are enabled</li>
                                <li>You're on a secure (HTTPS) connection</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.11.0/dist/tf.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@tensorflow-models/face-landmarks-detection@0.0.1/dist/face-landmarks-detection.js">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');
            const errorMessage = document.getElementById('error-message');
            const loadingMessage = document.getElementById('loading-message');

            const glassesSrc =
                "{{ asset('uploads/products/virtual_try_on/' . $product->virtual_try_on_image) }}";
            console.log('Glasses image path:', glassesSrc);

            let isRunning = true; // Set to true by default
            let model = null;
            let stream = null;
            const glasses = new Image();

            // Configuration with your requested defaults
            let widthPercent = 1.10;
            let heightPercent = 0.85;
            let verticalOffset = 0.05;

            // Load glasses image first
            glasses.onload = function() {
                console.log('Glasses image loaded successfully');
            };

            glasses.onerror = function() {
                showError('Failed to load glasses image. Please check the image exists at: ' + glassesSrc);
                console.error('Error loading glasses image');
                loadingMessage.style.display = 'none';
            };
            glasses.src = glassesSrc;
            glasses.crossOrigin = "Anonymous";

            // Setup control event listeners
            document.getElementById('widthControl').addEventListener('input', function(e) {
                widthPercent = parseFloat(e.target.value);
                document.getElementById('widthValue').textContent = Math.round(widthPercent * 100) +
                    '%';
            });

            document.getElementById('heightControl').addEventListener('input', function(e) {
                heightPercent = parseFloat(e.target.value);
                document.getElementById('heightValue').textContent = Math.round(heightPercent * 100) +
                    '%';
            });

            document.getElementById('positionControl').addEventListener('input', function(e) {
                verticalOffset = parseFloat(e.target.value);
                document.getElementById('positionValue').textContent = Math.round(verticalOffset *
                    100) + '%';
            });

            async function setupCamera() {
                try {
                    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                        throw new Error('Camera API not supported in this browser');
                    }

                    stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            width: 640,
                            height: 480,
                            facingMode: 'user'
                        },
                        audio: false
                    });

                    video.srcObject = stream;

                    return new Promise((resolve) => {
                        video.onloadedmetadata = () => {
                            video.play();
                            resolve(video);
                        };
                    });
                } catch (error) {
                    console.error('Error accessing camera:', error);
                    showError('Failed to access camera. Please ensure camera permissions are granted. ' +
                        error.message);
                    throw error;
                }
            }

            async function loadFaceDetectionModel() {
                try {
                    loadingMessage.textContent = 'Loading face detection model...';
                    await tf.ready();
                    model = await faceLandmarksDetection.load(
                        faceLandmarksDetection.SupportedPackages.mediapipeFacemesh, {
                            maxFaces: 1
                        }
                    );
                    console.log('Face detection model loaded');
                    return model;
                } catch (error) {
                    console.error('Error loading face detection model:', error);
                    showError('Failed to load face detection model. Please refresh the page. ' + error
                        .message);
                    throw error;
                }
            }

            function showError(message) {
                errorMessage.textContent = message;
                errorMessage.style.display = 'block';
                loadingMessage.style.display = 'none';
            }

            function hideError() {
                errorMessage.style.display = 'none';
            }

            async function detectFace() {
                if (!isRunning) return;

                try {
                    const predictions = await model.estimateFaces({
                        input: video,
                        returnTensors: false,
                        flipHorizontal: false,
                        predictIrises: true
                    });

                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;

                    const scaleX = canvas.width / video.videoWidth;
                    const scaleY = canvas.height / video.videoHeight;

                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    if (predictions.length > 0) {
                        const keypoints = predictions[0].scaledMesh;

                        const leftEye = keypoints[33];
                        const rightEye = keypoints[263];

                        const faceWidth = Math.abs(keypoints[234][0] - keypoints[454][0]) * scaleX;
                        const faceHeight = Math.abs(keypoints[10][1] - keypoints[152][1]) * scaleY;
                        const eyeDistance = Math.abs((rightEye[0] - leftEye[0]) * scaleX);

                        const glassesWidth = faceWidth * widthPercent;
                        const glassesHeight = faceHeight * heightPercent;

                        const leftEyeX = leftEye[0] * scaleX;
                        const leftEyeY = leftEye[1] * scaleY;
                        const rightEyeX = rightEye[0] * scaleX;
                        const rightEyeY = rightEye[1] * scaleY;

                        const centerX = (leftEyeX + rightEyeX) / 2;
                        const centerY = ((leftEyeY + rightEyeY) / 2) + (eyeDistance * verticalOffset);

                        const angle = Math.atan2(rightEyeY - leftEyeY, rightEyeX - leftEyeX);

                        ctx.save();
                        ctx.globalAlpha = 0.9;
                        ctx.translate(centerX, centerY);
                        ctx.rotate(angle);
                        ctx.drawImage(
                            glasses,
                            -glassesWidth / 2,
                            -glassesHeight / 2,
                            glassesWidth,
                            glassesHeight
                        );
                        ctx.restore();
                    }
                } catch (error) {
                    console.error('Face detection error:', error);
                    showError('Adjustment error. Please try again.');
                }

                requestAnimationFrame(detectFace);
            }


            // Initialize everything automatically
            try {
                hideError();
                await setupCamera();
                model = await loadFaceDetectionModel();
                loadingMessage.style.display = 'none';
                detectFace();
            } catch (error) {
                console.error('Setup failed:', error);
                showError('Failed to start virtual try-on. ' + error.message);
            }

            // Clean up on page unload
            window.addEventListener('beforeunload', () => {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
            });
        });
    </script>
@endsection
