@include('template.header')

@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        @include('template.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group">
                                        <h4 class="card-title float-start">Daftar Data status</h4>
                                        <button type="button" class="btn btn-md btn-inverse-secondary btn-fw float-end"
                                            data-bs-toggle="modal" data-bs-target="#tambahstatus"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Lihat Detail Alumni">
                                            Tambah status <i class="fa fa-plus ms-2"></i>
                                        </button>

                                        <!-- Modal Tambah status -->
                                        <div class="modal fade" id="tambahstatus" tabindex="-1"
                                            role="dialog" aria-labelledby="tambahstatusTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data status</h5>
                                                    </div>
                                                    <form action="{{ route('status.store') }}" method="POST">
                                                      <div class="modal-body">
                                                            @csrf
                                                            <div class="mb-3">
                                                              <label for="status" class="form-label">Status</label>
                                                              <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" id="status" placeholder="Status">
                                                              @error('status')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                              @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                              <label for="info" class="form-label">Info</label>
                                                              <textarea name="info" class="form-control @error('info') is-invalid @enderror" id="info" placeholder="Info Tentang Status"></textarea>
                                                              @error('info')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                              @enderror
                                                          </div>
                                                      </div>
                                                      <div class="modal-footer">
                                                          <button type="button" class="btn btn-inverse-dark btn-md" data-bs-dismiss="modal">Close</button>
                                                          <button type="submit" class="btn btn-primary">Simpan</button>
                                                      </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="StatusTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Status</th>
                                                    <th>Info</th>
                                                    <th>Dibuat</th>
                                                    <th>Terakhir Diubah</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->status }}</td>
                                                        <td>{{ $item->info }}</td>
                                                        <td>{{ $item->created_at->format('H:i, d-F-Y') }}</td>
                                                        <td>{{ $item->updated_at->format('H:i, d-F-Y') }}</td>
                                                        <td>
                                                          <div class="d-flex align-items-center gap-3">
                                                              <!-- Button trigger modal Edit -->
                                                              <a href="#editstatus{{ $item->id }}" class="text-dark" data-bs-toggle="modal" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit status">
                                                                  <i class="icon-sm fa fa-edit"></i>
                                                              </a>

                                                              <!-- Modal Edit -->
                                                              <div class="modal fade" id="editstatus{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editstatusTitle" aria-hidden="true">
                                                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                                                      <div class="modal-content">
                                                                          <div class="modal-header">
                                                                              <h5 class="modal-title" id="exampleModalLongTitle">Detail Data status</h5>
                                                                          </div>
                                                                          <form action="{{ route('status.update', $item->id) }}" method="POST">
                                                                            <div class="modal-body">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <div class="mb-3">
                                                                                    <label for="status" class="form-label">status</label>
                                                                                    <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" id="status" value="{{ $item->status }}">
                                                                                    @error('status')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="info" class="form-label">Info</label>
                                                                                    <textarea name="info" class="form-control @error('info') is-invalid @enderror" id="info">{{ $item->info }}</textarea>
                                                                                    @error('info')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                              <button type="button" class="btn btn-inverse-dark btn-md" data-bs-dismiss="modal">Close</button>
                                                                              <button type="submit" class="btn btn-primary">Update</button>
                                                                            </div>
                                                                          </form>
                                                                      </div>
                                                                  </div>
                                                              </div>


                                                              <!-- Button trigger modal Hapus -->
                                                              <a href="#hapusstatus{{ $item->id }}" class="text-dark" data-bs-toggle="modal"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit status">
                                                                  <i class="icon-sm fa fa-trash"></i>
                                                              </a>

                                                              <!-- Modal Hapus -->
                                                              <div class="modal fade" id="hapusstatus{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="hapusstatusTitle" aria-hidden="true">
                                                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                                                      <div class="modal-content">
                                                                          <div class="modal-body">
                                                                            <div class="form-group ms-3 me-3 mt-2">
                                                                              <form action="{{ route('status.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                                                  @csrf
                                                                                  @method('DELETE')
                                                                                  <div class="row mb-4">
                                                                                    <div class="d-flex align-items-center">
                                                                                      <i class="icon-lg text-danger fa fa-exclamation-triangle"></i>
                                                                                      <div class="row ms-2">
                                                                                        <h6>Hapus status</h6>
                                                                                        <span>Anda yakin ingin menghapus status?</span>
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
            </div>
            @include('template.copyright')
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    <script>
        new DataTable('#StatusTable', {
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        });
    </script>
</div>
@include('template.footer')
