@include('template.header')
@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        @include('template.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row mt-2">
                    <div class="col-lg-12">
                        <div class="row d-flex">
                            @foreach ($totalUangKasPerAngkatan  as $indexx => $item)
                                <div class="col-lg-4 col-md-6 mt-3">
                                    <div class="card card-rounded table-darkBGImg">
                                        <div class="card-body">
                                            <div class="col-sm-8">
                                                <h3 class="text-white upgrade-info mb-0"><span class="fw-bold">Angkatan Ke-</span>{{ $item['angkatan'] }}</h3>
                                                <h3 class="text-white upgrade-info mb-0 mt-2"><span class="fw-bold">Rp</span>{{ number_format($item['totalUangKas'], 2, ',', '.') }}</h3>
                                                <a href="{{ route('detail.uangkas', encrypt($item['angkatan_id'])) }}" class="btn btn-info upgrade-btn mt-3">Detail Keseluruhan <i class="fa fa-arrow-right ms-1"></i></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @include('template.copyright')
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
@include('template.footer')