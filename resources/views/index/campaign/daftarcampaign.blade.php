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
                            <h2>Bantu Wujudkan Perubahan Melalui Donasi Anda!</h2>
                            <p>Selamat datang di halaman campaign donasi kami, 
                                di mana setiap kontribusi Anda dapat menginspirasi perubahan nyata. 
                                Bersama kita bisa membantu banyak orang dan komunitas yang membutuhkan dukungan. 
                                Pilih campaign yang paling menggugah hati Anda dan mari kita mulai bergerak bersama untuk membuat dunia menjadi tempat yang lebih baik.</p>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            @forelse ($campaign as $index => $item)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card shadow h-100">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top img-fluid" alt="{{ $item->nama }}">
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
                                    <div class="card-footer">
                                        <a href="{{ route('campaignpayment.detail', $item->slug) }}" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                            @empty
                                
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
    @include('template.copyright')
    <!-- page-body-wrapper ends -->
</div>
@include('template.footer')
