@include('template.header')
@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        @include('template.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row mt-2">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-4 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="form-group mb-4">
                                                    <h6 class="text-primary">Total Uang Kas Yang Masuk</h6>
                                                    <div class="d-flex align-items-center">
                                                        <h2 class="me-2 fw-bold">Rp{{ number_format($chartData['total'], 2, ',', '.') }}</h2>
                                                        <h4 class="me-4 text-muted">IDR</h4>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group mb-4">
                                                    <h6 class="text-danger">Total Pengeluaran Uang Kas <a href="/pengeluaran/uangkas"><i class="fa fa-eye"></i></a></h6>
                                                    <div class="d-flex align-items-center">
                                                        <h2 class="me-2 fw-bold">Rp{{ number_format($pengeluaranTotalUangKas, 2, ',', '.') }}</h2>
                                                        <h4 class="me-4 text-muted">IDR</h4>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group mb-4">
                                                    <h6 class="text-success">Total Saldo Uang Kas Sekarang</h6>
                                                    <div class="d-flex align-items-center">
                                                        <h2 class="me-2 fw-bold">Rp{{ number_format($saldoUangKas, 2, ',', '.') }}</h2>
                                                        <h4 class="me-4 text-muted">IDR</h4>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="col-lg-8 d-flex flex-column">
                                    <div class="row flex-grow">
                                        <div class="col-12">
                                            <div class="card card-rounded">
                                                <div class="card-body">
                                                    <div class="d-sm-flex justify-content-between align-items-start">
                                                        <div class="form-group">
                                                            <h3>{{ $campaign['nama'] }}</h3>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-group">
                                                                    <a href="/uangkas" class="btn btn-primary btn-md mb-0 me-2"><i class="fa fa-eye"></i></a>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-primary dropdown-toggle toggle-dark btn-md mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filter By </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                                            <h6 class="dropdown-header">Filter Data By</h6>
                                                                            <a href="/dashboard/uangkas" class="dropdown-item">Semua Bulan</a>
                                                                            <h6 class="dropdown-header">Daftar Bulan</h6>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=1">Januari</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=2">Februari</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=3">Maret</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=4">April</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=5">Mei</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=6">Juni</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=7">Juli</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=8">Agustus</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=9">September</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=10">Oktober</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=11">November</a>
                                                                            <a class="dropdown-item" href="/dashboard/uangkas?campaign_id={{ $campaign->id }}&month=12">Desember</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        @if ($chartData['chartType'] == 'monthly')
                                                            <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk Semua Bulan</p>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="form-group">
                                                                    <div class="d-flex align-items-center">
                                                                        <h2 class="me-2 fw-bold">Rp{{ number_format($chartData['total'], 2, ',', '.') }}</h2>
                                                                        <h4 class="me-4">IDR</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        @if ($chartData['persentaseKenaikanBulanan'] > 0)
                                                                            <h4 class="text-success">
                                                                                (+{{ number_format($chartData['persentaseKenaikanBulanan'], 2) }}%)
                                                                            </h4>
                                                                        @else
                                                                            <h4 class="text-danger">
                                                                                ({{ number_format($chartData['persentaseKenaikanBulanan'], 2) }}%)
                                                                            </h4>
                                                                        @endif
                                                                        <p>Dari Bulan sebelumnya</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk Bulan {{ $selectedMonthName }}</p>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="form-group">
                                                                    <div class="d-flex align-items-center">
                                                                        <h2 class="me-2 fw-bold">Rp{{ number_format($chartData['totalWeekly'], 2, ',', '.') }}</h2>
                                                                        <h4 class="me-4">IDR</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        @if ($chartData['persentaseKenaikanMingguan'] > 0)
                                                                            <h4 class="text-success">
                                                                                (+{{ number_format($chartData['persentaseKenaikanMingguan'], 2) }}%)
                                                                            </h4>
                                                                        @else
                                                                            <h4 class="text-danger">
                                                                                ({{ number_format($chartData['persentaseKenaikanMingguan'], 2) }}%)
                                                                            </h4>
                                                                        @endif
                                                                        <p>Dari Minggu sebelumnya</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>


                                                    <!-- Tampilkan chart bulanan atau mingguan sesuai dengan campaign yang dipilih -->
                                                    <div class="chartjs-bar-wrapper mt-3">
                                                        @if ($chartData['chartType'] == 'monthly')
                                                            <canvas id="campaignChartMonthly"></canvas>
                                                        @else
                                                            <canvas id="campaignChartWeekly"></canvas>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                        </div>
                    </div>
                </div>
            </div>
            @include('template.copyright')
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    <!-- Chart rendering script -->
                                <script>
                                    (function($) {
                                        'use strict';
                                        $(function() {
                                            const monthlyChartData = @json($chartData['monthlyTotals']);
                                            const weeklyChartData = @json($chartData['weeklyTotals']);

                                            @if ($chartData['chartType'] == 'monthly')
                                                // Chart Bulanan
                                                const monthlyCanvas = document.getElementById('campaignChartMonthly');
                                                new Chart(monthlyCanvas, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
                                                        datasets: [{
                                                            label: 'Donations per Month',
                                                            data: monthlyChartData,
                                                            backgroundColor: "#52CDFF",
                                                            borderColor: "#52CDFF",
                                                            borderWidth: 0,
                                                            barPercentage: 0.35,
                                                            fill: true,
                                                        }]
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true
                                                            }
                                                        }
                                                    }
                                                });
                                            @else
                                                // Chart Mingguan
                                                const weeklyCanvas = document.getElementById('campaignChartWeekly');
                                                new Chart(weeklyCanvas, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: ["Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4"],
                                                        datasets: [{
                                                            label: 'Donations per Week',
                                                            data: weeklyChartData,
                                                            backgroundColor: "#FFCD52",
                                                            borderColor: "#FFCD52",
                                                            borderWidth: 0,
                                                            barPercentage: 0.35,
                                                            fill: true,
                                                        }]
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true
                                                            }
                                                        }
                                                    }
                                                });
                                            @endif
                                        });
                                    })(jQuery);
                                </script>
</div>
@include('template.footer')