@include('template.header')
@include('template.navbar')

@include('komponen.pesan')

<div class="container-scroller mt-5">
    <div class="container-fluid">
        <div class="d-flex justify-content-center mt-5">
            <!-- Payment Card -->
            <div class="card shadow-lg p-4 bg-light" style="max-width: 500px; border-radius: 15px;">
                <div class="card-body text-center">
                    <h4 class="mb-4 text-primary font-weight-bold">Detail Pembayaran Uang Kas</h4>
                    
                    <!-- Payment Amount -->
                    <div class="form-group">
                        <h5 class="font-weight-bold">Jumlah Pembayaran</h5>
                        <p class="text-info display-4">Rp{{ number_format($uangkas->nominal, 0, ',', '.') }}</p>
                    </div>
                    <!-- Payer's Name -->
                    <div class="form-groupmt-3">
                        <h5 class="font-weight-bold">Atas Nama</h5>
                        <p class="text-dark">{{ $uangkas->alumni->nama ?? 'Unknown' }}</p>
                    </div>
                    <!-- Alumni Batch -->
                    <div class="form-group mt-3">
                        <h5 class="font-weight-bold">Angkatan</h5>
                        <p class="text-dark">{{ $uangkas->alumni->angkatan->angkatan ?? 'Unknown' }}</p>
                    </div>
                    <!-- Payment Button -->
                    <button class="btn btn-success btn-lg mt-4 shadow" id="pay-button">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            snap.pay('{{ $uangkas->snap_token }}', {
                onSuccess: function(result) {
                // Send the result to the server to update the payment status
                updatePaymentStatus(result, 'success');
                },
                onPending: function(result) {
                // Send the result to the server to update the payment status
                updatePaymentStatus(result, 'pending');
                },
                onError: function(result) {
                // Send the result to the server to update the payment status
                updatePaymentStatus(result, 'error');
                }
            });
            };

            function updatePaymentStatus(result, status) {
            // Perform AJAX request to update the payment status in the database
            fetch("{{ route('payment.update-status') }}", {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                id: '{{ $uangkas->id }}',
                status: status,
                transaction_result: result
                })
            })
            .then(response => response.json())
            .then(data => {
                // Redirect based on the response
                if (status === 'success') {
                window.location.href = '/payment/success';
                } else if (status === 'pending') {
                window.location.href = '/payment/pending';
                } else {
                window.location.href = '/payment/error';
                }
            })
            .catch(error => {
                console.error('Error updating payment status:', error);
            });
        }

    </script>
    @include('template.copyright')
</div>