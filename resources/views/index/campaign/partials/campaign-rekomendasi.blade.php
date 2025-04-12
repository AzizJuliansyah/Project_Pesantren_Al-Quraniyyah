@if (count($campaignRekomendasi) > 0)
    <div class="d-flex justify-content-center">
        <div class="row wow fadeInDown mb-2" data-wow-duration="1s" data-wow-delay="0.5s">
            <div class="form-group text-center">
                <p class="mt-3">Tidak ditemukan, Periksa Program Kebaikan Lainnya</p>
                <div class="divider"></div>
            </div>
            <div class="form-group mt-3">
                @foreach ($campaignRekomendasi as $item)
                    <a href="{{ route('campaignpayment.detail', $item->slug) }}" class="card shadow p-3 m-2" style="border-radius: 3px">
                        <div class="mt-2">
                            <div class="d-flex justify-content-around">
                                <div class="col-4 mb-3">
                                    @if($item->foto)
                                        <img src="{{ asset($item->foto) }}" class="rounded img-fluid" width="10" alt="{{ $item->nama }}">
                                    @else
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png?20210521171500" class="rounded img-fluid" width="10" alt="No Image Available">
                                    @endif
                                </div>
                                <div class="col-8">
                                    <div class="form-group ms-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="d-none d-lg-block"><strong>{{ $item->nama }}</strong></h6>
                                                <h6 class="d-block d-lg-none"><strong>{{ Str::limit($item->nama, 50, '...') }}</strong></h6>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <small class="mt-3 mb-2" style="font-size: 10pt">Al-Quraniyyah</small>
                                                <img src="{{ asset('images/item/centang-biru.png') }}" style="max-width: 30px;height: auto; margin-top: 8px" alt="">
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="text-primary"><strong>Rp {{ number_format($item->total_donasi, 0) }}</strong></h6>
                                                    <small class="text-muted ms-2" style="font-size: 12px">Terkumpul</small>
                                                </div>
                                                <div class="progress mt-1" style="height: 6px">
                                                    <div class="progress-bar progress-bar-striped" role="progressbar" 
                                                        style="width: {{ $item->persen_donasi }}%;" 
                                                        aria-valuenow="{{ $item->persen_donasi }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="donatur-container">
                                                    @foreach ($item->donatur as $donatur)
                                                        <div class="donatur-avatar">{{ strtoupper(substr($donatur, 0, 1)) }}</div>
                                                    @endforeach

                                                    @if ($item->total_donatur > 3)
                                                        <div class="donatur-more">+{{ $item->total_donatur - 3 }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif
