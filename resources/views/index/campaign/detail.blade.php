@include('template.header')
@include('template.navbar')

@include('komponen.pesan')

<div class="container-scroller mt-5">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0 mt-3">
            <div class="row w-100 mx-0">
                <div class="col-lg-5 mx-auto">
                    <div class="card  py-5 px-4 px-sm-5 shadow">
                        <div class="card-header border-0 bg-transparent p-0 mb-2 mt-2">
                            <div class="form-group">
                                <a href="/daftarcampaign"><i class="fa fa-arrow-left me-2"></i>Kembali</a>
                            </div>
                            <div class="d-flex justify-content-center mb-2">
                                @if($campaign->foto)
                                    <img src="{{ asset('storage/' . $campaign->foto) }}" alt="{{ $campaign->nama }}" class="img-fluid" width="600">
                                @endif
                            </div>
                        </div>
                        <div class="card-body p-0 mt-2 mb-2">
                            <div class="form-group">
                                <div class="card-title">
                                    <h2 class="font-weight-bold"><strong>{{ $campaign->nama }}</strong></h2>
                                </div>
                            </div>
                            
                            <div class="divider"></div>

                            <div class="form-group">
                                <div class="col-12" id="toogleTargetDonasi" style="cursor: pointer">
                                    <h5 class="text-dark">
                                        @if ($campaign->id == 1)
                                            Uang Kas Terkumpul
                                        @else
                                            Donasi Terkumpul
                                        @endif 
                                        <i class="fa fa-chevron-down ms-2" id="toggleIcon"></i>
                                    </h5>
                                </div>
                                <div class="row d-none" id="chartDonasi">
                                    <div class="form-group">
                                        <h3 class="text-primary"><strong>Rp{{ number_format($totalDonasi, 0) }}</strong></h3>
                                        <div class="d-flex align-items-center">
                                            <p class="text-description me-2">Dari target :</p>
                                            <h5 class="text-dark"><strong>Rp{{ number_format($campaign->target, 0) }}</strong></h5>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped" role="progressbar" 
                                                style="width: {{ $percentage }}%;" 
                                                aria-valuenow="{{ $percentage }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                <div class="d-flex justify-content-center">
                                                    {{ number_format($percentage, 2) }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="float-end" style="max-height: 60px">
                                            <div class="row">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle toggle-dark btn-md mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filter By </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                        <h6 class="dropdown-header">Filter Data By</h6>
                                                        <a href="/donasi/detail/{{ $slug }}" class="dropdown-item">Semua Bulan</a>
                                                        <h6 class="dropdown-header">Daftar Bulan</h6>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=1">Januari</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=2">Februari</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=3">Maret</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=4">April</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=5">Mei</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=6">Juni</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=7">Juli</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=8">Agustus</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=9">September</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=10">Oktober</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=11">November</a>
                                                        <a class="dropdown-item" href="/donasi/detail/{{ $slug }}?month=12">Desember</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @if ($chartData['chartType'] == 'monthly')
                                                <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk Semua Bulan</p>
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
                                            @elseif ($chartData['chartType'] == 'weekly')
                                                <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk Bulan <strong>{{ $selectedMonthName }}</strong></p>
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
                                            @if ($chartData['chartType'] == 'monthly')
                                                <canvas id="campaignChartMonthly"></canvas>
                                            @elseif ($chartData['chartType'] == 'weekly')
                                                <canvas id="campaignChartWeekly"></canvas>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>
                            
                            <div class="form-group">
                                {!! $campaign->info !!}
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="sticky-button">
                                <a href="{{ route('campaignpayment.show', $campaign->slug) }}" class="btn btn-primary donasi-button">Donasi Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <script>
        window.addEventListener('scroll', function() {
            var footer = document.querySelector('footer');
            var stickyButton = document.querySelector('.sticky-button');
            var footerTop = footer.getBoundingClientRect().top;
            var windowHeight = window.innerHeight;

            if (footerTop <= windowHeight) {
                stickyButton.style.position = 'relative';
                stickyButton.style.bottom = 'auto';
            } else {
                stickyButton.style.position = 'fixed';
                stickyButton.style.bottom = '5px';
            }
        });

        function hasMonthInUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.has('month');
        }

        document.getElementById('toogleTargetDonasi').addEventListener('click', function() {
            var chartDonasi = document.getElementById('chartDonasi');
            var toggleIcon = document.getElementById('toggleIcon');
            chartDonasi.classList.toggle('d-none');
            toggleIcon.classList.toggle('rotate-icon');
        });

        if (hasMonthInUrl()) {
            document.getElementById('chartDonasi').classList.remove('d-none');
            document.getElementById('toggleIcon').classList.add('rotate-icon');
        }
    </script>

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
            @elseif ($chartData['chartType'] == 'weekly')
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
    @include('template.copyright')
</div>
@include('template.footer')