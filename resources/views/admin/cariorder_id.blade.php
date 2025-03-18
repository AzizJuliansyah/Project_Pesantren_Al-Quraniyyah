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
                                        <div class="float-start">
                                            <h4 class="card-title">Cari Order ID Dari Semua Transaksi</h4>
                                            <div class="row">
                                                <form action="{{ route('cariorder_id') }}" method="GET">
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" class="form-control" name="order_id" id="order_id" value="{{ request('order_id') }}" placeholder="Masukkan Order ID">
                                                        <button type="submit" class="btn btn-primary ms-3">Cari</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        @if($donasi->isNotEmpty())
                                            <table class="table table-bordered" style="margin-bottom: 110px">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Order ID</th>
                                                        <th>Campaign</th>
                                                        <th>Pendonasi</th>
                                                        <th>Nominal</th>
                                                        <th>Tanggal Donasi</th>
                                                        <th>Status</th>
                                                        <th>Ubah Status Ke</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($donasi as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $item->order_id }}</td>
                                                            <td>{{ $item->campaign->nama }}</td>
                                                            <th>
                                                                @if ($item->alumni_id !== null)
                                                                    {{ $item->alumni->nama }}
                                                                @else
                                                                    {{ $item->nama }}
                                                                @endif
                                                            </th>
                                                            <td>Rp {{ number_format($item->nominal2, 2, ',', '.') }}</td>
                                                            <td>{{ $item->created_at->format('H:i, d-F-Y') }}</td>
                                                            <td>
                                                                @if ($item->status == 'success')
                                                                    <p class="text-success">{{ $item->status }}</p>
                                                                @elseif ($item->status == 'pending')
                                                                    <p class="text-warning">{{ $item->status }}</p>
                                                                @elseif ($item->status == 'error')
                                                                    <p class="text-danger">{{ $item->status }}</p>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        Ubah Status
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        @if ($item->status !== 'success')
                                                                            <li class="dropdown-item">
                                                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ubahstatuskesuccess{{ $item->order_id }}">Success</button>
                                                                            </li>
                                                                        @endif
                                                                        @if ($item->status !== 'pending')
                                                                            <li class="dropdown-item">
                                                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ubahstatuskepending{{ $item->order_id }}">Pending</button>
                                                                            </li>
                                                                        @endif
                                                                        @if ($item->status !== 'error')
                                                                            <li class="dropdown-item">
                                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ubahstatuskeerror{{ $item->order_id }}">Error</button>
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>

                                                                @if ($item->status !== 'success')
                                                                    <div class="modal fade" id="ubahstatuskesuccess{{ $item->order_id }}" tabindex="-1" aria-labelledby="ubahstatuskesuccessLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="ubahstatuskesuccessLabel">Ubah Status Transaksi</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group ms-3 me-3 mt-2">
                                                                                <form action="{{ route('ubahstatustransaksi', $item->order_id) }}" method="POST" style="display:inline;">
                                                                                    @csrf
                                                                                    <input type="hidden" name="status" value="success">
                                                                                    <div class="row mb-4">
                                                                                        <div class="d-flex align-items-center">
                                                                                        <img src="assets/images/success.png" alt="">
                                                                                        <div class="row ms-2">
                                                                                            <h6>Ubah Status Ke <span class="text-success">Success</span></h6>
                                                                                            <span>Anda yakin ingin mengubah status transaksi?</span>
                                                                                        </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="float-end">
                                                                                        <button type="button" class="btn btn-inverse-dark btn-md me-3" data-bs-dismiss="modal">Close</button>
                                                                                        <button type="submit" class="btn btn-md btn-success">Ubah</button>
                                                                                    </div>
                                                                                </form>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if ($item->status !== 'pending')
                                                                    <div class="modal fade" id="ubahstatuskepending{{ $item->order_id }}" tabindex="-1" aria-labelledby="ubahstatuskependingLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="ubahstatuskependingLabel">Ubah Status Transaksi</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group ms-3 me-3 mt-2">
                                                                                <form action="{{ route('ubahstatustransaksi', $item->order_id) }}" method="POST" style="display:inline;">
                                                                                    @csrf
                                                                                    <input type="hidden" name="status" value="pending">
                                                                                    <div class="row mb-4">
                                                                                        <div class="d-flex align-items-center">
                                                                                        <img src="assets/images/pending.png" alt="">
                                                                                        <div class="row ms-2">
                                                                                            <h6>Ubah Status Ke <span class="text-warning">Pending</span></h6>
                                                                                            <span>Anda yakin ingin mengubah status transaksi?</span>
                                                                                        </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="float-end">
                                                                                        <button type="button" class="btn btn-inverse-dark btn-md me-3" data-bs-dismiss="modal">Close</button>
                                                                                        <button type="submit" class="btn btn-md btn-warning">Ubah</button>
                                                                                    </div>
                                                                                </form>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if ($item->status !== 'error')
                                                                    <div class="modal fade" id="ubahstatuskeerror{{ $item->order_id }}" tabindex="-1" aria-labelledby="ubahstatuskeerrorLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="ubahstatuskeerrorLabel">Ubah Status Transaksi</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group ms-3 me-3 mt-2">
                                                                                <form action="{{ route('ubahstatustransaksi', $item->order_id) }}" method="POST" style="display:inline;">
                                                                                    @csrf
                                                                                    <input type="hidden" name="status" value="error">
                                                                                    <div class="row mb-4">
                                                                                        <div class="d-flex align-items-center">
                                                                                        <img src="assets/images/error.png" alt="">
                                                                                        <div class="row ms-2">
                                                                                            <h6>Ubah Status Ke <span class="text-danger">Error</span></h6>
                                                                                            <span>Anda yakin ingin mengubah status transaksi?</span>
                                                                                        </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="float-end">
                                                                                        <button type="button" class="btn btn-inverse-dark btn-md me-3" data-bs-dismiss="modal">Close</button>
                                                                                        <button type="submit" class="btn btn-md btn-danger">Ubah</button>
                                                                                    </div>
                                                                                </form>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="text-center">Tidak ada transaksi ditemukan.</p>
                                        @endif
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
        new DataTable('#AngkatanTable', {
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        });
    </script>
</div>
@include('template.footer')
