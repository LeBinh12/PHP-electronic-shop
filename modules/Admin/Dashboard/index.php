<?php

// Tổng số liệu
$totalUsers = 15;
$totalProducts = 30;
$totalOrdersThisWeek = 22;
$totalRevenue = 22;
$totalRevenueFormatted = 10;

$stmt = 30;


$labels = ['06/12'];
$data = ['12000'];




?>



<div class="container-fluid py-4">
    <h3 class="mb-4 fw-bold">
        <i class="fas fa-chart-bar text-info me-2"></i> Tổng quan
    </h3>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(45deg, #6a11cb, #2575fc);">
                <div class="card-body">
                    <h5><i class="fas fa-user me-2"></i><?= $totalUsers ?></h5>
                    <p class="mb-0">Người dùng</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(45deg, #11998e, #38ef7d);">
                <div class="card-body">
                    <h5><i class="fas fa-box me-2"></i><?= $totalProducts ?></h5>
                    <p class="mb-0">Sản phẩm</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(45deg, #f7971e, #ffd200);">
                <div class="card-body">
                    <h5><i class="fas fa-calendar-week me-2"></i><?= $totalOrdersThisWeek ?></h5>
                    <p class="mb-0">Đơn tuần này</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white" style="background: linear-gradient(45deg, #56ab2f, #a8e063);">
                <div class="card-body">
                    <h5><i class="fas fa-dollar-sign me-2"></i>$<?= $totalRevenueFormatted ?></h5>
                    <p class="mb-0">Doanh thu</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="row g-3">
            <!-- Biểu đồ đường -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header fw-bold">Doanh thu 7 ngày gần nhất</div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div style="width: 100%; height: 250px;">
                            <canvas id="lineChart" style="max-height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ tròn -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header fw-bold">Tỷ lệ số lượng</div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div style="width: 100%; height: 250px;">
                            <canvas id="pieChart" style="max-height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: <?= json_encode($data) ?>,
                        fill: true,
                        borderColor: '#4bc0c0',
                        backgroundColor: 'rgba(75,192,192,0.2)',
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#4bc0c0',
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat().format(value);
                                }
                            }
                        }
                    }
                }
            });

            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Người dùng', 'Sản phẩm', 'Đơn hàng'],
                    datasets: [{
                        data: [<?= $totalUsers ?>, <?= $totalProducts ?>, <?= $totalOrdersThisWeek ?>],
                        backgroundColor: ['#36a2eb', '#4bc0c0', '#ff6384']
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        </script>