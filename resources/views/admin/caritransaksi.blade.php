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
                                        <div class="row">
                                            <div class="float-start">
                                            </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-12" style="overflow-x: auto;">
                                                    <div class="row">
                                                        <div class="col-lg-4" style="  white-space: nowrap;">
                                                            <form action="{{ route('caritransaksi') }}" method="GET">
                                                                <h5 class="">Cari Order ID Dari Semua Transaksi</h5>
                                                                <div class="d-flex align-items-center">
                                                                    <input type="text" class="form-control" name="order_id" id="order_id" value="{{ request('order_id') }}" placeholder="Masukkan Order ID">
                                                                    <button type="submit" class="btn btn-primary ms-3">Cari</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-lg-4" style="  white-space: nowrap;">
                                                            <form action="{{ route('caritransaksi') }}" method="GET">
                                                                <h5 class="">Cari Transaksi Uang Kas By Tahun</h5>
                                                                <div class="d-flex align-items-center">
                                                                    <input type="number" min="2023" max="2099" class="form-control" name="tahun" id="tahun" value="{{ request('tahun') }}" placeholder="Masukkan Tahun">
                                                                    <button type="submit" class="btn btn-primary ms-3">Cari</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-lg-4" style="  white-space: nowrap;">
                                                            <form action="{{ route('caritransaksi') }}" method="GET">
                                                                <h5 class="">Cari Transaksi dari Campaign</h5>                                                            
                                                                <select class="js-example-basic-single w-100" name="campaign_id" id="campaign_id" required onchange="this.form.submit()">
                                                                    <option  disabled selected>Cari Campaign..</option>
                                                                    @foreach ($campaign as $index => $item)
                                                                        <option value="{{ $item->id }}" @if(request('campaign_id') == $item->id) selected @endif>{{ $item->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="table-responsive">
                                        @if($donasi->isNotEmpty())
                                            <table class="table table-bordered mt-5" style="margin-bottom: 110px">
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
                                                                <div class="d-flex align-items-center">
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
                                                                                    <form action="ubahstatustransaksi/{{ $item->order_id }}" method="POST" style="display:inline;">
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
                                                                                    <form action="ubahstatustransaksi/{{ $item->order_id }}" method="POST" style="display:inline;">
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
                                                                                    <form action="ubahstatustransaksi/{{ $item->order_id }}" method="POST" style="display:inline;">
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

                                                                    <button type="button" id="btn-delete" class="btn btn-danger ms-2" style="  white-space: nowrap;" class="text-dark" data-bs-toggle="modal"  data-bs-target="#hapustransaksi{{ $item->id }}">
                                                                        Hapus <i class="icon-sm fa fa-trash"></i>
                                                                    </button>
                                                                    <div class="modal fade" id="hapustransaksi{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="hapustransaksiTitle" aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <form action="hapustransaksi/{{ $item->order_id }}" method="POST">
                                                                                        @csrf
                                                                                        <div class="form-group ms-3 me-3 mt-2">
                                                                                            <div class="row mb-4">
                                                                                                <div class="d-flex align-items-center">
                                                                                                    <i class="icon-lg text-danger fa fa-exclamation-triangle"></i>
                                                                                                    <div class="row ms-2">
                                                                                                        <h6>Hapus Transaksi</h6>
                                                                                                        <span>Anda yakin ingin menghapus transaksi?</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="float-end">
                                                                                                <button type="button" class="btn btn-inverse-dark btn-md me-3" data-bs-dismiss="modal">Close</button>
                                                                                                <button type="submit" class="btn btn-danger">Hapus Transaksi</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
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
                                        @elseif ($uangkas->isNotEmpty() || $donasicampaign->isNotEmpty())
                                            @if (request('campaign_id'))
                                                <h3 class="mt-5">{{ $namacampaign->nama }}</h3>
                                            @endif
                                            <div class="row  mb-2">
                                                <div class="btn-group" role="group" aria-label="Filter Status">
                                                    <button class="btn {{ request('status') == null ? 'btn-primary' : 'btn-light' }}" onclick="filterStatus('')">Semua</button>
                                                    <button class="btn {{ request('status') == 'success' ? 'btn-success' : 'btn-light' }}" onclick="filterStatus('success')">Success</button>
                                                    <button class="btn {{ request('status') == 'pending' ? 'btn-warning' : 'btn-light' }}" onclick="filterStatus('pending')">Pending</button>
                                                    <button class="btn {{ request('status') == 'error' ? 'btn-danger' : 'btn-light' }}" onclick="filterStatus('error')">Error</button>
                                                </div>
                                            </div>
                                            <form id="bulkActionsForm" method="POST" action="{{ route('bulkUpdateStatusOrDelete') }}">

                                            <div class="d-flex align-items-center" >
                                                    <div class="dropdown" style="  white-space: nowrap;">
                                                        <button class="btn btn-primary dropdown-toggle" id="btn-update-status" type="button" data-bs-toggle="dropdown" aria-expanded="false" disabled>Ubah Status Terpilih </button>
                                                        <ul class="dropdown-menu">
                                                            <li class="dropdown-item">
                                                                <button type="button" class="btn btn-success" onclick="setStatus('success')" data-bs-toggle="modal" data-bs-target="#ubahstatusterpilihkesuccess">Success</button>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <button type="button" class="btn btn-warning" onclick="setStatus('pending')" data-bs-toggle="modal" data-bs-target="#ubahstatusterpilihkepending">Pending</button>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <button type="button" class="btn btn-danger" onclick="setStatus('error')" data-bs-toggle="modal" data-bs-target="#ubahstatusterpilihkeerror">Error</button>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="modal fade" id="ubahstatusterpilihkesuccess" tabindex="-1" aria-labelledby="ubahstatuskesuccessLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ubahstatuskesuccessLabel">Ubah Status Transaksi</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group ms-3 me-3 mt-2">
                                                                    <div class="row mb-4">
                                                                        <div class="d-flex align-items-center">
                                                                        <img src="assets/images/success.png" alt="" width="40">
                                                                        <div class="row ms-2">
                                                                            <h6>Ubah Status Ke <span class="text-success">Success</span></h6>
                                                                            <span>Anda yakin ingin mengubah status dari <span class="selected-count">0</span> transaksi?</span>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="float-end">
                                                                        <button type="button" class="btn btn-inverse-dark btn-md me-3" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" name="action" value="update_status" class="btn btn-success">Ubah Status Terpilih</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                                            
                                                    <div class="modal fade" id="ubahstatusterpilihkepending" tabindex="-1" aria-labelledby="ubahstatuskependingLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ubahstatuskependingLabel">Ubah Status Transaksi</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group ms-3 me-3 mt-2">
                                                                    <div class="row mb-4">
                                                                        <div class="d-flex align-items-center">
                                                                        <img src="assets/images/pending.png" alt="" width="40">
                                                                        <div class="row ms-2">
                                                                            <h6>Ubah Status Ke <span class="text-warning">Pending</span></h6>
                                                                            <span>Anda yakin ingin mengubah status dari <span class="selected-count">0</span> transaksi?</span>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="float-end">
                                                                        <button type="button" class="btn btn-inverse-dark btn-md me-3" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" name="action" value="update_status" class="btn btn-warning">Ubah Status Terpilih</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                                            
                                                    <div class="modal fade" id="ubahstatusterpilihkeerror" tabindex="-1" aria-labelledby="ubahstatuskeerrorLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ubahstatuskeerrorLabel">Ubah Status Transaksi</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group ms-3 me-3 mt-2">
                                                                    <div class="row mb-4">
                                                                        <div class="d-flex align-items-center">
                                                                        <img src="assets/images/error.png" alt="" width="40">
                                                                        <div class="row ms-2">
                                                                            <h6>Ubah Status Ke <span class="text-danger">Error</span></h6>
                                                                            <span>Anda yakin ingin mengubah status dari <span class="selected-count">0</span> transaksi?</span>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="float-end">
                                                                        <button type="button" class="btn btn-inverse-dark btn-md me-3" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" name="action" value="update_status" class="btn btn-danger">Ubah Status Terpilih</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="button" id="btn-delete" class="btn btn-danger ms-5" style="  white-space: nowrap;" class="text-dark" data-bs-toggle="modal"  data-bs-target="#hapustransaksiterpilih" disabled>
                                                        Hapus Terpilih <i class="icon-sm fa fa-trash"></i>
                                                    </button>
                                                    <div class="modal fade" id="hapustransaksiterpilih" tabindex="-1" role="dialog" aria-labelledby="hapustransaksiTitle" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="form-group ms-3 me-3 mt-2">
                                                                        <div class="row mb-4">
                                                                            <div class="d-flex align-items-center">
                                                                                <i class="icon-lg text-danger fa fa-exclamation-triangle"></i>
                                                                                <div class="row ms-2">
                                                                                    <h6>Hapus Transaksi</h6>
                                                                                    <span>Anda yakin ingin menghapus sejumlah <span class="selected-count">0</span> transaksi?</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="float-end">
                                                                            <button type="button" class="btn btn-inverse-dark btn-md me-3" data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" name="action" value="delete" class="btn btn-danger">Hapus Terpilih</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                                @csrf
                                                <input type="hidden" name="status" id="statusInput" value="">
                                                <table class="table table-bordered" id="DonasiTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th><input type="checkbox" id="select-all"><span class="ms-1 mb-1">Pilih Semua</span></th>
                                                            <th>Order ID</th>
                                                            <th>Campaign</th>
                                                            <th>Pendonasi</th>
                                                            <th>Nominal</th>
                                                            <th>Tanggal Donasi</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($uangkas->isNotEmpty())
                                                            @foreach($uangkas as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td><input type="checkbox" class="select-item" name="selected_ids[]" value="{{ $item->id }}"></td>
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
                                                                </tr>
                                                            @endforeach
                                                        @elseif ($donasicampaign->isNotEmpty())
                                                            @foreach($donasicampaign as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td><input type="checkbox" class="select-item" name="selected_ids[]" value="{{ $item->id }}"></td>
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
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <p class="text-center">Tidak ada transaksi ditemukan.</p>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                
                                            </form>
                                        @else
                                            @if (request('tahun') || request('campaign_id'))
                                                <div class="row mt-5 mb-3">
                                                    <div class="btn-group" role="group" aria-label="Filter Status">
                                                        <button class="btn {{ request('status') == null ? 'btn-primary' : 'btn-light' }}" onclick="filterStatus('')">Semua</button>
                                                        <button class="btn {{ request('status') == 'success' ? 'btn-success' : 'btn-light' }}" onclick="filterStatus('success')">Success</button>
                                                        <button class="btn {{ request('status') == 'pending' ? 'btn-warning' : 'btn-light' }}" onclick="filterStatus('pending')">Pending</button>
                                                        <button class="btn {{ request('status') == 'error' ? 'btn-danger' : 'btn-light' }}" onclick="filterStatus('error')">Error</button>
                                                    </div>
                                                </div>
                                            @endif
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
        new DataTable('#DonasiTable', {
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#select-all').on('click', function() {
                $('.select-item').prop('checked', this.checked);
                toggleActionButtons();
                updateSelectedCount();
            });

            $('.select-item').on('change', function() {
                $('#select-all').prop('checked', $('.select-item').length === $('.select-item:checked').length);
                toggleActionButtons();
                updateSelectedCount();
            });

            function toggleActionButtons() {
                let selected = $('.select-item:checked').length > 0;
                $('#btn-delete, #btn-update-status').prop('disabled', !selected);
            }

            function updateSelectedCount() {
                let count = $('.select-item:checked').length;
                $('.selected-count').text(count);
            }
        });


        function filterStatus(status) {
            const url = new URL(window.location.href);
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            window.location.href = url.toString();
        }
    </script>
    <script>
        function setStatus(status) {
            document.getElementById('statusInput').value = status;
            // Opsional: Jika ingin menampilkan alert atau melakukan sesuatu
            console.log("Status yang dipilih: " + status);
        }
    </script>
</div>
@include('template.footer')
