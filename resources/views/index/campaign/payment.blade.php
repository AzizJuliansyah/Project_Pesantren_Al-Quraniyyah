@include('template.header')

@include('komponen.pesan')

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex justify-content-center auth px-0">
            <div class="d-flex justify-content-center custom-col">
                <div class="donation-card p-0">
                    <div class="card card-fixed p-0 shadow bg-transparent" style="border-radius: 1px">
                        <div class="mt-3 mb-2">
                            <h5 class="text-center">Al - Qur'aniyyah</h5>
                        </div>
                    </div>
                    <div class="card  py-5 px-4 px-sm-5 shadow">
                        <div class="card-body p-0">
                            <h5 class="text-center mt-3"><strong>Informasi Pembayaran</strong></h5>
                            <div class="brand-logo text-center mt-2">
                                @php
                                    $item = \App\Models\Administrator::where('item_id', 1)->first();
                                @endphp

                                @if($item->item)
                                    @if(file_exists($item->item))
                                    <img src="{{ asset($item->item) }}" alt="logo" />
                                    @else
                                    {{ $item->item }}
                                    @endif
                                @else
                                    <p>No image available</p>
                                @endif
                            </div>
                            <div class="row">
                                <small class="text-muted mb-2">Anda akan melakukan pembayaran di program:</small>
                                <div class="d-flex justify-content-around">
                                    <div class="col-4">
                                        @if($campaign->foto)
                                            <img src="{{ asset($campaign->foto) }}" alt="{{ $campaign->nama }}" class="img-fluid rounded" width="100%">
                                        @else
                                            <p>Image not available</p>
                                        @endif
                                    </div>
                                    <div class="col-8 ms-3">
                                        <div class="row">
                                            <h6 class="d-none d-lg-block"><strong>{{ $campaign->nama }}</strong></h6>
                                            <h6 class="d-block d-lg-none"><strong>{{ Str::limit($campaign->nama, 50, '...') }}</strong></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>
                            
                            <!-- Payment Amount -->
                            <div class="form-group mt-3">
                                <small><strong>Order ID</strong></small>
                                <div class="order-id-payment">
                                    <h6 class="text-dark mt-1" onclick="copyToClipboard('{{ $donasi->order_id }}')" style="cursor: pointer;">
                                        {{ $donasi->order_id }} 
                                        <i class="mdi mdi-content-copy" style="margin-left: 5px;"></i>
                                    </h6>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <p class="font-weight-bold">Atas Nama</p>
                                @if ($donasi->alumni_id !== null)
                                    <h6 class="text-dark">{{ $donasi->alumni->nama ?? 'Unknown' }}</h6>
                                @else
                                    <h6 class="text-dark">{{ $donasi->sapaan ?? 'Unknown' }}, {{ $donasi->nama ?? 'Unknown' }}</h6>
                                @endif
                            </div>
                            <!-- Alumni Batch -->
                            <div class="form-group mt-3">
                                @if ($donasi->alumni_id !== null)
                                    <p class="font-weight-bold">Angkatan</p>
                                    <h6 class="text-dark">{{ $donasi->alumni->angkatan->angkatan ?? 'Unknown' }}</h6>
                                @endif
                            </div>

                            <div class="form-group mt-3">
                                <p class="font-weight-bold">No Whastapp</p>
                                <h6 class="text-dark">{{ $donasi->no_hp ?? '-' }}</h6>
                            </div>

                            <div class="form-group mt-3">
                                <p class="font-weight-bold">Email</p>
                                <h6 class="text-dark">{{ $donasi->email ?? '-' }}</h6>
                            </div>

                            <div class="divider"></div>

                            <div class="form-group mt-3">
                                <div class="row">
                                    <div class="d-flex justify-content-between">
                                        <h6><strong>Berdonasi sebesar:</strong></h6>
                                        <h6><strong>Rp {{ number_format($donasi->nominal - $campaign->campaign_id, 0, ',', '.') }}</strong></h6>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small>fee 
                                            <i class="mdi mdi-icon mdi-information-variant-circle-outline tooltip-icon">
                                                <span class="tooltip-text">Biaya administrasi untuk pemeliharaan web</span>
                                            </i>
                                        </small>
                                        <small>Rp {{ number_format($campaign->campaign_id, 0, ',', '.') }}</small>
                                    </div>
                                    <div class="d-grid">
                                        <div class="total-bayar mt-3">
                                            <div class="form-group">
                                                <div class="float-start">Total Bayar</div>
                                            <div class="float-end">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>
                            
                            
                            <div class="d-grid">
                                <div class="float-start">
                                    <div class="d-flex align-items-center mb-1">
                                        <input type="checkbox" class="" name="" id="agree-checkbox">
                                        <small class="ms-2">Ceklis untuk melanjutkan
                                            <i class="mdi mdi-icon mdi-information-variant-circle-outline tooltip-icon">
                                                <span class="tooltip-text">Dengan ini anda setuju dengan fee biaya administrasi untuk pemeliharaan web</span>
                                            </i>
                                        </small>
                                    </div>
                                </div>
                                <button class="btn btn-warning btn-md col-12 shadow" id="pay-button" disabled>Bayar Sekarang</button>
                                {{-- <div class="d-flex justidy-content-between">
                                    <div class="col-4">
                                        <button class="btn btn-outline-danger btn-md shadow mt-3">Batalkan</button>
                                    </div>
                                    <div class="col-8">
                                        <div class="float-start">
                                            <div class="d-flex align-items-center">
                                                <input type="checkbox" class="" name="" id="agree-checkbox">
                                                <small class="ms-2">Ceklis untuk melanjutkan
                                                    <i class="mdi mdi-icon mdi-information-variant-circle-outline tooltip-icon">
                                                        <span class="tooltip-text">Dengan ini anda setuju dengan fee biaya administrasi untuk pemeliharaan web</span>
                                                    </i>
                                                </small>
                                            </div>
                                        </div>
                                        <button class="btn btn-warning btn-md col-12 shadow" id="pay-button" disabled>Bayar Sekarang</button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $campaign->client_key }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            snap.pay('{{ $donasi->snap_token }}', {
                onSuccess: function(result){
                    window.location.href = '{{ route('payment.success', encrypt($donasi->id)) }}'
                },
                onPending: function(result){
                    window.location.href = '{{ route('payment.pending', encrypt($donasi->id)) }}'
                },
                onError: function(result){
                    window.location.href = '{{ route('payment.error', encrypt($donasi->id)) }}'
                }
            });
        };

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 2800,
            timerProgressBar: true,
        });

        function copyToClipboard(orderId) {
            navigator.clipboard.writeText(orderId).then(() => {
                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil Meng Copy Order ID!',
                });
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        }

    </script>

    <script>
        function updateWidth(targetClass) {
            var col = document.querySelector('.donation-card');
            var target = document.querySelector(`.${targetClass}`);
            
            if (col && target) {
                target.style.width = col.clientWidth + "px";
            }
        }
        function updateAllWidths() {
            updateWidth('card-fixed');
        }
        window.onload = updateAllWidths;
        window.onresize = updateAllWidths;


        document.getElementById("agree-checkbox").addEventListener("change", function() {
            document.getElementById("pay-button").disabled = !this.checked;
        });
    </script>
    @include('template.copyright')
</div>