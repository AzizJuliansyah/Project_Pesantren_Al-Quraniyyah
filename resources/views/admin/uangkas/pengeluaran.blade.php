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
                                        <h4 class="card-title float-start">Daftar Data pengeluaran uang kas</h4>
                                        <button type="button" class="btn btn-md btn-inverse-secondary btn-fw float-end"
                                            data-bs-toggle="modal" data-bs-target="#tambahpengeluaran"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Lihat Detail Alumni">
                                            Tambah pengeluaran <i class="fa fa-plus ms-2"></i>
                                        </button>

                                        <!-- Modal Tambah pengeluaran -->
                                        <div class="modal fade" id="tambahpengeluaran" tabindex="-1"
                                            role="dialog" aria-labelledby="tambahpengeluaranTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Pengeluaran Uang Kas</h5>
                                                    </div>
                                                    <form action="{{ route('pengeluaran.tambah') }}" method="POST">
                                                        <div class="modal-body">
                                                            @csrf
                                                            <div class="mb-3">
                                                              <label for="untuk" class="form-label">Untuk <span class="text-danger">*</span></label>
                                                              <textarea name="untuk" class="textarea-control @error('untuk') is-invalid @enderror" id="untuk" cols="50" rows="5" placeholder="Pengeluaran Untuk Apa"></textarea>
                                                              @error('untuk')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                              @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nominal" class="form-label">Nominal <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text  text-dark">Rp.</span>
                                                                    </div>
                                                                    <input type="text" name="nominal" class="form-control @error('nominal') is-invalid @enderror" id="nominal" placeholder="Berapa Rupiah">
                                                                </div>
                                                                @error('nominal')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="yangbertanggungjawab" class="form-label">Yang Bertanggung Jawab <span class="text-danger">*</span></label>
                                                                <input type="text" name="yangbertanggungjawab" class="form-control @error('yangbertanggungjawab') is-invalid @enderror" id="yangbertanggungjawab" placeholder="Siapa Yang Bertanggung Jawab">
                                                                @error('yangbertanggungjawab')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-inverse-dark btn-md" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="pengeluaranTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Untuk</th>
                                                    <th>Nomninal</th>
                                                    <th>Yang Bertanggung Jawab</th>
                                                    <th>Dibuat</th>
                                                    <th>Terakhir Diubah</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pengeluaran as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->untuk }}</td>
                                                        <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                                                        <td>{{ $item->yangbertanggungjawab }}</td>
                                                        <td>{{ $item->created_at->format('H:i, d-F-Y') }}</td>
                                                        <td>{{ $item->updated_at->format('H:i, d-F-Y') }}</td>
                                                        <td>
                                                          <div class="d-flex align-items-center gap-3">
                                                              <!-- Button trigger modal Edit -->
                                                              <a href="#editpengeluaran{{ $item->id }}" class="text-dark" data-bs-toggle="modal" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit pengeluaran">
                                                                  <i class="icon-sm fa fa-edit"></i>
                                                              </a>

                                                              <!-- Modal Edit -->
                                                              <div class="modal fade" id="editpengeluaran{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editpengeluaranTitle" aria-hidden="true">
                                                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                                                      <div class="modal-content">
                                                                          <div class="modal-header">
                                                                              <h5 class="modal-title" id="exampleModalLongTitle">Edit Data pengeluaran</h5>
                                                                          </div>
                                                                          <form action="{{ route('pengeluaran.edit', $item->id) }}" method="POST">
                                                                            <div class="modal-body">
                                                                                @csrf
                                                                                <div class="mb-3">
                                                                                    <label for="untuk" class="form-label">Untuk <span class="text-danger">*</span></label>
                                                                                    <textarea name="untuk" class="textarea-control @error('untuk') is-invalid @enderror" id="untuk" cols="50" rows="5" placeholder="Pengeluaran Untuk Apa">{{ $item->untuk }}</textarea>
                                                                                    @error('untuk')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="nominal" class="form-label">Nominal <span class="text-danger">*</span></label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text  text-dark">Rp.</span>
                                                                                        </div>
                                                                                        <input type="text" name="nominal" value="{{ number_format($item->nominal, 0) }}" class="form-control @error('nominal') is-invalid @enderror" id="nominalEdit" placeholder="Berapa Rupiah">
                                                                                    </div>
                                                                                    @error('nominal')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="yangbertanggungjawab" class="form-label">Yang Bertanggung Jawab <span class="text-danger">*</span></label>
                                                                                    <input type="text" name="yangbertanggungjawab" value="{{ $item->yangbertanggungjawab }}" class="form-control @error('yangbertanggungjawab') is-invalid @enderror" id="yangbertanggungjawab" placeholder="Siapa Yang Bertanggung Jawab">
                                                                                    @error('yangbertanggungjawab')
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
                                                              <a href="#hapuspengeluaran{{ $item->id }}" class="text-dark" data-bs-toggle="modal"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit pengeluaran">
                                                                  <i class="icon-sm fa fa-trash"></i>
                                                              </a>

                                                              <!-- Modal Hapus -->
                                                              <div class="modal fade" id="hapuspengeluaran{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="hapuspengeluaranTitle" aria-hidden="true">
                                                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                                                      <div class="modal-content">
                                                                          <div class="modal-body">
                                                                            <div class="form-group ms-3 me-3 mt-2">
                                                                              <form action="{{ route('pengeluaran.hapus', $item->id) }}" method="POST" style="display:inline;">
                                                                                  @csrf
                                                                                  <div class="row mb-4">
                                                                                    <div class="d-flex align-items-center">
                                                                                      <i class="icon-lg text-danger fa fa-exclamation-triangle"></i>
                                                                                      <div class="row ms-2">
                                                                                        <h6>Hapus pengeluaran</h6>
                                                                                        <span>Anda yakin ingin menghapus pengeluaran?</span>
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
        new DataTable('#pengeluaranTable', {
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        });

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
            formatInput('#nominalEdit');

            $('form').on('submit', function() {
                $('#nominal').val(function(index, value) {
                    return value.replace(/\./g, '');
                });
                $('#nominalEdit').val(function(index, value) {
                    return value.replace(/\./g, '');
                });
            });
    </script>
</div>
@include('template.footer')
