@include('template.header')
@include('template.navbar')
@include('komponen.pesan')
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper mt-5">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5 shadow mt-5">
                <div class="brand-logo text-center">
                  <img src="{{ asset('assets/images/logo-alquraniyyah.png') }}" alt="logo" style="width: 50px;">
                </div>
                <h6 class="fw-light text-center">Donasi {{ $campaign->nama }}.</h6>
                <p class="text-center">Sedikit uang yang anda keluarkan sangat berharga bagi kami</p>

                <!-- Menampilkan pesan sukses -->

                <form class="pt-3" method="POST" action="{{ route('campaignpayment.donasi') }}">
                  @csrf
                  <input type="hidden" name="campaign_id" value="{{ encrypt($campaign->id) }}">
                  @if ($campaign->id == 1)
                    <div class="form-group">
                      <label for="alumni_id">Nama Anda</label>
                      <select class="js-example-basic-single w-100 @error('alumni_id') is-invalid @enderror" name="alumni_id" id="alumni_id" required>
                          <option  disabled selected>Cari Nama Anda..</option>
                          @foreach ($alumni as $index => $item)
                          <option value="{{ $item->id }}">{{ $item->nama }}</option>
                          @endforeach
                      </select>
                      @error('alumni_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="angkatan_id">Angkatan ke-</label>
                      <input type="text" class="form-control form-control-sm @error('alumni_id') is-invalid @enderror" id="angkatan_id" name="angkatan_id" placeholder="angkatan" readonly required>
                      @error('alumni_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  @else
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" class="form-control form-control-sm @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama" required>
                      @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  @endif
                  @if ($campaign->nominal == null)
                    <div class="form-group">
                      <label for="nominal">Jumlah Nominal</label>
                      <input type="text" class="form-control form-control-sm @error('nominal') is-invalid @enderror" id="nominal" name="nominal" placeholder="Nominal" required>
                      @error('nominal')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  @else
                      @if(is_array(json_decode($campaign->nominal)))
                        <div class="form-group">
                          <label for="nominal">Jumlah Nominal</label>
                          <select class="form-control text-dark @error('nominal') is-invalid @enderror" name="nominal" id="nominalSelect"  required>
                            <option value="default" disabled selected>Pilih Nominal</option>
                            @foreach(json_decode($campaign->nominal) as $nominal)
                              <option value="{{ $nominal }}">Rp. {{ number_format($nominal, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        @error('nominal')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        </div>
                      @else
                        <li>No nominal available</li>
                      @endif
                  @endif



                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" id="BayarButton" class="btn btn-primary btn-lg btn-block auth-form-btn" disabled>Bayar</button>
                  </div>
                </form>
                <p class="text-description text-center"><a href="/daftarcampaign">Kembali Ke Halaman Daftar Campaign</a></p>
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


          // function formatNumber(number) {
          //   return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
          // }

          //   function formatInput(selector) {
          //       $(selector).on('input', function() {
          //           let input = $(this).val();
          //           let numericValue = input.replace(/[^0-9]/g, '');
          //           let formattedValue = formatNumber(numericValue);
          //           $(this).val(formattedValue);
          //       });
          //   }

          //   formatInput('#nominal');

          //   $('form').on('submit', function() {
          //       $('#nominal').val(function(index, value) {
          //           return value.replace(/\./g, '');
          //       });
          //   });



          function validateForm() {
    const BayarButton = document.getElementById('BayarButton');
    const campaignId = {{ $campaign->id }};
    const campaignNominal = @json($campaign->nominal);

    let nominal;
    if (campaignNominal === null || campaignNominal === undefined) {
        // Use input field if no predefined nominal
        nominal = document.getElementById('nominal').value;
    } else {
        // Use select if predefined nominal exists
        const nominal_valid = document.getElementById('nominalSelect').value;

        nominal = nominal_valid !== "default";

    }

    // Check conditions based on campaign ID
    if (campaignId == 1) {
        const alumni_id = document.getElementById('alumni_id').value;
        const angkatan = document.getElementById('angkatan_id').value;
        const alumni_idValid = alumni_id !== "default";

        if (nominal && angkatan && alumni_idValid) {
            BayarButton.disabled = false;
        } else {
            BayarButton.disabled = true;
        }
    } else {
        const nama = document.getElementById('nama').value;

        if (nominal && nama) {
            BayarButton.disabled = false;
        } else {
            BayarButton.disabled = true;
        }
    }
}

// Add event listeners
document.getElementById('angkatan_id')?.addEventListener('input', validateForm);
document.getElementById('alumni_id')?.addEventListener('change', validateForm);
document.getElementById('nominal')?.addEventListener('input', validateForm);
document.getElementById('nominalSelect')?.addEventListener('change', validateForm);
document.getElementById('nama')?.addEventListener('input', validateForm);


        });
      </script>
      @include('template.copyright')
    </div>
@include('template.footer')