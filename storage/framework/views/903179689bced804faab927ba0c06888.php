<?php $__env->startSection('content'); ?>
    <style>
        #myChart {
            width: 100% !important;
            height: 300px !important;
        }
    </style>
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Dashboard </h2>
            <p>Whole data about your business here</p>
        </div>
        <div>
            <a href="#" class="btn btn-primary"><i class="text-muted material-icons md-post_add"></i>Create report</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i
                            class="text-warning material-icons md-qr_code"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Products</h6> <span><?php echo e($products); ?></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light"><i
                            class="text-success material-icons md-local_shipping"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Orders</h6> <span><?php echo e($orders); ?></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light"><i
                            class="text-primary material-icons md-account_circle"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Users</h6>
                        <span><?php echo e($customers); ?></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-info-light"><i
                            class="text-info material-icons md-shopping_basket"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Earnings</h6>
                        <span><?php echo e(number_format($totalEarnings, 2)); ?> PKR</span>
                    </div>
                </article>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card mb-4">
                <article class="card-body">
                    <h5 class="card-title">Sale statistics</h5>
                    <canvas id="myChart" height="50px" width="100%"></canvas>
                </article>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <!-- Pass PHP data to JavaScript -->
    <script>
        var chartData = <?php echo json_encode($chartData, 15, 512) ?>;
        console.log('Chart Data:', chartData);
    </script>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Your custom chart script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof chartData !== 'undefined' && document.getElementById('myChart')) {
                try {
                    console.log('Chart Data:', chartData);

                    const ctx = document.getElementById('myChart').getContext('2d');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                                'Nov', 'Dec'
                            ],
                            datasets: [{
                                    label: 'Sales (PKR)',
                                    data: chartData.sales,
                                    backgroundColor: 'rgba(44, 120, 220, 0.2)',
                                    borderColor: 'rgba(44, 120, 220, 1)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true
                                },
                                {
                                    label: 'New Products',
                                    data: chartData.products,
                                    backgroundColor: 'rgba(380, 200, 230, 0.2)',
                                    borderColor: 'rgb(380, 200, 230)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true
                                },
                                {
                                    label: 'New Customers',
                                    data: chartData.customers,
                                    backgroundColor: 'rgba(4, 209, 130, 0.2)',
                                    borderColor: 'rgb(4, 209, 130)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 20
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label.includes('Sales')) {
                                                return `${label}: PKR ${context.parsed.y.toFixed(2)}`;
                                            }
                                            return `${label}: ${context.parsed.y}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value, index, values) {
                                            // For all y-axis labels
                                            return value;
                                        }
                                    }
                                }
                            }
                        }
                    });

                } catch (error) {
                    console.error('Chart error:', error);
                    const chartElement = document.getElementById('myChart');
                    if (chartElement) {
                        chartElement.innerHTML = `
                            <div class="alert alert-danger p-3">
                                <strong>Chart Error:</strong> ${error.message}
                            </div>
                        `;
                    }
                }
            } else {
                console.error('Chart data or canvas element not found');
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\world\Desktop\vppp\vplatest\resources\views/backend/index.blade.php ENDPATH**/ ?>