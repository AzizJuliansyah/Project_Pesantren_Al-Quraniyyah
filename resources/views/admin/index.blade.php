@include('template.header')
    
@include('template.navbar')
@include('komponen.pesan')
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('template.sidebar')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                <div class="home-tab">
                  <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    
                  </div>
                  <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded table-darkBGImg">
                            <div class="card-body">
                              <div class="col-sm-8">
                                <h3 class="text-white upgrade-info mb-2"> Selamat datang <span class="fw-bold">{{ Auth::user()->name }}</span> di </h3>
                                <h5 class="text-white">Website pendataan alumni, uang kas, dan campaign Pesantren Al-Quraniyyah</h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>



                      <div class="row">
                        <div class="col-lg-12">
                          <div class="row">
                              <div class="col-md-4 d-flex flex-column">
                                  <div class="row flex-grow">
                                      <div class="col-12">
                                          <div class="card card-rounded shadow">
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
                                          <div class="form-group mt-3">
                                            <a href="/campaign/data" class="btn btn-info btn-lg text-white d-flex align-items-center ms-3"><i class="fa fa-arrow-left"></i> Lihat Semua Data Campaign</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                                  <div class="col-lg-8 d-flex flex-column">
                                      <div class="row flex-grow">
                                          <div class="col-12">
                                              <div class="card card-rounded shadow">
                                                  <div class="card-body">
                                                      <div class="d-flex justify-content-between" style="max-height: 60px">
                                                          <div class="form-group">
                                                              <h3>{{ $campaign['nama'] }}</h3>
                                                          </div>
                                                          <div class="form-group">
                                                              <div class="d-flex justify-content-between" style="max-height: 100%">
                                                                  <div class="form-group me-2">
                                                                      <a href="/uangkas" class="btn btn-primary btn-md text-light"><i class="fa fa-eye"></i></a>
                                                                  </div>
                                                                  <div class="form-group">
                                                                      <form action="/admin?campaign_id={{ $campaign->id }}" method="get">
                                                                          <div class="d-flex justify-content-between" style="max-height: 100%">
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
                                                                                  <button type="submit" class="btn btn-md btn-primary text-light">Filter <i class="fa fa-filter"></i></button>
                                                                              </div>
                                                                          </div>
                                                                      </form>
                                                                  </div>
                                                              </div>
                                                              @if(request()->has('month') || request()->has('year'))
                                                                  <div class="float-end me-3">
                                                                      <a href="{{ route('admin.index') }}"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
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


                      <div class="row">
                        <div class="col-sm-12">
                          <div class="statistics-details d-flex align-items-center justify-content-between">
                            <div>
                              <p class="statistics-title">Total Alumni</p>
                              <h3 class="rate-percentage">{{ $totalAlumni }}</h3>
                            </div>
                            @foreach($status as $status)
                                <div>
                                  <p class="statistics-title">Total {{ $status->status }}</p>
                                  <h3 class="rate-percentage">{{ $status->alumni_count }}</h3>
                                </div>
                            @endforeach
                        </div>
                      </div>
                      <div class="row mt-3">
                        <div class="col-lg-8 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                              <div class="card card-rounded shadow">
                                <div class="card-body">
                                  <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                      <h4 class="card-title card-title-dash">Performance Line Chart</h4>
                                      <h5 class="card-subtitle card-subtitle-dash">Lorem Ipsum is simply dummy text of the printing</h5>
                                    </div>
                                    <div id="performanceLine-legend"></div>
                                  </div>
                                  <div class="chartjs-wrapper mt-4">
                                    <canvas id="performanceLine" width=""></canvas>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                              <div class="card card-rounded shadow">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <div class="d-flex justify-content-between align-items-center">
                                        <h6 class=" card-title-dash"><strong>Statistik Alumni Berdasarkan Status</strong></h6>
                                      </div>
                                      <div id="doughnutChart-legend" class="mb-2 mt-3 text-center" style="margin-left: -40px"></div>
                                      <div>
                                        <canvas class="my-auto" id="doughnutChart"></canvas>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-lg-8 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                              <div class="card card-rounded">
                                <div class="card-body">
                                  <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                      <h4 class="card-title card-title-dash">Market Overview</h4>
                                      <p class="card-subtitle card-subtitle-dash">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                                    </div>
                                    <div>
                                      <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> This month </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                          <h6 class="dropdown-header">Settings</h6>
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Separated link</a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                    <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                      <h2 class="me-2 fw-bold">$36,2531.00</h2>
                                      <h4 class="me-2">USD</h4>
                                      <h4 class="text-success">(+1.37%)</h4>
                                    </div>
                                    <div class="me-3">
                                      <div id="marketingOverview-legend"></div>
                                    </div>
                                  </div>
                                  <div class="chartjs-bar-wrapper mt-3">
                                    <canvas id="marketingOverview"></canvas>
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
              </div>
            </div>
          </div>
          @include('template.copyright')
        </div>
        <!-- main-panel ends -->
      </div>
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
      <!-- page-body-wrapper ends -->
    </div>
@include('template.footer')