@include('template.header')
@include('template.navbar')

@include('komponen.pesan')

<div class="container-scroller mt-5">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0 mt-3">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="card  py-5 px-4 px-sm-5 shadow">
                        <div class="card-header">
                            <h3 class="text-center">Al-Quraniyyah</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="brand-logo text-center mt-2">
                                <img src="{{ asset('assets/images/success.png') }}" alt="logo" style="width: 60px;">
                                <h2 class="text-success mt-1">SUCCESS</h2>
                                <h6 class="text-success">Pembayaran Donasi ke Campaign {{ $campaign->nama }} Berhasil</h6>
                            </div>
                            <!-- Payment Amount -->
                            <div class="form-group ">
                                <div class="payment-success">
                                    <div class="form-group">
                                        <div class="float-start">Total Bayar</div>
                                    <div class="float-end">Rp{{ number_format($donasi->nominal, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Order ID -->
                            <div class="form-group mt-3">
                                <p class="font-weight-bold">Order ID</p>
                                <h5 class="text-dark" onclick="copyToClipboard('{{ $donasi->order_id }}')" style="cursor: pointer;">
                                    {{ $donasi->order_id }} 
                                    <i class="mdi mdi-content-copy" style="margin-left: 5px;"></i>
                                </h5>
                            </div>

                            <!-- Payer's Name -->
                            <div class="form-group mt-3">
                                <p class="font-weight-bold">Atas Nama</p>
                                <h5 class="text-dark">{{ $donasi->alumni->nama ?? 'Unknown' }}</h5>
                            </div>
                            <!-- Alumni Batch -->
                            <div class="form-group mt-3">
                                <p class="font-weight-bold">Angkatan</p>
                                <h5 class="text-dark">{{ $donasi->alumni->angkatan->angkatan ?? 'Unknown' }}</h5>
                            </div>
                            <div class=" d-grid">
                                <a href="/" class="btn btn-success btn-md shadow">Kembali Ke Merchant</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <script>
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
    @include('template.copyright')
</div>