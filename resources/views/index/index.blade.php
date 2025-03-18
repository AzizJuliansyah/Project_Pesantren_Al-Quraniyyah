@include('template.header')
@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0">
      <div class="row w-100 mx-0">
        <div class="col-lg-5 mx-auto">
          
          {{-- <div class="content">
            <div>
              <h1 class="text-dark"><strong>Al-Quraniyyah</strong></h1>
              <div class="d-flex justify-content-center">
                <h3 class="text-dark col-lg-6 col-sm-12 mt-3">Transparansi Uang Kas dan Donasi Pesantren Al-Quraniyyah: Pantau Pengelolaan Dana dan Kontribusi Donasi Secara Real-Time.</h3>
              </div>
            </div>
          </div> --}}


          <!-- ***** Preloader Start ***** -->
          <div id="js-preloader" class="js-preloader">
            <div class="preloader-inner">
              <span class="dot"></span>
              <div class="dots">
                <span></span>
                <span></span>
                <span></span>
              </div>
            </div>
          </div>

          <div class="card shadow" style="background-color: #A7C7E7; margin-top: 100px;">
            <div class="card-body">
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    
                    <!-- Carousel Inner -->
                    <div class="carousel-inner">
                        @foreach ($campaignPilihan as $index => $item)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <a href="{{ route('campaignpayment.detail', $item->slug) }}" target="_blank">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="d-block w-100" alt="{{ $item->nama }}">
                                    @else
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png?20210521171500" class="d-block w-100" alt="No Image Available">
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Dots / Indicators (Ditempatkan DI BAWAH gambar) -->
                    <div class="carousel-indicators">
                        @foreach ($campaignPilihan as $index => $item)
                            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="{{ $index }}" 
                                class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" 
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                </div>
            </div>
          </div>

          <div class="card shadow mt-4" style="border-radius: 10px">
            <div class="card-body">
              <div class="row mt-3">
                <div class="d-flex justify-content-center">
                  <div class="d-flex align-items-center">
                    <h2 class="text-primary me-2 fw-bold">Rp {{ number_format($totalDonasi, 2, ',', '.') }}</h2>
                    <h6 class="text-muted"></h6>
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  <small class="text-muted mt-2 mb-2" style="font-size: 9pt">Donasi Terkumpul</small>
                </div>
                <div class="d-flex justify-content-around">
                  <div class="form-group">
                    <div class="d-flex justify-content-center">
                      <h3 class="text-info me-2 fw-bold">{{ number_format($totalCampaign, 0, ',', '.') }}</h3>
                    </div>
                    <div class="d-flex justify-content-center">
                      <small class="text-muted mt-2 mb-2" style="font-size: 9pt">Program Aktif</small>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-flex justify-content-center">
                      <h3 class="text-info me-2 fw-bold">{{ number_format($totalTransaksi, 0, ',', '.') }}</h3>
                    </div>
                    <div class="d-flex justify-content-center">
                      <small class="text-muted mt-2 mb-2" style="font-size: 9pt">Jumlah Donasi</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="text-center mt-5">
              <div class="section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
                <h4>Campaign - Campaign <em>Pilihan</em></h4>
                <img src="assets/assets_landingpage/images/heading-line-dec.png" alt="">
              </div>
            </div>
            <div class="d-flex justify-content-center mt-2">
              <div class="row">
                @foreach ($campaignPilihan as $item)
                    <a href="{{ route('campaignpayment.detail', $item->slug) }}" class="card shadow wow fadeInDown mb-2 ms-1 me-1" data-wow-duration="1s" data-wow-delay="0.5s" style="border-radius: 5px">
                      <div class="mt-3">
                        <div class="d-flex justify-content-around">
                          <div class="col-4">
                            @if($item->foto)
                              <img src="{{ asset('storage/' . $item->foto) }}" class="rounded img-fluid" width="10" alt="{{ $item->nama }}">
                            @else
                              <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png?20210521171500" class="rounded img-fluid" width="10" alt="No Image Available">
                            @endif
                          </div>
                          <div class="col-8">
                            <div class="form-group ms-3">
                              <div class="row">
                                <strong style="font-size: 10pt">{{ $item->nama }}</strong>
                                <small class="mt-3 mb-2" style="font-size: 10pt">Al-Quraniyyah</small>
                                <div class="form-group">
                                  <div class="d-flex align-items-center">
                                    <h6 class="text-primary"><strong>Rp {{ number_format($item->total_donasi, 0) }}</strong></h6>
                                    <small class="text-muted ms-2" style="font-size: 12px">Terkumpul</small>
                                  </div>
                                    <div class="progress mt-1" style="height: 6px">
                                        <div class="progress-bar progress-bar-striped" role="progressbar" 
                                                style="width: {{ $item->persen_donasi }}%;" 
                                                aria-valuenow="{{ $item->persen_donasi }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                @endforeach
              </div>
            </div>
          </div>



          <div class="row">
            <div class="text-center mt-5">
              <div class="section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
                <h4>Program Kebaikan <em>Lainnya</em></h4>
                <img src="assets/assets_landingpage/images/heading-line-dec.png" alt="">
              </div>
            </div>
          </div>
          <div class="d-flex">
            @forelse ($campaignSelainPilihan as $index => $item)
              <div class="col-6">
                  <div class="card shadow m-1" style="border-radius:5px">
                    @if($item->foto)
                      <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top img-fluid" alt="{{ $item->nama }}">
                    @else
                      <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png?20210521171500" class="card-img-top img-fluid" alt="No Image Available">
                    @endif
                      <div class="m-3">
                        <div class="row">
                          <strong style="font-size: 10pt">{{ $item->nama }}</strong>
                          <small class="mt-3 mb-2" style="font-size: 12px">Al-Quraniyyah</small>
                          <div class="form-group">
                                  <div class="d-flex align-items-center">
                                    <h6 class="text-primary"><strong>Rp {{ number_format($item->total_donasi, 0) }}</strong></h6>
                                    <small class="text-muted d-none d-lg-block d-md-block ms-2" style="font-size: 9pt">Terkumpul</small>
                                  </div>
                                    <div class="progress mt-1" style="height: 6px">
                                        <div class="progress-bar progress-bar-striped" role="progressbar" 
                                                style="width: {{ $item->persen_donasi }}%;" 
                                                aria-valuenow="{{ $item->persen_donasi }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                        </div>
                      </div>
                  </div>
              </div>
            @empty
                                
            @endforelse
          </div>


          <!-- ***** Header Area End ***** -->
          <div class="row" style="margin-top: -10px">
            <div id="about" class="about-us section">
              <div class="container">
                <div class="row">
                  <div class="col-lg-12 align-self-center">
                    <div class="section-heading">
                      <h4 class="outlined-text text-white">About <em>What We Do</em> &amp; Who We Are</h4>
                      <div class="card shadow">
                        <div class="card-body">
                          <p class="text-dark">{{ $text1->item }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <p class="text-dark">Pesantren Al-Quraniyyah mengajak Anda untuk turut serta dalam misi mulia kami. Bersama, kita dapat menciptakan perubahan nyata bagi generasi penerus dengan dukungan pendidikan yang berbasis Al-Qur'an dan kegiatan sosial yang bermanfaat.</p>
                        <div class="gradient-button">
                          <a href="/daftarcampaign" class="shadow">Ayo, Donasi Sekarang Juga <i class="fa fa-arrow-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="right-image">
                      @if($illustrator1->item)
                        @if(Storage::exists('public/' . $illustrator1->item))
                          <img src="{{ asset('storage/' . $illustrator1->item) }}" alt="Landing Page illustrator" />
                        @else
                          {{ $illustrator1->item }}
                        @endif
                      @else
                        <p>No image available</p>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
                    

          @if ($campaign->publish == 1)
            <div id="services" class="services section">
              <div class="container">
                <div class="row">
                  <div class="col-lg-8 offset-lg-2">
                    <div class="section-heading  wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
                      <h4>Detail Uangkas <em>Keseluruhan</em> &amp; Perangkatan</h4>
                      <img src="assets/assets_landingpage/images/heading-line-dec.png" alt="">
                      <p>Detail Total Dana Uang Kas Yang Sudah di Dapat.</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="container">
                <div class="row">
                  <div class="col-lg-8 mb-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="col-12" id="toogleTargetDonasi" style="cursor: pointer">
                                <div class="d-flex align-items-center">
                                    <p class="card-description">Filter Data By Tahun, Default adalah untuk <strong>semua tahun</strong></p>
                                    <i class="fa fa-chevron-down ms-2 mb-3" id="toggleIcon"></i>
                                </div>
                            </div>
                            <div class="form-group d-none" id="chartDonasi">
                                <div class="" style="max-height: 100%">
                                    <div class="form-group">
                                        <form action="/" method="get" id="filterForm">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-12 mb-3">
                                                    <select name="month" id="month" class="form-control text-dark">
                                                        <optgroup label="Filter Data By">
                                                          <option value="" selected>Semua Bulan</option>
                                                        </optgroup>
                                                        <optgroup label="Bulan">
                                                          <option value="1" @if(request('month')  == 1) selected @endif>Januari</option>
                                                          <option value="2" @if(request('month')  == 2) selected @endif>Februari</option>
                                                          <option value="3" @if(request('month')  == 3) selected @endif>Maret</option>
                                                          <option value="4" @if(request('month')  == 4) selected @endif>April</option>
                                                          <option value="5" @if(request('month')  == 5) selected @endif>Mei</option>
                                                          <option value="6" @if(request('month')  == 6) selected @endif>Juni</option>
                                                          <option value="7" @if(request('month')  == 7) selected @endif>Juli</option>
                                                          <option value="8" @if(request('month')  == 8) selected @endif>Agustus</option>
                                                          <option value="9" @if(request('month')  == 9) selected @endif>September</option>
                                                          <option value="10" @if(request('month')  == 10) selected @endif>Oktober</option>
                                                          <option value="11" @if(request('month')  == 11) selected @endif>November</option>
                                                          <option value="12" @if(request('month')  == 12) selected @endif>Desember</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-sm-12">
                                                  <div class="form-group">
                                                    <input type="number" name="year" id="year" value="{{ request('year') }}" class="form-control" min="2023" max="2100" step="1" placeholder="Tahun">
                                                  </div>
                                                </div>
                                                <div class="col-lg-4 col-sm-12">
                                                    <button type="submit" class="btn btn-md btn-primary text-light">Filter <i class="fa fa-filter"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @if(request()->has('month') || request()->has('year'))
                                  <div class="float-end me-3">
                                      <a href="/"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
                                  </div>
                                @endif      
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="service-item">
                      <div class="col-12">
                        <div class="row">
                            <div class="col-md-4 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12">
                                        <div class="">
                                          <div class="form-group mb-4">
                                            <h6 class="text-primary text-start mb-2">Total Uang Kas Yang Masuk</h6>
                                            <div class="d-flex align-items-center">
                                                <h4 class="me-2 fw-bold">Rp{{ number_format($saldoAwalUangKas, 2, ',', '.') }}</h4>
                                                <h6 class="me-4 text-muted mb-2">IDR</h6>
                                            </div>
                                          </div>
                                                                          
                                          <div class="form-group mb-4">
                                              <h6 class="text-danger text-start mb-2">Total Pengeluaran Uang Kas</h6>
                                              <div class="d-flex align-items-center">
                                                  <h4 class="me-2 fw-bold">Rp{{ number_format($pengeluaranTotalUangKas, 2, ',', '.') }}</h4>
                                                  <h6 class="me-4 text-muted mb-2">IDR</h6>
                                              </div>
                                          </div>
                                                                          
                                          <div class="form-group mb-4">
                                              <h6 class="text-success text-start mb-2">Total Saldo Uang Kas Sekarang</h6>
                                              <div class="d-flex align-items-center">
                                                  <h4 class="me-2 fw-bold">Rp{{ number_format($saldoAkhirUangKas, 2, ',', '.') }}</h4>
                                                  <h6 class="me-4 text-muted mb-2">IDR</h6>
                                              </div>
                                          </div>
                                        </div>
                                        <div class="form-group mt-3">
                                          <a href="{{ route('campaignpayment.show', $campaign->slug) }}" class="btn btn-info btn-lg text-white text-center d-flex align-items-center">Bayar Uang Kas Sekarang <i class="fa fa-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12">
                                        <div class="">
                                            <div class="" style="overflow-x: auto;">
                                                <div class="d-flex justify-content-between" style="max-height: 60px; white-space: nowrap;">
                                                    <div class="form-group">
                                                        <h3>Visual chart dari {{ $campaign['nama'] }}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                  @if ($chartData['chartType'] == 'yearly' || $chartData['chartType'] == 'all')
                                                    @if ($chartData['chartType'] == 'all')
                                                      <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk <strong>Semua Bulan</strong></p>
                                                    @elseif ($chartData['chartType'] == 'yearly')
                                                      <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk <strong>Tahun {{ $selectedYear }}</strong></p>
                                                    @endif
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-group">
                                                            <div class="d-flex align-items-center">
                                                              <h2 class="me-2 fw-bold mb-3">Rp{{ number_format($chartData['total'], 2, ',', '.') }}</h2>
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
                                                      <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk <strong>Bulan {{ $selectedMonthName }}</strong> di <strong>Tahun {{ $selectedYear }}</strong></p>
                                                    @elseif ($chartData['chartType'] == 'weekly')
                                                      <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk <strong>Bulan {{ $selectedMonthName }}</strong></p>
                                                    @endif
                                                    <div class="d-flex align-items-center">
                                                      <div class="form-group">
                                                          <div class="d-flex align-items-center">
                                                              <h2 class="me-2 fw-bold mb-3">Rp{{ number_format($chartData['totalWeekly'], 2, ',', '.') }}</h2>
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
                      <div class="row mt-2">
                        <div class="col-lg-12" id="totalUangKasPerAngkatan">
                            <div class="d-flex align-items-center" style="overflow-x: auto;">
                              @foreach ($totalUangKasPerAngkatan  as $indexx => $item)
                                <div class="col-lg-4 col-md-6 col-sm-12 mt-3 mb-3  me-3" style="  white-space: nowrap;">
                                    <div class="card card-rounded table-darkBGImg">
                                        <div class="card-body">
                                            <div class="col-sm-12">
                                                <h3 class="text-white upgrade-info mb-0"><span class="fw-bold">Angkatan Ke-</span>{{ $item['angkatan'] }}</h3>
                                                <h5 class="outlined-text upgrade-info mb-0 mt-2"><span class="fw-bold outlined-text">Rp </span>{{ number_format($item['totalUangKas'], 2, ',', '.') }}</h5>
                                                <div class="gradient-button mt-3">
                                                  <a href="{{ route('pembayaran.uangkas.angkatan', $item['angkatan_id']) }}">Detail <i class="fa fa-arrow-right ms-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              @endforeach
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif

          

            

          <div class="d-sm-flex justify-content-center">
              <span>Copyright © 2024. All rights reserved.</span>
          </div>

        </div>
        @include('template.homefooter')
      </div>
    </div>
        <!-- main-panel ends -->
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          const filterForm = document.querySelector('#filterForm');

          if (filterForm) {
              filterForm.addEventListener('submit', function(e) {
                  e.preventDefault();
                  
                  let formAction = filterForm.getAttribute('action');
                  let formData = new FormData(filterForm);
                  let params = new URLSearchParams(formData).toString();
                  let newUrl = `${formAction}?${params}#services`;
                  
                  window.location.href = newUrl;
              });
          }
      });
    </script>


    <script>
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

                const isSmallScreen = window.innerWidth < 768;

                @if ($chartData['chartType'] == 'yearly' || $chartData['chartType'] == 'all')
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
                    responsive: !isSmallScreen,
                    maintainAspectRatio: isSmallScreen,
                    scales: {
                        y: {
                        beginAtZero: true
                        }
                    }
                    }
                });
                @elseif ($chartData['chartType'] == 'monthInYear' || $chartData['chartType'] == 'weekly')
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
                    responsive: !isSmallScreen,
                    maintainAspectRatio: isSmallScreen,
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