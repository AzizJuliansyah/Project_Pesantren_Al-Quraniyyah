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
              <div class="card mb-5 shadow">
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
                    <form action="{{ route('campaign.index') }}" method="get" id="filterForm" class="{{ !$hasFilters ? 'd-none' : '' }}">
                      
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row">
                              <label>Pencarian Berdasarkan ID Campaign</label>
                              <div class="form-group">
                                  <input type="text" class="form-control" name="campaign_id" id="campaign_id" value="{{ request('campaign_id') }}" placeholder="Cari ID...">
                              </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                              <label>Pencarian Berdasarkan Nama Campaign</label>
                              <div class="form-group">
                                  <input type="text" class="form-control" name="nama" id="nama" value="{{ request('nama') }}" placeholder="Cari nama...">
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-8">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label>Tanggal dibuat, Dari</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" name="dari" id="dari" value="{{ request('dari') }}">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label>Tanggal dibuat, Hingga</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" name="hingga" id="hingga" value="{{ request('hingga') }}">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary me-2" id="filterButton" disabled>Filter / Cari</button>
                      @if ($hasFilters)
                        <a href="/campaign" class="btn btn-primary">Kembali</a>
                      @endif
                    </form>
                </div>
              </div>
              
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group">
                                        <h4 class="card-title float-start">Daftar Data campaign</h4>
                                        <a href="{{ route('campaign.create') }}" class="btn btn-md btn-inverse-secondary btn-fw float-end">Tambah campaign <i class="fa fa-plus ms-2"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="CampaignTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Campaign ID</th>
                                                    <th>Nama</th>
                                                    <th>Publish</th>
                                                    <th>Dibuat</th>
                                                    <th>Terakhir diubah</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($campaign as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->campaign_id }}</td>
                                                        <td>{{ \Illuminate\Support\Str::limit($item->nama, 20, '...') }}</td>
                                                        <td class="d-flex justify-content-center">
                                                          <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" 
                                                                      data-id="{{ $item->id }}" 
                                                                      @if($item->publish == 1) checked @endif 
                                                                      onchange="togglePublish(this)">
                                                                Publish
                                                            </label>
                                                          </div>
                                                        </td>
                                                        <td>{{ $item->created_at->format('H:i, d-F-Y') }}</td>
                                                        <td>{{ $item->updated_at->format('H:i, d-F-Y') }}</td>
                                                        
                                                        <td>
                                                          <div class="d-flex align-items-center gap-3">
                                                            <!-- Button trigger modal -->
                                                            <a href="#detailcampaign{{ $item->id }}" class="text-dark" data-bs-toggle="modal" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail campaign {{ $item->nama }}">
                                                              <i class="fa fa-eye icon-sm"></i>
                                                            </a>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="detailcampaign{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailcampaignTitle" aria-hidden="true">
                                                              <div class="modal-dialog  modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Detail Data Campaign {{ $item->nama }}</h5>
                                                                    
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                      <p class="card-description mt-3"> Campaign Info </p>
                                                                      <tbody>
                                                                        <tr>
                                                                          <td colspan="3">
                                                                            <div class="d-flex justify-content-center">
                                                                              @if($item->foto)
                                                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="img-fluid" width="500">
                                                                              @endif
                                                                            </div>
                                                                          </td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td>
                                                                            <p>Campaign ID:</p>
                                                                            <span>{{ $item->campaign_id }}</span>
                                                                          </td>
                                                                          <td colspan="2">
                                                                            <p>Nama Campaign:</p>
                                                                            <span>{{ $item->nama }}</span>
                                                                          </td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="3">
                                                                            <p>Info Campaign:</p>
                                                                            <span class="alamat-text">{!! $item->info !!}</span>
                                                                          </td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="3">
                                                                            <p>Client Key:</p>
                                                                            <span class="alamat-text">{{ $item->client_key }}</span>
                                                                          </td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="3">
                                                                            <p>Server Key:</p>
                                                                            <span class="alamat-text">{{ $item->server_key }}</span>
                                                                          </td>
                                                                        </tr>
                                                                        
                                                                      </tbody>
                                                                    </table>
                                                                    <table class="table table-bordered">
                                                                      <p class="card-description mt-3"> Melanjutkan </p>
                                                                      <tbody>
                                                                        <tr>
                                                                          <td>
                                                                            <p>Target:</p>
                                                                            <p>Rp. {{ number_format($item->target, 0, ',', '.') }}</p>
                                                                          </td>
                                                                          <td>
                                                                            <p>Nominal:</p>
                                                                            <ul>
                                                                                @if(is_array(json_decode($item->nominal)))
                                                                                    @foreach(json_decode($item->nominal) as $nominal)
                                                                                        <li>Rp. {{ number_format($nominal, 0, ',', '.') }}</li>
                                                                                    @endforeach
                                                                                @else
                                                                                    <li>No nominal available</li>
                                                                                @endif
                                                                            </ul>
                                                                          </td>
                                                                        </tr>
                                                                      </tbody>
                                                                    </table>
                                                                    </div>
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-inverse-dark btn-md" data-bs-dismiss="modal">Close</button>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>

                                                            <a href="{{ route('campaign.editcampaign', ['slug' => $item->slug]) }}" class="text-dark">
                                                                <i class="icon-sm fa fa-edit"></i>
                                                            </a>

                                                            @if ($item->id !== 1)
                                                              <a href="#hapuscampaign{{ $item->id }}" class="text-dark" data-bs-toggle="modal"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Angkatan">
                                                                <i class="icon-sm fa fa-trash"></i>
                                                              </a>
                                                              <!-- Modal Hapus -->
                                                              <div class="modal fade" id="hapuscampaign{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="hapuscampaignTitle" aria-hidden="true">
                                                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                                                      <div class="modal-content">
                                                                          <div class="modal-body">
                                                                            <div class="form-group ms-3 me-3 mt-2">
                                                                              <form action="{{ route('campaign.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                                                  @csrf
                                                                                  @method('DELETE')
                                                                                  <div class="row mb-4">
                                                                                    <div class="d-flex align-items-center">
                                                                                      <i class="icon-lg text-danger fa fa-exclamation-triangle"></i>
                                                                                      <div class="row ms-2">
                                                                                        <h6>Hapus campaign</h6>
                                                                                        <span>Anda yakin ingin menghapus campaign?</span>
                                                                                      </div>
                                                                                    </div>
                                                                                  </div>
                                                                                  <div class="float-end">
                                                                                    <button type="button" class="btn btn-inverse-dark btn-md me-3" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-md btn-danger">Hapus</button>
                                                                                  </div>
                                                                              </form>
                                                                            </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                            @endif


                                                          </div>

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
                const campaign_id = document.getElementById('campaign_id').value;
                
                
                
                if (nama || campaign_id || (dari && hingga)) {
                    filterButton.disabled = false;
                } else {
                    filterButton.disabled = true;
                }
            }

            document.getElementById('dari').addEventListener('input', validateForm);
            document.getElementById('hingga').addEventListener('input', validateForm);
            document.getElementById('nama').addEventListener('input', validateForm);
            document.getElementById('campaign_id').addEventListener('input', validateForm);




            

        });

        function togglePublish(checkbox) {
          const itemId = checkbox.getAttribute('data-id');
          const publishStatus = checkbox.checked ? 1 : 0;

          fetch(`/update-publish-status-campaign/${itemId}`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({ publish: publishStatus })
          })
          .then(response => response.json())
          .then(data => {
              if(data.success) {
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
                  })

                  ;(async () => {
                    Toast.fire({
                        icon: 'success',
                        title: "Berhasil Mengubah Status Campaign",
                    })
                  })()
              } else {
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
                  })

                  ;(async () => {
                    Toast.fire({
                        icon: 'error',
                        title: "Gagal Mengubah Status Campaign",
                    })
                  })()
              }
          })
          .catch(error => {
              console.error('Error:', error);
              alert('An error occurred while updating the publish status');
          });
      }

    </script>

    <script>
      new DataTable('#CampaignTable', {
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
      });
    </script>
</div>
@include('template.footer')
