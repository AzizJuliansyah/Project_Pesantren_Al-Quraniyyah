@include('template.header')
@php
    use Carbon\Carbon;
@endphp
@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        @include('template.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
              <div class="card mb-5">
                <div class="card-body">
                  <a  id="toggleFilterButton" class="text-dark normal-link">
                    <div class="d-flex align-items-center ">
                      <h4 class="me-2">Filter Data Berdasarkan</h4>
                      @if ($hasFilters)
                        <i class="fa fa-chevron-up"></i>
                      @else
                        <i class="fa fa-chevron-down mb-2"></i>
                      @endif
                    </div>
                  </a>
                    <form action="{{ route('detail.uangkas', $angkatan_id) }}" method="get" id="filterForm" class="{{ !$hasFilters ? 'd-none' : '' }}">
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
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label>Tanggal donasi, Dari</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="dari" id="dari" value="{{ request('dari') }}">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label>Tanggal donasi, Hingga</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="hingga" id="hingga" value="{{ request('hingga') }}">
                            </div>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary me-2" id="filterButton" disabled>Filter / Cari</button>
                      @if ($hasFilters)
                        <a href="{{ route('detail.uangkas', $angkatan_id) }}" class="btn btn-primary">Kembali</a>
                      @endif
                    </form>
                </div>
              </div>
              
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group">
                                        <h4 class="card-title float-start">Daftar Nama-Nama di Angkata Ke - {{ $angkatan->angkatan }}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="form-group mt-3">
                                      <label><input type="checkbox" id="showPendingError"> Tampilkan transaksi pending dan error</label>
                                  </div>
                                    <div class="table-responsive">
                                      <table id="" class="table table-hover">
                                          <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>Nama</th>
                                                  <th colspan="2">Keterangan</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach ($alumni as $index => $item)
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
                                              @endforeach
                                          </tbody>
                                      </table>
                                        
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('template.copyright')
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
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
                const dari = document.getElementById('dari').value;
                const hingga = document.getElementById('hingga').value;
                const nama = document.getElementById('nama').value;
                const order_id = document.getElementById('order_id').value;
                
                if (nama || order_id || (dari && hingga)) {
                    filterButton.disabled = false;
                } else {
                    filterButton.disabled = true;
                }
            }

            document.getElementById('dari').addEventListener('input', validateForm);
            document.getElementById('hingga').addEventListener('input', validateForm);
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
      new DataTable('#UangKasTable', {
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
      });
    </script>
</div>
@include('template.footer')
