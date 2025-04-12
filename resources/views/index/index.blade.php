@include('template.header')
@include('komponen.pesan')
<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex justify-content-center auth px-0">
      <div class="d-flex justify-content-center home-custom-col">
        <div class="donation-card p-0">
          @include('template.homenavbar')
            
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

            <div class="" style="margin-top: 70px">

              @php
                $item = \App\Models\Administrator::where('item_id', 4)->first();
            @endphp

            @if($item->item)
                @if(file_exists($item->item))
                    <div class="audio-container mt-3">
                      <button class="audio-button" id="audio-toggle">
                          <i class="fa fa-play ms-1"></i>
                      </button>
                      <audio id="bg-audio" class="home-audio-autoplay">
                          <source src="{{ asset($item->item) }}" type="audio/mp3">
                      </audio>
                  </div>
                @endif
            @endif
              

              <div id="carouselExample" class="carousel slide ms-3 me-3" data-bs-ride="carousel">
                      
                      <!-- Carousel Inner -->
                      <div class="carousel-inner">
                          @foreach ($campaignPilihan as $index => $item)
                              <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                  <a href="{{ route('campaignpayment.detail', $item->slug) }}" target="_blank">
                                      @if($item->foto)
                                          <img src="{{ asset($item->foto) }}" class="d-block img-shadow rounded w-100" alt="{{ $item->nama }}">
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


            <div class="card shadow ms-3 me-3 mt-4" style="background-image: url('{{ asset('images/item/bg-layer.png') }}'); background-size: cover; background-position: center; border-radius: 3px">
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

            <div class="card ms-3 me-3 mt-5" style="border-radius: 3px">
              {{-- <div class="text-center">
                <div class="section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
                  <h4>Campaign - Campaign <em>Pilihan</em></h4>
                  <img src="assets/assets_landingpage/images/heading-line-dec.png" alt="">
                </div>
              </div> --}}
              <div class="float-start m-3">
                <h6 class="mb-1"><strong>Terus Alirkan Kebaikan</strong></h6>
                <small>Dengan berbagai pilihan program kebaikan</small>
              </div>
              <div class="d-flex justify-content-center mb-2 ms-4 me-4">
                <div class="row">
                  @foreach ($campaignPilihan as $item)
                      <a href="{{ route('campaignpayment.detail', $item->slug) }}" class="card shadow mb-2" style="border-radius: 3px">
                        <div class="mt-3">
                          <div class="d-flex justify-content-around">
                            <div class="col-4 mb-3">
                              @if($item->foto)
                                <img src="{{ asset($item->foto) }}" class="rounded img-fluid" width="10" alt="{{ $item->nama }}">
                              @else
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png?20210521171500" class="rounded img-fluid" width="10" alt="No Image Available">
                              @endif
                            </div>
                            <div class="col-8">
                              <div class="form-group ms-3">
                                <div class="row">
                                  <div class="col-12">
                                    <h6 class="d-none d-lg-block"><strong>{{ $item->nama }}</strong></h6>
                                    <h6 class="d-block d-lg-none"><strong>{{ Str::limit($item->nama, 50, '...') }}</strong></h6>
                                  </div>
                                  <div class="d-flex align-items-center">
                                    <small class="mt-3 mb-2">Al-Quraniyyah</small>
                                    <img src="{{ asset('images/item/centang-biru.png') }}" style="max-width: 30px;height: auto; margin-top: 8px" alt="">
                                  </div>
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
                                    <div class="donatur-container">
                                        @foreach ($item->donatur as $donatur)
                                            <div class="donatur-avatar">{{ strtoupper(substr($donatur, 0, 1)) }}</div>
                                        @endforeach

                                        @if ($item->total_donatur > 3)
                                            <div class="donatur-more">+{{ $item->total_donatur - 3 }}</div>
                                        @endif
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



            <div class="row ms-3 me-3">
              <div class="text-center mt-5">
                <div class="section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
                  <h4 style="font-size: 20px">Program Kebaikan <em>Lainnya</em></h4>
                  <img src="assets/assets_landingpage/images/heading-line-dec.png" alt="">
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-center mt-3 ms-4 me-4">
              <div class="row">
                @foreach ($campaignSelainPilihan as $index => $item)
                  <a href="{{ route('campaignpayment.detail', $item->slug) }}" class="col-6 p-0">
                      <div class="card shadow m-1" style="border-radius:5px">
                        @if($item->foto)
                          <img src="{{ asset($item->foto) }}" class="card-img-top img-fluid" alt="{{ $item->nama }}">
                        @else
                          <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png?20210521171500" class="card-img-top img-fluid" alt="No Image Available">
                        @endif
                          <div class="m-3">
                            <div class="row">
                              <div class="col-12">
                                <h6 class="d-none d-lg-block"><strong>{{ Str::limit($item->nama, 50, '...') }}</strong></h6>
                                <h6 class="d-block d-lg-none"><strong>{{ Str::limit($item->nama, 20, '...') }}</strong></h6>
                              </div>
                              <div class="d-flex align-items-center">
                                <small class="mt-3 mb-2">Al-Quraniyyah</small>
                                <img src="{{ asset('images/item/centang-biru.png') }}" style="max-width: 30px;height: auto; margin-top: 8px" alt="">
                              </div>
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
                              <div class="donatur-container">
                                @foreach ($item->donatur as $donatur)
                                  <div class="donatur-avatar">{{ strtoupper(substr($donatur, 0, 1)) }}</div>
                                @endforeach
                                @if ($item->total_donatur > 3)
                                  <div class="donatur-more">+{{ $item->total_donatur - 3 }}</div>
                                @endif
                              </div>
                              </div>
                            </div>
                          </div>
                      </div>
                  </a> 
                @endforeach
              </div>
            </div>


            <!-- ***** Header Area End ***** -->
            <div class="row ms-3 me-3" style="margin-top: -50px">
              <div id="about" class="about-us section">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-12 align-self-center">
                      <div class="section-heading">
                        {{-- <h4 class="outlined-text text-white">About <em>What We Do</em> &amp; Who We Are</h4> --}}
                        <div class="card shadow">
                          <div class="card-body">
                            <p class="text-dark">{{ $text1->item }}</p>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <p class="text-dark">Pesantren Al-Quraniyyah mengajak Anda untuk turut serta dalam misi mulia kami. Bersama, kita dapat menciptakan perubahan nyata bagi generasi penerus dengan dukungan pendidikan yang berbasis Al-Qur'an dan kegiatan sosial yang bermanfaat.</p>
                          {{-- <div class="gradient-button">
                            <a href="/daftarcampaign" class="shadow">Ayo, Donasi Sekarang Juga <i class="fa fa-arrow-right"></i></a>
                          </div> --}}
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="right-image">
                        @if($illustrator1->item)
                          @if(file_exists($illustrator1->item))
                            <img src="{{ asset($illustrator1->item) }}" alt="Landing Page illustrator" />
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
                  
            <div class="card ms-3 me-3 shadow" style="border-radius: 5px">
              <div class="card-body">
                <div class="form-group">
                  <div class="row">
                    <div class="d-flex justify-content-center">
                      @php
                          $item = \App\Models\Administrator::where('item_id', 7)->first();
                      @endphp

                      @if($item->item)
                        @if(file_exists($item->item))
                            <img src="{{ asset($item->item) }}" class="img-fluid" style="max-width: 200px; height: auto;" width="20" alt="logo" />
                        @else
                            {{ $item->item }}
                        @endif
                      @else
                          <p>No image available</p>
                      @endif
                    </div>
                    <div class="d-flex justify-content-center">
                      @php
                          $item = \App\Models\Administrator::where('item_id', 8)->first();
                      @endphp

                      @if($item->item)
                      <h4 class="text-center mt-4"><strong>{{ $item->item }}</strong></h4>
                      @endif
                    </div>
                    <div class="d-flex justify-content-center">
                      @php
                          $item = \App\Models\Administrator::where('item_id', 9)->first();
                      @endphp

                      @if($item->item)
                      <span class="text-center text-muted mt-2" style="font-size: 10pt">{{ $item->item }}</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            

            <div class="mb-3" style="margin-top: -80px">
              @include('template.copyright')
            </div>

            <div class="d-flex justify-content-center">
              @include('template.homefooter')
            </div>
        </div>

          
        </div>
        </div>
      </div>
    </div>
        <!-- main-panel ends -->

    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
          var audio = document.getElementById("bg-audio");
          var audioButton = document.getElementById("audio-toggle");
          var icon = audioButton.querySelector("i");

          audio.addEventListener("ended", function () {
              setTimeout(() => {
                  audio.play();
              }, 5000);
          });

          function playAudioOnce() {
              audio.play().then(() => {
                  console.log("Audio started on user interaction");
                  
                  icon.classList.remove("fa-play", "ms-1");
                  icon.classList.add("fa-pause");

              }).catch(error => {
                  console.error("Autoplay failed:", error);
              });

              document.removeEventListener("click", playAudioOnce);
          }

          document.addEventListener("click", playAudioOnce);

          audioButton.addEventListener("click", function () {
              if (audio.paused) {
                  audio.play();
                  icon.classList.remove("fa-play", "ms-1");
                  icon.classList.add("fa-pause");
              } else {
                  audio.pause();
                  icon.classList.remove("fa-pause");
                  icon.classList.add("fa-play", "ms-1");
              }
          });
        });

        // function hasMonthInUrl() {
        //     const urlParams = new URLSearchParams(window.location.search);
        //     return urlParams.has('month');
        // }

        // document.getElementById('toogleTargetDonasi').addEventListener('click', function() {
        //     var chartDonasi = document.getElementById('chartDonasi');
        //     var toggleIcon = document.getElementById('toggleIcon');
        //     chartDonasi.classList.toggle('d-none');
        //     toggleIcon.classList.toggle('rotate-icon');
        // });

        // if (hasMonthInUrl()) {
        //     document.getElementById('chartDonasi').classList.remove('d-none');
        //     document.getElementById('toggleIcon').classList.add('rotate-icon');
        // }

        function updateWidth(targetClass) {
            var col = document.querySelector('.donation-card');
            var target = document.querySelector(`.${targetClass}`);
            
            if (col && target) {
                target.style.width = col.clientWidth + "px";
            }
        }
        function updateAllWidths() {
            updateWidth('footer-nav');
        }
        window.onload = updateAllWidths;
        window.onresize = updateAllWidths;
        
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

@include('template.footer')