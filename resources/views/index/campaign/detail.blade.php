@include('template.header')

@include('komponen.pesan')

<div class="container-scroller mt-5">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex justify-content-center auth px-0">
            <div class="d-flex justify-content-center custom-col">
                <div class="donation-card p-0">
                    <div class="card card-fixed p-0 shadow bg-transparent" style="border-radius: 1px">
                        <div class="m-3">
                            <div class="d-flex align-items-center">
                                <a href="/daftarcampaign" class="text-dark d-flex align-items-center">
                                    <i class="mdi-icon mdi mdi-chevron-left"></i>
                                    <i class="mdi-icon mdi mdi-home"></i>
                                </a>
                                <small class="truncate-text ms-4"><strong>{{ $campaign->nama }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="card p-0 shadow" style="border-radius: 3px">
                        <div class="form-group" style="margin-bottom: -2px">
                            <div class="d-flex justify-content-center">
                                @if($campaign->foto)
                                    <img src="{{ asset($campaign->foto) }}" alt="{{ $campaign->nama }}" class="img-fluid" width="100%">
                                @else
                                    <p>Image not available</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group ms-3 me-3">
                            <div class="divider"></div>

                            <div class="form-group" style="margin-bottom: -3px">
                                @if ($campaign->tampilkan_video == 1)
                                    @if($campaign->video)
                                        <video width="100%" controls class="shadow">
                                            <source src="{{ asset($campaign->video) }}" type="video/mp4">
                                            Browser Anda tidak mendukung pemutaran video.
                                        </video>
                                    @endif
                                @endif
                            </div>
                            <div class="divider"></div>

                            <div class="form-group" style="margin-bottom: -25px">
                                <div class="card-title">
                                    <h4 class="font-weight-bold"><strong>{{ $campaign->nama }}</strong></h4>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="card p-0 mt-2 shadow" style="border-radius: 3px">
                        <div class="form-group ms-3 me-3 mt-3">
                            <div class="form-group" style="margin-bottom: -5px">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="d-flex align-items-center">
                                                <h5 class="text-primary me-3"><strong>Rp{{ number_format($totalDonasi, 0) }}</strong></h5>
                                                <small class="text-description me-2">Terkumpul dari</small>
                                                <small class="text-dark"><strong>Rp{{ number_format($campaign->target, 0) }}</strong></small>
                                            </div>
                                            <div class="progress" style="height: 10px">
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
                                    </div>
                                </div>
                                <div class="col-12" id="toogleTargetDonasi" style="cursor: pointer">
                                    <h5 class="text-dark">
                                        @if ($campaign->id == 1)
                                            Uang Kas Terkumpul
                                        @else
                                           Detail
                                        @endif 
                                        <i class="fa fa-chevron-down ms-2" id="toggleIcon"></i>
                                    </h5>
                                </div>
                                <div class="row d-none" id="chartDonasi">
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
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            @if ($chartData['chartType'] == 'monthly')
                                                <p class="card-subtitle card-subtitle-dash">Rincian Dana Uang Kas Untuk Semua Bulan</p>
                                                <div class="row">
                                                    <div class="col-lg-8 col-sm-12">
                                                        <div class="d-flex align-items-center">
                                                            <h2 class="me-2 fw-bold">Rp{{ number_format($chartData['total'], 2, ',', '.') }}</h2>
                                                            <h4 class="me-4">IDR</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-12">
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
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-12">
                                                        <div class="d-flex align-items-center">
                                                            <h2 class="me-2 fw-bold">Rp{{ number_format($chartData['totalWeekly'], 2, ',', '.') }}</h2>
                                                            <h4 class="me-4">IDR</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-12">
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

                                <a href="{{ route('campaignpayment.show', $campaign->slug) }}" class="col-12 btn btn-success">Donasi Sekarang!</a>
                            </div>
                        </div>
                    </div>

                    <div class="card p-0 mt-2 shadow" style="border-radius: 3px">
                        <div class="row m-3">
                            <div class="form-group" >
                                <h4><strong>Penggalang Dana</strong></h4>
                            </div>
                            <div class="form-group" style="margin-bottom: -10px;margin-top: -10px">
                                <div class="d-flex align-items-center">
                                    <div class="form-group">
                                        @php
                                            $item = \App\Models\Administrator::where('item_id', 1)->first();
                                        @endphp

                                        @if($item->item)
                                            @if(file_exists($item->item))
                                                <img src="{{ asset($item->item) }}" class="img-fluid rounded-circle border border-dark border-1" style="max-width: 55px" alt="logo Al-Quraniyyah" />
                                            @else
                                                 {{ $item->item }}
                                            @endif
                                        @endif
                                    </div>
                                    <div class="form-group ms-3">
                                        <div class="row">
                                            <h6 class="text-info"><strong>Al - Quraniyyah</strong></h6>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('images/item/verified.png') }}" style="max-width: 40px;height: auto" alt="">
                                                <small class="text-muted ms-2"><i>Verified Organization</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card p-0 mt-2 shadow" style="border-radius: 3px">
                        <div class="m-3">
                            <div class="divider"></div>
                            
                            <div class="form-group ckeditor-content">
                                {!! $campaign->info !!}
                            </div>

                            <div class="divider"></div>
                        </div>
                    </div>

                    <div class="card shadow mt-1" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <a href="{{ route('campaignpayment.yangdonasi', $campaign->slug) }}" class="text-dark mb-3">
                                    <div class="float-start">
                                        Donatur <span class="btn btn-sm btn-inverse-info ms-3">{{ number_format($totalyangDonasi, 0, '.') }}</span>
                                    </div>
                                    <div class="float-end">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </div>
                            @forelse ($yangDonasi as $index => $item)
                                <div class="donation-box">
                                    <img src="{{ asset('assets/images/default_profile.png') }}" alt="Avatar">
                                    <div class="donation-content">
                                        <div class="name">{{ $item->nama }}</div>
                                        <div class="amount">Berdonasi sebesar <strong>Rp {{ number_format($item->nominal2, 2, ',', '.') }}</strong></div>
                                        <div class="time">{{ $item->time_difference  }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center">Belum ada donasi.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="card shadow" >
                        <div class="card-footer shadow card-footer-fixed" style="border-radius: 3px;margin-bottom: -10px">
                            <div class="d-flex align-items-center">
                                <div class="share-options" id="shareOptions">
                                    <p>Bagikan melalui: <span onclick="toggleShareOptions()" class="close-btn">✖ Close</span></p>
                                    <button onclick="copyLink()"> <i class="mdi mdi-icon mdi-content-copy"></i> </button>
                                    <button onclick="shareWhatsApp()"> <i class="mdi mdi-icon mdi-whatsapp"></i> </button>
                                    <button onclick="shareFacebook()"> <i class="mdi mdi-icon mdi-facebook"></i> </button>
                                    <button onclick="shareTwitter()"> <i class="mdi mdi-icon mdi-twitter"></i> </button>
                                    <button onclick="shareTelegram()"> <i class="fa fa-telegram"></i> </button>
                                </div>
                                <button class="col-4 me-2 btn btn-outline-primary" onclick="toggleShareOptions()"><i class="mdi mdi-icon mdi-share-variant"></i> Share</button>
                                <a href="{{ route('campaignpayment.show', $campaign->slug) }}" class="col-8 btn btn-success">Donasi Sekarang!</a>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        @include('template.copyright')
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
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

    <script>
        window.addEventListener("scroll", function () {
            var footer = document.querySelector(".card-footer-fixed");
            var scrollThreshold = 500; // Ubah angka ini untuk menentukan kapan footer muncul

            if (window.scrollY > scrollThreshold) { 
                footer.classList.add("show");
            } else {
                footer.classList.remove("show"); 
            }
        });



        function updateWidth(targetClass) {
            var col = document.querySelector('.donation-card');
            var target = document.querySelector(`.${targetClass}`);
            
            if (col && target) {
                target.style.width = col.clientWidth + "px";
            }
        }

        function updateAllWidths() {
            updateWidth('card-fixed');
            updateWidth('card-footer-fixed');
        }

        window.onload = updateAllWidths;
        window.onresize = updateAllWidths;


        function toggleShareOptions() {
            var shareBox = document.getElementById("shareOptions");
            
            if (!shareBox) return; // Cegah error jika shareBox tidak ada

            if (shareBox.style.display === "block") {
                shareBox.style.display = "none";
                document.removeEventListener("click", closeOnClickOutside);
            } else {
                shareBox.style.display = "block";

                // Tambahkan event listener untuk menutup saat klik di luar
                setTimeout(() => {
                    document.addEventListener("click", closeOnClickOutside);
                }, 100);
            }
        }

        // Fungsi untuk menutup saat klik di luar share box
        function closeOnClickOutside(event) {
            var shareBox = document.getElementById("shareOptions");
            var shareButton = document.querySelector(".share-button");

            if (!shareBox || !shareButton) return; // Cegah error jika elemen tidak ditemukan

            if (!shareBox.contains(event.target) && !shareButton.contains(event.target)) {
                shareBox.style.display = "none";
                document.removeEventListener("click", closeOnClickOutside);
            }
        }

        // Copy Link ke Clipboard
        function copyLink() {
            var link = window.location.href;
            navigator.clipboard.writeText(link).then(() => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-right',
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast',
                    },
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                })

                ;(async () => {
                    Toast.fire({
                        icon: 'success',
                        title: "Link Telah disalin",
                    })
                })()
            });
            document.getElementById("shareOptions").style.display = "none";
        }

        // Share ke WhatsApp
        function shareWhatsApp() {
            var url = encodeURIComponent(window.location.href);
            window.open("https://wa.me/?text=" + url, "_blank");
            document.getElementById("shareOptions").style.display = "none";
        }

        // Share ke Facebook
        function shareFacebook() {
            var url = encodeURIComponent(window.location.href);
            window.open("https://www.facebook.com/sharer/sharer.php?u=" + url, "_blank");
            document.getElementById("shareOptions").style.display = "none";
        }

        // Share ke Twitter (X)
        function shareTwitter() {
            var url = encodeURIComponent(window.location.href);
            window.open("https://twitter.com/intent/tweet?url=" + url, "_blank");
            document.getElementById("shareOptions").style.display = "none";
        }

        // Share ke Telegram
        function shareTelegram() {
            var url = encodeURIComponent(window.location.href);
            window.open("https://t.me/share/url?url=" + url, "_blank");
            document.getElementById("shareOptions").style.display = "none";
        }

        function closeShareBox() {
            var shareBox = document.getElementById("shareOptions");
            if (shareBox) {
                shareBox.style.display = "none";
            }
            document.removeEventListener("click", closeOnClickOutside);
        }

    </script>
</div>
@include('template.footer')