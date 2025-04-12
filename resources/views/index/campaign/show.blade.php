@include('template.header')

@include('komponen.pesan')

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex justify-content-center auth px-0">
            <div class="d-flex justify-content-center custom-col">
                <div class="donation-card p-0">
                    <div class="card card-fixed p-0 shadow bg-transparent" style="border-radius: 1px">
                        <div class="m-3">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('campaignpayment.detail', $campaign->slug) }}" class="text-dark d-flex align-items-center pe-4">
                                    <i class="mdi-icon mdi mdi-chevron-left"></i>
                                </a>
                                <small class="truncate-text"><strong>{{ $campaign->nama }}</strong></small>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow" style="border-radius: 3px">
                        <div class="card-body" >
                            <div class="d-flex justify-content-around" style="margin-top: 45px">
                                <div class="col-4">
                                    @if($campaign->foto)
                                        <img src="{{ asset($campaign->foto) }}" alt="{{ $campaign->nama }}" class="img-fluid rounded" width="100%">
                                    @else
                                        <p>Image not available</p>
                                    @endif
                                </div>
                                <div class="col-8 ms-3">
                                    <div class="row">
                                        <small class="text-muted mb-2">Anda akan berdonasi di program:</small>
                                        <h6 class="font-weight-bold"><strong>{{ $campaign->nama }}</strong></h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                              <p>Donasi Terbaik Anda <span class="text-danger">*</span></p>

                              <form class="pt-3" method="POST" action="{{ route('campaignpayment.donasi') }}">
                                @csrf
                                <input type="hidden" name="campaign_id" value="{{ encrypt($campaign->id) }}">

                                <div class="form-group">
                                  @if ($campaign->nominal == null)
                                    <div class="donation-options">
                                        <div class="donation-option shadow" data-value="other">Nominal lainnya</div>
                                    </div>
                                    <div class="custom-amount-container" id="nominal-container">
                                        <span class="currency-symbol">Rp</span>
                                        <input type="text" class="form-control" name="nominal" id="nominal" value="{{ old('nominal') }}" class="custom-amount" placeholder="Masukkan nominal" min="1000">
                                    </div>
                                  @else
                                      <div class="donation-options">
                                          @if(is_array(json_decode($campaign->nominal)))
                                              @foreach(json_decode($campaign->nominal) as $nominal)
                                                  <div class="donation-option shadow" data-value="{{ $nominal }}"><strong>Rp. {{ number_format($nominal, 0, ',', '.') }}</strong></div>
                                              @endforeach
                                          @else
                                            <li>No nominal available</li>
                                          @endif
                                          <div class="donation-option shadow" data-value="other">Nominal lainnya</div>
                                      </div>
                                      <div class="custom-amount-container" id="nominal-container">
                                          <span class="currency-symbol">Rp</span>
                                          <input type="text" class="form-control" name="nominal" id="nominal" value="{{ old('nominal') }}" class="custom-amount" placeholder="Masukkan nominal" min="1000">
                                      </div>
                                  @endif
                                  <input type="hidden" name="nominal" id="hidden-nominal">
                                  @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>


                                <div class="form-group">
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
                                            <div class="sapaan-container">
                                                <label for="sapaan">Sapaan <span class="text-danger">*</span> :</label>
                                                <div class="sapaan-options">
                                                    <div class="sapaan-option" data-value="Bapak">Bapak</div>
                                                    <div class="sapaan-option" data-value="Ibu">Ibu</div>
                                                    <div class="sapaan-option" data-value="Kakak">Kakak</div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="sapaan" id="sapaan">
                                            <div class="form-group mt-3">
                                                <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap">
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="no_hp">No Whatsapp <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-sm @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="No Whatsapp">
                                    @error('no_hp')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="divider" style="margin-bottom: 25px; border-bottom: 1px solid black"></div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email ( Optional )">
                                    @error('email')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <textarea class="textarea-control @error('doa') is-invalid @enderror" id="doa" name="doa" placeholder="Tuliskan pesan atau doa disini ( Optional )">{{ old('doa') }}</textarea>
                                    @error('doa')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-3 d-grid gap-2">
                                  <button type="submit" id="BayarButton" class="btn btn-primary btn-lg btn-block auth-form-btn" disabled>Lanjutkan</button>
                                </div>
                              </form>
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


          function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
          }

            function formatInput(selector) {
                $(selector).on('input', function() {
                    let input = $(this).val();
                    let numericValue = input.replace(/[^0-9]/g, '');
                    let formattedValue = formatNumber(numericValue);
                    $(this).val(formattedValue);
                });
            }

            formatInput('#nominal');

            $('form').on('submit', function() {
                $('#nominal').val(function(index, value) {
                    return value.replace(/\./g, '');
                });
            });



            function validateForm() {
                const BayarButton = document.getElementById('BayarButton');
                const campaignId = {{ $campaign->id }};

                let nominal = document.getElementById('hidden-nominal').value.trim();
                let isNominalValid = nominal !== "" && !isNaN(nominal);

                if (campaignId == 1) {
                    const alumni_id = document.getElementById('alumni_id').value;
                    const angkatan = document.getElementById('angkatan_id').value;
                    const alumni_idValid = alumni_id !== "default";

                    if (isNominalValid && angkatan && alumni_idValid) {
                        BayarButton.disabled = false;
                    } else {
                        BayarButton.disabled = true;
                    }
                } else {
                    const sapaan = document.getElementById('sapaan').value;
                    const nama = document.getElementById('nama').value.trim();
                    const no_hp = document.getElementById('no_hp').value.trim();

                    if (isNominalValid && sapaan && nama && no_hp) {
                        BayarButton.disabled = false;
                    } else {
                        BayarButton.disabled = true;
                    }
                }
            }

            document.getElementById('angkatan_id')?.addEventListener('input', validateForm);
            document.getElementById('alumni_id')?.addEventListener('change', validateForm);
            document.getElementById('hidden-nominal').addEventListener('input', validateForm);
            document.getElementById('sapaan')?.addEventListener('input', validateForm);
            document.getElementById('nama')?.addEventListener('input', validateForm);
            document.getElementById('no_hp')?.addEventListener('input', validateForm);

            

        });
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


        document.addEventListener("DOMContentLoaded", function () {
            const donasiOptions = document.querySelectorAll(".donation-option");
            const customAmountContainer = document.getElementById("nominal-container");
            const customAmountInput = document.getElementById("nominal");
            const donationAmountInput = document.getElementById("hidden-nominal");

            const sapaanOptions = document.querySelectorAll(".sapaan-option");
            const sapaanInput = document.getElementById("sapaan");

            if (donasiOptions.length > 0) {
                donasiOptions[0].classList.add("selected");
                donationAmountInput.value = donasiOptions[0].getAttribute("data-value");
            }

            if (sapaanOptions.length > 0) {
                sapaanOptions[0].classList.add("selected");
                sapaanInput.value = sapaanOptions[0].getAttribute("data-value");
            }

            donasiOptions.forEach(option => {
                option.addEventListener("click", function () {
                    donasiOptions.forEach(opt => opt.classList.remove("selected"));
                    this.classList.add("selected");
                    let value = this.getAttribute("data-value");

                    if (value === "other") {
                        customAmountContainer.style.display = "flex";
                        customAmountInput.value = "";
                        customAmountInput.focus();
                        donationAmountInput.value = "";
                    } else {
                        customAmountContainer.style.display = "none";
                        donationAmountInput.value = value;
                    }
                });
            });

            function formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            customAmountInput.addEventListener("input", function () {
                let input = this.value.replace(/[^0-9]/g, '');
                this.value = formatNumber(input);
                donationAmountInput.value = input;
            });

            sapaanOptions.forEach(option => {
                option.addEventListener("click", function () {
                    sapaanOptions.forEach(opt => opt.classList.remove("selected"));
                    this.classList.add("selected");
                    sapaanInput.value = this.getAttribute("data-value");
                });
            });
        });
    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-right',
                    iconColor: 'white',
                    customClass: {
                        popup: 'colored-toast',
                    },
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                })

                ;(async () => {
                    Toast.fire({
                        icon: 'error',
                        title: "{{ $error }}",
                    })
                })()
            </script>
        @endforeach
        
    @endif
    @include('template.copyright')
</div>
@include('template.footer')