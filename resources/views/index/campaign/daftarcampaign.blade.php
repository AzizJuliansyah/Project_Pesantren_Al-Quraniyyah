@include('template.header')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex justify-content-center auth px-0">
            <div class="d-flex justify-content-center custom-col">
                <div class="donation-card p-0">

                    @include('template.homenavbar')

                    <div id="js-preloader" class="js-preloader">
                        <div class="preloader-inner">
                            <span class="dot"></span>
                            <div class="dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 80px">
                        <div class="d-flex justify-content-center">
                            <div class="row">
                                @if (!empty($query))
                                    <div class="d-flex justify-content-center">
                                            <span class="text-center m-4">Mencari Program Kebaikan Dengan Kata Kunci, <strong>" {{ $query }} "</strong></span>
                                    </div>
                                @endif
                                <div id="campaign-container" class="wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
                                    @include('index.campaign.partials.campaign-list')
                                </div>

                                <div id="campaign-rekomendasi">
                                    @include('index.campaign.partials.campaign-rekomendasi')
                                </div>

                                <div class="d-flex justify-content-center wow fadeInDown mb-4 mt-4" data-wow-duration="1s" data-wow-delay="0.8s">
                                    <button id="loadMore" class="btn">Load More</button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="card shadow m-3 wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s" style="border-radius: 5px">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="sticky-copywriting text-center">
                                                        <h4 class="mb-3">{{ $heading->item }}</h4>
                                                        <small class="text-muted">{{ $subheading->item }}</small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="col-lg-5 col-md-4 col-sm-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="col-4">
                                                                    <div class="me-3">
                                                                        @php
                                                                            $item = \App\Models\Administrator::where('item_id', 1)->first();
                                                                        @endphp

                                                                        @if($item->item)
                                                                            @if(file_exists($item->item))
                                                                                <img src="{{ asset($item->item) }}" class="img-fluid rounded-circle border border-dark border-1" style="max-width: 55px; height: auto;" alt="logo Al-Quraniyyah" />
                                                                            @else
                                                                                {{ $item->item }}
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-8">
                                                                    <h6 class="text-center"><strong>Al - Quraniyyah</strong></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    

                    <div class="mb-3" style="margin-top: -80px">
                        @include('template.copyright')
                    </div>

                </div>
                @include('template.homefooter')
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
</div>

<script>
    let limit = 5;
    let query = "{{ request()->input('search') }}"; // Ambil kata kunci pencarian

    document.getElementById('loadMore').addEventListener('click', function() {
        limit += 3;
        fetch(`/daftarcampaign?limit=${limit}&search=${query}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('campaign-container').innerHTML = data.campaigns;
            document.getElementById('campaign-rekomendasi').innerHTML = data.campaignRekomendasi;
            if (!data.hasMore) {
                document.getElementById('loadMore').style.display = 'none';
            }
        });
    });
</script>
@include('template.footer')
