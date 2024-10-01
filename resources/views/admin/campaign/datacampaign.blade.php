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
                            @foreach($chartData as $campaign_id => $data)
                                <div class="col-lg-6 d-flex flex-column mt-3">
                                    <div class="row flex-grow">
                                        <div class="col-12">
                                            <div class="card card-rounded shadow">
                                                <div class="card-body">
                                                    
                                                    <div class="d-sm-flex justify-content-between align-items-start">
                                                        <div class="form-group">
                                                            <h3>{{ $data['nama'] }}</h3>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-group">
                                                                    <a href="/campaign/detaildatacampaign/{{ encrypt($campaign_id) }}" class="btn btn-primary btn-md mb-0 me-2"><i class="fa fa-eye"></i></a>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-primary dropdown-toggle toggle-dark btn-md mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filter By </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                                            <h6 class="dropdown-header">Filter Data By</h6>
                                                                            <a href="/pembukuan" class="dropdown-item">Semua Bulan</a>
                                                                            <h6 class="dropdown-header">Daftar Bulan</h6>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=1">Januari</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=2">Februari</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=3">Maret</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=4">April</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=5">Mei</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=6">Juni</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=7">Juli</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=8">Agustus</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=9">September</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=10">Oktober</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=11">November</a>
                                                                            <a class="dropdown-item" href="/pembukuan?campaign_id={{ $campaign_id }}&month=12">Desember</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        @if ($data['chartType'] == 'monthly')
                                                            <p class="card-subtitle card-subtitle-dash">Rincian Dana Donasi Campaign Ini Untuk Semua Bulan</p>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="form-group">
                                                                    <div class="d-flex align-items-center">
                                                                        <h2 class="me-2 fw-bold">Rp{{ number_format($data['total'], 2, ',', '.') }}</h2>
                                                                        <h4 class="me-4">IDR</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        @if ($data['persentaseKenaikanBulanan'] > 0)
                                                                            <h4 class="text-success">
                                                                                (+{{ number_format($data['persentaseKenaikanBulanan'], 2) }}%)
                                                                            </h4>
                                                                        @else
                                                                            <h4 class="text-danger">
                                                                                ({{ number_format($data['persentaseKenaikanBulanan'], 2) }}%)
                                                                            </h4>
                                                                        @endif
                                                                        <p>Dari Bulan sebelumnya</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <p class="card-subtitle card-subtitle-dash">Rincian Dana Donasi Campaign Ini Untuk Bulan {{ $selectedMonthName }}</p>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="form-group">
                                                                    <div class="d-flex align-items-center">
                                                                        <h2 class="me-2 fw-bold">Rp{{ number_format($data['totalWeekly'], 2, ',', '.') }}</h2>
                                                                        <h4 class="me-4">IDR</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        @if ($data['persentaseKenaikanMingguan'] > 0)
                                                                            <h4 class="text-success">
                                                                                (+{{ number_format($data['persentaseKenaikanMingguan'], 2) }}%)
                                                                            </h4>
                                                                        @else
                                                                            <h4 class="text-danger">
                                                                                ({{ number_format($data['persentaseKenaikanMingguan'], 2) }}%)
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
                                                        @if ($data['chartType'] == 'monthly')
                                                            <canvas id="campaignChartMonthly_{{ $campaign_id }}"></canvas>
                                                        @else
                                                            <canvas id="campaignChartWeekly_{{ $campaign_id }}"></canvas>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chart rendering script -->
                                <script>
                                    (function($) {
                                        'use strict';
                                        $(function() {
                                            const monthlyChartData = @json($data['monthlyTotals']);
                                            const weeklyChartData = @json($data['weeklyTotals']);

                                            @if ($data['chartType'] == 'monthly')
                                                // Chart Bulanan
                                                const monthlyCanvas = document.getElementById('campaignChartMonthly_{{ $campaign_id }}');
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
                                                const weeklyCanvas = document.getElementById('campaignChartWeekly_{{ $campaign_id }}');
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
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @include('template.copyright')
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
@include('template.footer')