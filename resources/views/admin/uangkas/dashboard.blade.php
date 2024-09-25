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
                                                        <h2 class="me-2 fw-bold">Rp{{ number_format($saldoAwalUangKas, 2, ',', '.') }}</h2>
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
                                                        <h2 class="me-2 fw-bold">Rp{{ number_format($saldoAkhirUangKas, 2, ',', '.') }}</h2>
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
                                                    <div class="d-flex justify-content-between">
                                                        <div class="form-group">
                                                            <h3>{{ $campaign['nama'] }}</h3>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="form-group me-2">
                                                                    <a href="/uangkas" class="btn btn-primary btn-md "><i class="fa fa-eye"></i></a>
                                                                </div>
                                                                <div class="form-group me-2">
                                                                    <form action="/dashboard/uangkas?campaign_id={{ $campaign->id }}" method="get">
                                                                        <div class="d-flex justify-content-between">
                                                                            <div class="form-group me-2">
                                                                                <select name="month" id="month" class="form-control">
                                                                                    <optgroup label="Filter Data By">
                                                                                        <option value="">Semua Bulan</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Bulan">
                                                                                        <option value="1">Januari</option>
                                                                                        <option value="2">Februari</option>
                                                                                        <option value="3">Maret</option>
                                                                                        <option value="4">April</option>
                                                                                        <option value="5">Mei</option>
                                                                                        <option value="6">Juni</option>
                                                                                        <option value="7">Juli</option>
                                                                                        <option value="8">Agustus</option>
                                                                                        <option value="9">September</option>
                                                                                        <option value="10">Oktober</option>
                                                                                        <option value="11">November</option>
                                                                                        <option value="12">Desember</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group me-2">
                                                                                <div class="form-group">
                                                                                    <input type="number" name="year" id="year" class="form-control" style="max-width: 6.5rem" min="2023" max="2100" step="1" placeholder="Tahun">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <button type="submit" class="btn btn-md btn-primary">Filter <i class="fa fa-filter"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            @if(request()->has('month') || request()->has('year'))
                                                                <div class="float-end me-2">
                                                                    <a href="{{ route('dashboard.uangkas') }}"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        @if ($chartData['chartType'] == 'yearly' || $chartData['chartType'] == 'all')
                                                            @if ($chartData['chartType'] == 'all')
                                                                <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk Semua Bulan</p>
                                                            @elseif ($chartData['chartType'] == 'yearly')
                                                                <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk Tahun <strong>{{ $selectedYear }}</strong></p>
                                                            @endif
                                                            <div class="d-flex aign-items-center">
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
                                                        @elseif ($chartData['chartType'] == 'monthInYear' || $chartData['chartType'] == 'weekly')
                                                            @if ($chartData['chartType'] == 'monthInYear')
                                                                <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk Bulan <strong>{{ $selectedMonthName }}</strong> di Tahun <strong>{{ $selectedYear }}</strong></p>
                                                            @elseif ($chartData['chartType'] == 'weekly')
                                                                <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk Bulan <strong>{{ $selectedMonthName }}</strong></p>
                                                            @endif
                                                            <div class="d-flex aign-items-center">
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
                                                        @if ($chartData['chartType'] == 'yearly' || $chartData['chartType'] == 'all')
                                                            <canvas id="campaignChartMonthly"></canvas>
                                                        @elseif ($chartData['chartType'] == 'monthInYear' || $chartData['chartType'] == 'weekly')
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

                                            @if ( $chartData['chartType'] == 'yearly' || $chartData['chartType'] == 'all')
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
                                            @elseif ($chartData['chartType'] == 'monthInYear' || $chartData['chartType'] == 'weekly')
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