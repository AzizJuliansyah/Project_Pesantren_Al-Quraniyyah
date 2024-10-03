@include('template.header')
@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        @include('template.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="float-start">
                                        <p class="card-title">Daftar Data Settings Website</p>
                                    </div>
                                </div>
                                {{-- <div class="float-end">
                                    <button type="button" class="btn btn-md btn-inverse-secondary btn-fw float-end"
                                            data-bs-toggle="modal" data-bs-target="#tambahitem"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Lihat Detail Alumni">
                                            Tambah item <i class="fa fa-plus ms-2"></i>
                                        </button>

                                        <!-- Modal Tambah item -->
                                        <div class="modal fade" id="tambahitem" tabindex="-1"
                                            role="dialog" aria-labelledby="tambahitemTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data item</h5>
                                                    </div>
                                                    <form action="{{ route('administrator.store') }}" method="POST" enctype="multipart/form-data">
                                                      <div class="modal-body">
                                                            @csrf
                                                            <div class="mb-3">
                                                              <label for="item" class="form-label">item</label>
                                                              <input type="text" name="item" class="form-control @error('item') is-invalid @enderror" id="item">
                                                              @error('item')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                              @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                              <label for="info" class="form-label">Info</label>
                                                              <textarea name="info" class="form-control @error('info') is-invalid @enderror" id="info" placeholder="Info Tentang item"></textarea>
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
                                </div> --}}
                                <div class="table-responsive">
                                    <table id="AdministratorTable" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item</th>
                                                <th>Info</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        
                                                        @if (in_array($item->item_id, [1, 4, 6]))
                                                            @if(Storage::exists('public/' . $item->item))
                                                                <img src="{{ asset('storage/' . $item->item) }}" alt="{{ $item->info }}" class="img-fluid" width="800">
                                                            @else
                                                                <p class="text-danger">{{ $item->item }}</p>
                                                            @endif
                                                        @else
                                                            {{ \Illuminate\Support\Str::limit($item->item, 50, '...') }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->info }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-md btn-inverse-secondary btn-fw float-end"
                                                            data-bs-toggle="modal" data-bs-target="#edititem{{ $item->item_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Lihat Detail Alumni">
                                                            Edit item <i class="fa fa-edit ms-2"></i>
                                                        </button>

                                                        <!-- Modal Tambah item -->
                                                        <div class="modal fade" id="edititem{{ $item->item_id }}" tabindex="-1"
                                                            role="dialog" aria-labelledby="edititemTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Data item</h5>
                                                                    </div>
                                                                    <form action="{{ route('administrator.edit', $item->item_id) }}" method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                            @csrf
                                                                            <div class="mb-3">
                                                                                <label for="item" class="form-label">item</label>
                                                                                @if (in_array($item->item_id, [1, 4, 6]))
                                                                                    @if(Storage::exists('public/' . $item->item))
                                                                                        <div class="form-group">
                                                                                            <img src="{{ asset('storage/' . $item->item) }}" alt="{{ $item->info }}" class="img-fluid" width="800">
                                                                                        </div>
                                                                                        <input type="file" class="form-control @error('item') is-invalid @enderror" name="item" id="item">
                                                                                    @else
                                                                                        <p class="text-danger">{{ $item->item }}</p>
                                                                                        <input type="file" class="form-control @error('item') is-invalid @enderror" name="item" id="item">
                                                                                    @endif
                                                                                @else
                                                                                    <textarea type="text" name="item" class="textarea-control @error('item') is-invalid @enderror" id="item" rows="10">{{ $item->item }}</textarea>
                                                                                @endif
                                                                                @error('item')
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
        <!-- main-panel ends -->
    </div>
    @include('template.copyright')
    <script>
        new DataTable('#AdministratorTable', {
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        });
    </script>
    <!-- page-body-wrapper ends -->
</div>
@include('template.footer')