@include('template.header')
@include('template.navbar')

@include('komponen.pesan')

<div class="container-scroller mt-5">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0 mt-5">
            <div class="row w-100 mx-0">
                <div class="col-lg-10 mx-auto">
                    <div class="row">
                        <a href="/pembayaran/uangkas" class="mb-2"><i class="fa fa-arrow-left me-1"></i> Kembali</a>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12">
                                    <div class="card card-rounded shadow">
                                        <div class="card-body" style="overflow-x: auto;">
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12" style="white-space: nowrap;">
                                                    <h3>{{ $campaign['nama'] }} Angkata Ke - {{ $angkatan->angkatan }}</h3>
                                                </div>
                                                <div class="col-lg-6 col-sm-12" style="white-space: nowrap;">
                                                    <div class="float-start">
                                                        <div class="form-group">
                                                            <form action="/pembayaran/uangkas/angkatan/{{ $angkatan_id }}" method="get">
                                                                <div class="d-flex justify-content-between" style="max-height: 100%">
                                                                    <div class="form-group me-2">
                                                                        <select name="month" id="month" class="form-control" style="min-width: 6.5rem">
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
                                                                            <input type="number" name="year" id="year" class="form-control" style="max-width: 6.5rem;min-width: 6.5rem;" min="2023" max="2100" step="1" placeholder="Tahun">
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
                                                        <div class="float-end me-1">
                                                            <a href="{{ route('pembayaran.uangkas.angkatan', $angkatan_id) }}"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
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
                    <div class="card mb-3 mt-5 shadow">
                        <div class="card-body">
                        <a  id="toggleFilterButton" class="text-dark normal-link">
                            <div class="d-flex align-items-center ">
                            <h4 class="me-2">Filter Table Berdasarkan</h4>
                            @if ($hasFilters)
                                <i class="fa fa-chevron-up"></i>
                            @else
                                <i class="fa fa-chevron-down mb-2"></i>
                            @endif
                            </div>
                        </a>
                            <form action="{{ route('pembayaran.uangkas.angkatan', $angkatan_id) }}" method="get" id="filterForm" class="{{ !$hasFilters ? 'd-none' : '' }}">
                            <div class="row">
                                <div class="col-md-4">
                                <div class="form-group row">
                                    <label>Pencarian Berdasarkan Order ID</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="order_id" id="order_id" value="{{ request('order_id') }}" placeholder="Cari Order ID...">
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-4">
                                <div class="form-group row">
                                    <label>Pencarian Berdasarkan Nama Alumni</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="nama" id="nama" value="{{ request('nama') }}" placeholder="Cari nama...">
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-4">
                                <div class="form-group row">
                                    <label>Pencarian Berdasarkan Tahun Pembayaran</label>
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="tahun" id="tahun" min="2023" max="2100" value="{{ request('tahun') }}" placeholder="Tahun">
                                    </div>
                                </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2" id="filterButton" disabled>Filter / Cari</button>
                            @if ($hasFilters)
                                <a href="{{ route('pembayaran.uangkas.angkatan', $angkatan_id) }}" class="btn btn-primary">Kembali</a>
                            @endif
                            </form>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card shadow">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="form-group mt-3">
                                        <label><input type="checkbox" id="showPendingError"> Tampilkan transaksi pending dan error</label>
                                        </div>
                                        <div class="table-responsive">
                                            @if ($donasiByOrderId->isNotEmpty())
                                                <h4 class="card-title float-start">Pembayaran Uangkas Berdasarkan Order ID</h4>
                                                <table class="table table-striped table-bordered mb-5">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Order ID</th>
                                                            <th>Nama</th>
                                                            <th>Nominal</th>
                                                            <th>Status</th>
                                                            <th>Tanggal Donasi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($donasiByOrderId as $index => $donasi)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $donasi->order_id }}</td>
                                                                <td>{{ $donasi->alumni->nama }}</td>
                                                                <td>Rp{{ number_format($donasi->nominal2, 0, ',', '.') }}</td>
                                                                <td>
                                                                    @if ($donasi->status == 'success')
                                                                        <p class="text-success">{{ $donasi->status }}</p>
                                                                    @elseif ($donasi->status == 'pending')
                                                                        <p class="text-warning">{{ $donasi->status }}</p>
                                                                    @elseif ($donasi->status == 'error')
                                                                        <p class="text-danger">{{ $donasi->status }}</p>
                                                                    @else
                                                                        <p>Unknown</p>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $donasi->created_at->format('H:i, d-F-Y') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                
                                            @else
                                                @if (request('order_id') !== null)
                                                    <h3>Donasi Berdasarkan Order ID</h3>
                                                    <table class="table table-hover mb-5">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Order ID</th>
                                                                <th>Nama</th>
                                                                <th>Nominal</th>
                                                                <th>Status</th>
                                                                <th>Tanggal Donasi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="6">
                                                                    <div class="alert alert-warning" role="alert">
                                                                        Tidak ada pembayaran uang kas yang ditemukan dengan Order ID "{{ request('order_id') }}".
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    
                                                @endif
                                            @endif
                                            <div class="divider"></div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <h4 class="card-title float-start">Daftar Nama-Nama di Angkata Ke - {{ $angkatan->angkatan }}</h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{ $alumni->links() }}
                                            </div>
                                            <table id="" class="table table-hover table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama</th>
                                                        <th colspan="2">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($alumni as $index => $item)
                                                        @php
                                                            $hasSuccess = $item->donasi->where('status', 'success')->isNotEmpty();
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $item->nama }}</td>
                                                            <td>
                                                                @if ($item->donasi->isNotEmpty())
                                                                    <button type="button" class="btn btn-{{ $hasSuccess ? 'success' : 'danger' }} btn-md toggle-donasi" data-target="donasi-{{ $index }}">
                                                                        Lihat Detail Uang Kas <i class="fa fa-chevron-down"></i>
                                                                    </button>
                                                                @else
                                                                    <button type="button" class="btn btn-danger btn-md">Belum Bayar Uang Kas</button>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <tr class="donasi-row d-none" id="donasi-{{ $index }}">
                                                                    <td></td>
                                                                    <td colspan="3">
                                                                        <table class="table table-striped table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Order ID</th>
                                                                                    <th>Nominal</th>
                                                                                    <th>Status</th>
                                                                                    <th>Tanggal Bayar Uang Kas</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($item->donasi as $donasiIndex => $donasi)
                                                                                    <tr class="{{ $donasi->status == 'success' ? '' : 'd-none' }} donasi-row-status" data-status="{{ $donasi->status }}">
                                                                                        <td>{{ $donasiIndex + 1 }}</td>
                                                                                        <td>
                                                                                            <h5 class="text-dark" onclick="copyToClipboard('{{ $donasi->order_id }}')" style="cursor: pointer;">
                                                                                                {{ $donasi->order_id }}
                                                                                                <i class="mdi mdi-content-copy" style="margin-left: 5px;"></i>
                                                                                            </h5>
                                                                                        </td>
                                                                                        <td>Rp{{ number_format($donasi->nominal, 0, ',', '.') }}</td>
                                                                                        <td>
                                                                                            @if ($donasi->status == 'success')
                                                                                                <p class="text-success">{{ $donasi->status }}</p>
                                                                                            @elseif ($donasi->status == 'pending')
                                                                                                <p class="text-warning">{{ $donasi->status }}</p>
                                                                                            @elseif ($donasi->status == 'error')
                                                                                                <p class="text-danger">{{ $donasi->status }}</p>
                                                                                            @else
                                                                                                <p>Unknown</p>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>{{ $donasi->created_at->format('H:i, d-F-Y') }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="alert alert-warning" role="alert">
                                                                    Tidak ada pembayaran uang kas yang ditemukan dengan nama "{{ request('nama') }}".
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            
                                            <div class="row mt-3">
                                                {{ $alumni->links() }}
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <div class="sticky-button">
                            <a href="{{ route('campaignpayment.show', $campaign->slug) }}" class="btn btn-primary donasi-button">Bayar Uang Kas Sekarang</a>
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
    </script>

    <script>
      new DataTable('#UangKasTable', {
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
      });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterForm = document.getElementById('filterForm');
            const toggleFilterButton = document.getElementById('toggleFilterButton');
            const filterButton = document.getElementById('filterButton');

            toggleFilterButton.addEventListener('click', function () {
                if (filterForm.classList.contains('d-none')) {
                    filterForm.classList.remove('d-none');
                    toggleFilterButton.innerHTML = `
                    <div class="d-flex align-items-center ">
                        <h4 class="me-2">Filter Data Berdasarkan</h4>
                        <i class="fa fa-chevron-up mb-2"></i>
                    </div>
                    `;
                } else {
                    filterForm.classList.add('d-none');
                    toggleFilterButton.innerHTML = `
                    <div class="d-flex align-items-center ">
                        <h4 class="me-2">Filter Data Berdasarkan</h4>
                        <i class="fa fa-chevron-down mb-2"></i>
                    </div>
                    `;
                }
                validateForm();
            });

            function validateForm() {
                const tahun = document.getElementById('tahun').value;
                const nama = document.getElementById('nama').value;
                const order_id = document.getElementById('order_id').value;
                
                if (nama || order_id || tahun) {
                    filterButton.disabled = false;
                } else {
                    filterButton.disabled = true;
                }
            }

            document.getElementById('tahun').addEventListener('input', validateForm);
            document.getElementById('nama').addEventListener('input', validateForm);
            document.getElementById('order_id').addEventListener('input', validateForm);


            function formatNumber(number) {
              return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function formatInput(selector) {
                $(selector).on('input', function() {
                    let input = $(this).val();
                    let numericValue = input.replace(/[^0-9]/g, '');
                    let formattedValue = formatNumber(numericValue);
                    $(this).val(formattedValue);
                });
            }

            formatInput('#nominal');

            $('form').on('submit', function() {
                $('#nominal').val(function(index, value) {
                    return value.replace(/\./g, '');
                });
            });


            document.querySelectorAll('.toggle-donasi').forEach(function(button) {
              button.addEventListener('click', function() {
                  const targetId = this.getAttribute('data-target');
                  const targetRow = document.getElementById(targetId);
                  targetRow.classList.toggle('d-none');
                  const icon = this.querySelector('i');
                  icon.classList.toggle('fa-chevron-down');
                  icon.classList.toggle('fa-chevron-up');
              });
            });

            document.getElementById('showPendingError').addEventListener('change', function() {
              const showPendingError = this.checked;

              document.querySelectorAll('.donasi-row-status').forEach(function(row) {
                  const status = row.getAttribute('data-status');
                  if (status === 'success') {
                      row.classList.remove('d-none');
                  } else if (status === 'pending' || status === 'error') {
                      if (showPendingError) {
                          row.classList.remove('d-none');
                      } else {
                          row.classList.add('d-none');
                      }
                  }
              });
            });
            

        });

        

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 2800,
            timerProgressBar: true,
        });

        function copyToClipboard(orderId) {
            navigator.clipboard.writeText(orderId).then(() => {
                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil Meng Copy Order ID!',
                });
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        }

    </script>

    <script>
        (function($) {
            'use strict';
            $(function() {
                const monthlyChartData = @json($chartData['monthlyTotals']);
                const weeklyChartData = @json($chartData['weeklyTotals']);

                const isSmallScreen = window.innerWidth < 768;

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
                    responsive: !isSmallScreen, // Non-responsif di layar kecil
                    maintainAspectRatio: isSmallScreen, // Hanya pertahankan aspect ratio di layar kecil
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
                    responsive: !isSmallScreen, // Non-responsif di layar kecil
                    maintainAspectRatio: isSmallScreen, // Hanya pertahankan aspect ratio di layar kecil
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