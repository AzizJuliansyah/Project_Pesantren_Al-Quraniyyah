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
                    <form action="{{ route('alumni.index') }}" method="get" id="filterForm" class="{{ !$hasFilters ? 'd-none' : '' }}">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row">
                              <label>Pencarian Berdasarkan Nama</label>
                              <div class="form-group">
                                  <input type="text" class="form-control" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama...">
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
                              <label>Status</label>
                              <div class="form-group">
                                <select class="form-control" name="status" id="status">
                                  <option value="default" disabled selected>Pilih Status</option>
                                  @foreach ($status as $index => $item)
                                    <option value="{{ $item->id }}"
                                      @if (request('status') == $item->id) 
                                            selected 
                                        @endif>
                                        {{ $item->status }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-8">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label>Tanggal Lahir, Dari</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" name="dari" id="dari" value="{{ request('dari') }}">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label>Tanggal Lahir, Hingga</label>
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
                        <a href="/alumni" class="btn btn-primary">Kembali</a>
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
                                        <h4 class="card-title float-start">Daftar Data Alumni</h4>
                                        <a href="{{ route('alumni.create') }}" class="btn btn-md btn-inverse-secondary btn-fw float-end">Tambah Alumni <i class="fa fa-plus ms-2"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="AlumniTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>TTL</th>
                                                    <th>No Telepon</th>
                                                    <th>Angkatan Ke-</th>
                                                    <th>Dibuat</th>
                                                    <th>Terakhir diubah</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($alumni as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ \Illuminate\Support\Str::limit($item->nama, 20, '...') }}</td>
                                                        <td>{{ $item->tempat_lahir }}, {{ Carbon::parse($item->tanggal_lahir)->format('d-F-Y') }}</td>
                                                        <td>{{ $item->no_telepon }}</td>
                                                        <td>{{ $item->angkatan->angkatan ?? 'Unknown' }}</td>
                                                        <td>{{ $item->created_at->format('H:i, d-F-Y') }}</td>
                                                        <td>{{ $item->updated_at->format('H:i, d-F-Y') }}</td>
                                                        
                                                        <td>
                                                          <div class="d-flex align-items-center gap-3">
                                                            <!-- Button trigger modal -->
                                                            <a href="#detailalumni{{ $item->id }}" class="text-dark" data-bs-toggle="modal" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail Alumni {{ $item->nama }}">
                                                              <i class="fa fa-eye icon-sm"></i>
                                                            </a>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="detailalumni{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailalumniTitle" aria-hidden="true">
                                                              <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Detail Data Alumni {{ $item->nama }}</h5>
                                                                    
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                      <p class="card-description mt-3"> Personal Info </p>
                                                                      <tbody>
                                                                        <tr>
                                                                          <td colspan="2">
                                                                            <p>Nama:</p>
                                                                            <span>{{ $item->nama }}</span>
                                                                          </td>
                                                                          <td>
                                                                            <p>Tempat, Tanggal Lahir:</p>
                                                                            <span>{{ $item->tempat_lahir }}, {{ $item->tanggal_lahir }}</span>
                                                                          </td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td colspan="3">
                                                                            <p>Alamat:</p>
                                                                            <span class="alamat-text">{{ $item->alamat }}</span>
                                                                          </td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td>
                                                                            <p>No Telepon:</p>
                                                                            <p>{{ $item->no_telepon }}</p>
                                                                          </td>
                                                                          <td>
                                                                            <p>Pendidikan Terakhir:</p>
                                                                            <p>{{ $item->pendidikan_terakhir }}</p>
                                                                          </td>
                                                                          <td>
                                                                            <p>Angkatan Ke-</p>
                                                                            <p>{{ $item->angkatan->angkatan ?? 'Unknown' }}</p>
                                                                          </td>
                                                                        </tr>
                                                                      </tbody>
                                                                    </table>
                                                                    <table class="table table-bordered">
                                                                      <p class="card-description mt-3"> Melanjutkan </p>
                                                                      <tbody>
                                                                        <tr>
                                                                          <td>
                                                                            <p>Pekerjaan:</p>
                                                                            <p>{{ $item->status->status ?? 'Unknown' }}</p>
                                                                          </td>
                                                                          <td>
                                                                            <p>Nama Tempat Lembaga/Usaha:</p>
                                                                            <p>{{ $item->usaha }}</p>
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

                                                            <a href="{{ route('alumni.editalumni', ['slug' => $item->slug]) }}" class="text-dark">
                                                                <i class="icon-sm fa fa-edit"></i>
                                                            </a>

                                                            <a href="#hapusalumni{{ $item->id }}" class="text-dark" data-bs-toggle="modal"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Angkatan">
                                                              <i class="icon-sm fa fa-trash"></i>
                                                            </a>
                                                              <!-- Modal Hapus -->
                                                              <div class="modal fade" id="hapusalumni{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="hapusalumniTitle" aria-hidden="true">
                                                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                                                      <div class="modal-content">
                                                                          <div class="modal-body">
                                                                            <div class="form-group ms-3 me-3 mt-2">
                                                                              <form action="{{ route('alumni.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                                                  @csrf
                                                                                  @method('DELETE')
                                                                                  <div class="row mb-4">
                                                                                    <div class="d-flex align-items-center">
                                                                                      <i class="icon-lg text-danger fa fa-exclamation-triangle"></i>
                                                                                      <div class="row ms-2">
                                                                                        <h6>Hapus Alumni</h6>
                                                                                        <span>Anda yakin ingin menghapus Alumni?</span>
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
            const angkatan = document.getElementById('angkatan').value;
            const status = document.getElementById('status').value;
            const dari = document.getElementById('dari').value;
            const hingga = document.getElementById('hingga').value;
            const search = document.getElementById('search').value;
            
            const angkatanValid = angkatan !== "default";
            const statusValid = status !== "default";
            
            
            if (search || angkatanValid || statusValid || (dari && hingga)) {
                filterButton.disabled = false;
            } else {
                filterButton.disabled = true;
            }
        }

        document.getElementById('angkatan').addEventListener('change', validateForm);
        document.getElementById('status').addEventListener('change', validateForm);
        document.getElementById('dari').addEventListener('input', validateForm);
        document.getElementById('hingga').addEventListener('input', validateForm);
        document.getElementById('search').addEventListener('input', validateForm);
    });

    new DataTable('#AlumniTable', {
      pageLength: 25,
      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
    });
</script>
</div>
@include('template.footer')
