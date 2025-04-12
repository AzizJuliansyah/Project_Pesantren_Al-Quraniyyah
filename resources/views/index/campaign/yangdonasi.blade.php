@include('template.header')

@include('komponen.pesan')

<div class="container-scroller mt-5">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
         <div class="content-wrapper d-flex justify-content-center auth px-0">
            <div class="d-flex justify-content-center custom-col">
                <div class="donation-card p-0">
                    <div class="card card-fixed p-0 shadow bg-transparent" style="border-radius: 1px">
                        <div class="m-3">
                            <div class="d-flex align-items-center">
                                <a href="/daftarcampaign" class="text-dark d-flex align-items-center">
                                    <i class="mdi-icon mdi mdi-chevron-left"></i>
                                    <i class="mdi-icon mdi mdi-home"></i>
                                </a>
                                <small class="truncate-text ms-4"><strong>{{ $campaign->nama }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mt-1" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <a href="{{ route('campaignpayment.detail', $campaign->slug) }}" class="text-dark">
                                    <div class="float-start">
                                        <i class="fa fa-chevron-left me-5"></i>
                                        Donatur
                                        <span class="btn btn-sm btn-inverse-info ms-3">{{ number_format($totalyangDonasi, 0, '.') }}</span>
                                    </div>
                                </a>
                                <div class="divider"></div>
                                <h5>{{ $campaign->nama }}</h5>
                                <div class="d-flex align-items-center mt-4 mb-3">
                                    <button id="btn-terbaru" class="btn btn-sm btn-inverse-info me-3">Terbaru</button>
                                    <button id="btn-terbesar" class="btn btn-sm btn-inverse-light">Terbesar</button>
                                </div>
                            </div>
                            <div id="donation-list">
                                @forelse ($yangDonasi as $index => $item)
                                    <div class="donation-box" data-created-at="{{ $item->created_at }}" data-nominal="{{ $item->nominal2 }}">
                                        <img src="{{ asset('assets/images/default_profile.png') }}" alt="Avatar">
                                        <div class="donation-content">
                                            <div class="name">{{ $item->nama }}</div>
                                            <div class="amount">Berdonasi sebesar <strong>Rp {{ number_format($item->nominal2, 2, ',', '.') }}</strong></div>
                                            <div class="time">{{ $item->time_difference }}</div>
                                            @if (!empty($item->doa))
                                                <div class="form-group mt-2">
                                                    <p>Doa dari {{ $item->sapaan }}, {{ $item->nama }} :</p>
                                                    <div class="divider"></div>
                                                    <p>{{ $item->doa }}</p>
                                                    <div class="divider"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center mt-5">Jadilah Yang Pertama Berdonasi di Campaign Ini.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnTerbaru = document.getElementById('btn-terbaru');
            const btnTerbesar = document.getElementById('btn-terbesar');
            const donationList = document.getElementById('donation-list');

            let currentSort = 'terbaru';

            function sortDonations() {
                const donations = Array.from(donationList.children);
                if (currentSort === 'terbaru') {
                    donations.sort((a, b) => {
                        return new Date(b.getAttribute('data-created-at')) - new Date(a.getAttribute('data-created-at'));
                    });
                } else {
                    donations.sort((a, b) => {
                        return parseFloat(b.getAttribute('data-nominal')) - parseFloat(a.getAttribute('data-nominal'));
                    });
                }
                donationList.innerHTML = '';
                donations.forEach(donation => donationList.appendChild(donation));
            }

            btnTerbaru.addEventListener('click', function () {
                currentSort = 'terbaru';
                btnTerbaru.classList.add('btn-inverse-info');
                btnTerbaru.classList.remove('btn-inverse-light');
                btnTerbesar.classList.add('btn-inverse-light');
                btnTerbesar.classList.remove('btn-inverse-info');
                sortDonations();
            });

            btnTerbesar.addEventListener('click', function () {
                currentSort = 'terbesar';
                btnTerbesar.classList.add('btn-inverse-info');
                btnTerbesar.classList.remove('btn-inverse-light');
                btnTerbaru.classList.add('btn-inverse-light');
                btnTerbaru.classList.remove('btn-inverse-info');
                sortDonations();
            });

            sortDonations();
        });


        function updateCardWidth() {
            var col = document.querySelector('.donation-card');
            var card = document.querySelector('.card-fixed');
            
            if (col && card) {
                card.style.width = col.clientWidth + "px";
            }
        }

        window.onload = updateCardWidth;

        window.onresize = updateCardWidth;
    </script>
    
    @include('template.copyright')
</div>
@include('template.footer')