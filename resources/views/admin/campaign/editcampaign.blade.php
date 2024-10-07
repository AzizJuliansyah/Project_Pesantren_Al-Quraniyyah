@include('template.header')

@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        @include('template.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <a href="{{ route('campaign.index') }}"><i class="fa fa-arrow-left me-2"></i> Kembali</a>
                <div class="row mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('campaign.update', $campaign->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group">
                                            <h4 class="card-title float-start">Edit Data Campaign, {{ $campaign->nama }}</h4>
                                            <div class="float-end">
                                                <button type="submit" name="action" value="save" class="btn btn-md btn-inverse-success btn-fw">
                                                    Simpan <i class="fa fa-plus ms-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 grid-margin">
                                            <p class="card-description"> Casual info </p>
                                            <div class="row">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Campaign Thumbnail</label>
                                                    <div class="col-sm-10">
                                                        @if($campaign->foto)
                                                            <img src="{{ asset($campaign->foto) }}" alt="{{ $campaign->nama }}" class="img-fluid mb-2" width="140">
                                                        @endif
                                                        <input type="file" name="foto" id="foto" class="file-upload-default">
                                                        <div class="input-group col-xs-12">
                                                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                                            <span class="input-group-append">
                                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">ID Campaign</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="campaign_id" id="campaign_id" value="{{ $campaign->campaign_id }}" class="form-control" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Nama Campaign</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="nama" id="nama" value="{{ $campaign->nama }}" class="form-control" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Info</label>
                                                        <div class="col-sm-9">
                                                            <textarea name="info" id="info" class="textarea-control" cols="50" rows="5" placeholder="Info Tentang Campaign" required>{{ $campaign->info }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Client Key</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="client_key" id="client_key" value="{{ $campaign->client_key }}" class="form-control" placeholder="Client Key Midtrans" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Server Key</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="server_key" id="server_key" value="{{ $campaign->server_key }}" class="form-control" placeholder="Server Key Midtrans" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <p class="card-description"> Nominal info </p>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Target</label>
                                                        <div class="col-sm-9">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text bg-primary text-white">Rp.</span>
                                                                    </div>
                                                                    <input type="text" name="target" id="target" value="{{ $campaign->target }}" class="form-control" aria-label="Rupiah" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Nominal</label>
                                                        <div class="form-group">
                                                            <div class="form-check form-check-flat form-check-primary">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input" id="toggleNominal" @if($campaign->nominal !== null) checked @endif> Ceklis jika ingin menetapkan nominal
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div id="nominalContainer" class="form-group d-none">
                                                            <div class="form-group">
                                                                <button class="btn btn-light btn-sm rounded" type="button" id="addNominal"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('template.copyright')
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
     <script>
        $(document).ready(function() {
            let nominalData = @json($campaign->nominal);

            if (nominalData && !Array.isArray(nominalData)) {
                nominalData = JSON.parse(nominalData);
            }

            if (Array.isArray(nominalData) && nominalData.length > 0) {
                $('#nominalContainer').removeClass('d-none');

                nominalData.forEach(function(nominal) {
                    $('#nominalContainer').append(`
                        <div class="input-group mt-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white">Rp.</span>
                                    </div>
                                    <input type="number" name="nominal[]" id="nominal" class="form-control" value="${nominal}" required/>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-danger text-white removeNominal" style="cursor:pointer;"><i class="fa fa-minus"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });
            }

            $('#toggleNominal').change(function() {
                if ($(this).is(':checked')) {
                    $('#nominalContainer').removeClass('d-none');
                } else {
                    $('#nominalContainer').addClass('d-none');
                    $('#nominalContainer').find('.input-group').remove();
                }
            });

            $('#addNominal').click(function() {
                $('#nominalContainer').append(`
                    <div class="input-group mt-2">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white">Rp.</span>
                                </div>
                                <input type="number" name="nominal[]" id="nominal" class="form-control" required/>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-danger text-white removeNominal" style="cursor:pointer;"><i class="fa fa-minus"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            });

            $('#nominalContainer').on('click', '.removeNominal', function() {
                $(this).closest('.input-group').remove();
            });
        });

        $(document).ready(function() {
            




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

            formatInput('#campaign_id');
            formatInput('#target');

            $('form').on('submit', function() {
                $('#campaign_id').val(function(index, value) {
                    return value.replace(/\./g, '');
                });
                $('#target').val(function(index, value) {
                    return value.replace(/\./g, '');
                });
            });
        });

        ClassicEditor
            .create(document.querySelector('#info'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', 'code', '|',
                    'link', '|',
                    'bulletedList', 'numberedList', 'blockQuote', '|',
                    'undo', 'redo'
                ],
            })
            .then(editor => {

                editor.editing.view.change(writer => {
                    writer.setStyle(
                        "height",
                        "200px",
                        editor.editing.view.document.getRoot()
                    );
                });
                console.log(`Editor initialized for #jawabanText`);
            })
            .catch(error => {
                console.error('There was an error initializing the editor', error);
            });

    </script>
</div>
@include('template.footer')
