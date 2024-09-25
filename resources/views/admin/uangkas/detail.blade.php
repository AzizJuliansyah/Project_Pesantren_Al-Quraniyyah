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
                    <form action="{{ route('uangkas.index') }}" method="get" id="filterForm" class="{{ !$hasFilters ? 'd-none' : '' }}">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row">
                              <label>Pencarian Berdasarkan Nama Campaign</label>
                              <div class="form-group">
                                  <input type="text" class="form-control" name="nama" id="nama" value="{{ request('nama') }}" placeholder="Cari nama...">
                              </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label>Angkatan Ke-</label>
                            <div class="form-group">
                                <select class="form-control" name="angkatan" id="angkatan">
                                  <option value="default" disabled selected>Pilih Angkatan</option>
                                  @foreach ($angkatan as $index => $item)
                                    <option value="{{ $item->id }}" 
                                        @if (request('angkatan') == $item->id) 
                                            selected 
                                        @endif>
                                        {{ $item->angkatan }}
                                    </option>
                                  @endforeach
                                </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                              <label>Pencarian Berdasarkan Order ID</label>
                              <div class="form-group">
                                  <input type="text" class="form-control" name="order_id" id="order_id" value="{{ request('order_id') }}" placeholder="Cari Order ID...">
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label>Berdasarkan Status</label>
                            <div class="form-group">
                                <select class="form-control" name="status" id="status">
                                  <option value="default" disabled selected>Pilih Status</option>
                                  <option value="success" @if (request('status') == 'success')  selected  @endif>Success</option>
                                  <option value="pending" @if (request('status') == 'pending')  selected  @endif>Pending</option>
                                  <option value="error" @if (request('status') == 'error')  selected  @endif>Error</option>
                                </select>
                            </div>
                          </div>
                        </div>
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
                        <a href="/campaign/detaildatacampaign/{{ encrypt($campaign->id) }}" class="btn btn-primary">Kembali</a>
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
                                        <h4 class="card-title float-start">Daftar Nama Alumni yang bayar uang kas</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="CampaignTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Order ID</th>
                                                    <th>Nama</th>
                                                    <th>Angkatan Ke-</th>
                                                    <th>Nominal</th>
                                                    <th>Nominal Setelah di Bagi 2%</th>
                                                    <th>Status</th>
                                                    <th>Tanggal Donasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($donasi as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                          <h5 class="text-dark" onclick="copyToClipboard('{{ $item->order_id }}')" style="cursor: pointer;">
                                                              {{ $item->order_id }} 
                                                              <i class="mdi mdi-content-copy" style="margin-left: 5px;"></i>
                                                          </h5>
                                                        </td>
                                                        <td>{{ \Illuminate\Support\Str::limit($item->alumni->nama, 25, '...') }}</td>
                                                        <td>
                                                          <div class="d-flex justify-content-center">
                                                            {{ $item->alumni->angkatan->angkatan }}
                                                          </div>
                                                        </td>
                                                        <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                                                        <td>
                                                          <div class="d-flex justify-content-center">
                                                            Rp{{ number_format($item->nominal2, 0, ',', '.') }}
                                                          </div>
                                                        </td>
                                                        <td>
                                                          @if ($item->status == 'success')
                                                            <span class="btn btn-md btn-success">Success</span>
                                                          @elseif ($item->status == 'pending')
                                                            <span class="btn btn-md btn-warning">Pending</span>
                                                          @elseif ($item->status == 'error')
                                                            <span class="btn btn-md btn-danger">Error</span>
                                                            @else
                                                            <span>Unknown</span>
                                                          @endif
                                                        </td>
                                                        <td>{{ $item->created_at->format('H:i, d-F-Y') }}</td>
                                                        
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
                const angkatan = document.getElementById('angkatan').value;
                const status = document.getElementById('status').value;
                const dari = document.getElementById('dari').value;
                const hingga = document.getElementById('hingga').value;
                const nama = document.getElementById('nama').value;
                const order_id = document.getElementById('order_id').value;
                
                const statusValid = status !== "default";
                const angkatanValid = angkatan !== "default";

                
                if (nama || angkatanValid || statusValid || order_id || (dari && hingga)) {
                    filterButton.disabled = false;
                } else {
                    filterButton.disabled = true;
                }
            }

            document.getElementById('status').addEventListener('change', validateForm);
            document.getElementById('angkatan').addEventListener('change', validateForm);
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
      new DataTable('#CampaignTable', {
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
      });
    </script>
</div>
@include('template.footer')
