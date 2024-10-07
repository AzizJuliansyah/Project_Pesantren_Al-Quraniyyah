@include('template.header')
@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        <div class="">
            <div class="content-wrapper">
                <div class="row mt-2">
                    <div class="col-lg-3">
                        <div class="sticky-copywriting">
                            <h2>{{ $heading->item }}</h2>
                            <p>{{ $subheading->item }}</p>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            @forelse ($campaign as $index => $item)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card shadow h-100">
                                    @if($item->foto)
                                        <img src="{{ asset($item->foto) }}" class="card-img-top img-fluid" alt="{{ $item->nama }}">
                                    @else
                                        <img src="https://via.placeholder.com/150" class="card-img-top img-fluid" alt="No Image Available">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->nama }}</h5>
                                        {{-- <p class="card-text">{{ $item->info }}</p> --}}
                                        <div class="float-start">
                                            <span>Target Terkumpul:</span>
                                            <p>Rp{{ number_format($item->target, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    @if ($item->id == 1)
                                        <div class="card-footer">
                                            <a href="{{ route('pembayaran.uangkas') }}" class="btn btn-primary">Bayar Uang Kas <i class="fa fa-arrow-right ms-2"></i></a>
                                        </div>
                                    @else
                                        <div class="card-footer">
                                            <a href="{{ route('campaignpayment.detail', $item->slug) }}" class="btn btn-primary">Donasi Sekarang <i class="fa fa-arrow-right ms-2"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @empty
                                
                            @endforelse
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
