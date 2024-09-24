@include('template.header')
@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo text-center">
                  <img src="{{ asset('assets/images/logo.svg') }}" alt="logo" style="width: 100px;">
                </div>
                <h4 class="text-center">Hello! Selamat Datang!!</h4>
                <h6 class="fw-light text-center">Bayar Uang Kas.</h6>

                <!-- Menampilkan pesan sukses -->

                <form class="pt-3" method="POST" action="{{ route('uangkas.store') }}">
                  @csrf
                  <div class="form-group">
                    <label for="alumni_id">Nama Anda</label>
                    <select class="js-example-basic-single w-100" name="alumni_id" id="alumni_id" required>
                        <option  disabled selected>Cari Nama Anda..</option>
                        @foreach ($alumni as $index => $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                   </div>
                  <div class="form-group">
                    <label for="angkatan_id">Angkatan ke-</label>
                    <input type="text" class="form-control form-control-sm" id="angkatan_id" name="angkatan_id" placeholder="angkatan" readonly required>
                  </div>
                  <div class="form-group">
                    <label for="nominal">Jumlah Nominal</label>
                    <input type="text" class="form-control form-control-sm" id="nominal" name="nominal" placeholder="Nominal" required>
                  </div>



                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" id="BayarButton" class="btn btn-primary btn-lg btn-block auth-form-btn" disabled>Bayar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->

      <script>
        document.addEventListener('DOMContentLoaded', function () {
        $(document).ready(function() {
            $('#alumni_id').on('change', function() {
                var alumniId = $(this).val();

                $.ajax({
                    url: '/get-alumni-details/' + alumniId,
                    type: 'GET',
                    success: function(response) {
                        $('#angkatan_id').val(response.angkatan);
                    },
                    error: function(xhr) {
                        console.error("An error occurred: " + xhr.responseText);
                    }
                });
            });
        });


        // $(document).ready(function() {
        //     $('#nominal').on('input', function() {
        //         var input = $(this).val();

        //         input = input.replace(/[^0-9]/g, '');

        //         if (input) {
        //             input = new Intl.NumberFormat('id-ID', {
        //                 style: 'decimal',
        //                 minimumFractionDigits: 0
        //             }).format(input);
        //         }

        //         $(this).val(input);
        //     });
        // });




        function validateForm() {
            const BayarButton = document.getElementById('BayarButton');
            const alumni_id = document.getElementById('alumni_id').value;
            const angkatan = document.getElementById('angkatan_id').value;
            const nominal = document.getElementById('nominal').value;
            
            const alumni_idValid = alumni_id !== "default";
            
            
            if (nominal || angkatan || alumni_idValid) {
                BayarButton.disabled = false;
            } else {
                BayarButton.disabled = true;
            }
        }

        document.getElementById('angkatan_id').addEventListener('input', validateForm);
        document.getElementById('alumni_id').addEventListener('change', validateForm);
        document.getElementById('nominal').addEventListener('input', validateForm);
    });
      </script>
      @include('template.copyright')
    </div>
@include('template.footer')