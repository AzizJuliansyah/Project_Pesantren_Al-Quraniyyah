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
                                                    Simpan <i class="fa fa-edit ms-2"></i>
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
                                                        <input type="file" name="foto" id="foto" class="file-upload-default" accept="image/*">
                                                        <div class="input-group col-xs-12">
                                                            <input type="text" class="form-control file-upload-info @error('foto') is-invalid @enderror" disabled placeholder="Upload Image">
                                                            <span class="input-group-append">
                                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                            </span>
                                                        </div>
                                                        @error('foto')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Campaign Video</label>
                                                    <div class="col-sm-10">
                                                        @if($campaign->video)
                                                            <video width="40%" controls>
                                                                <source src="{{ asset($campaign->video) }}" type="video/mp4">
                                                                Browser Anda tidak mendukung pemutaran video.
                                                            </video>
                                                        @endif
                                                        <div class="row mt-2">
                                                            <div class="d-flex align-items-center">
                                                                <label class="form-check-label me-2" for="toggleSwitch">Tampilkan Video</label>
                                                                <label class="switch">
                                                                    <input type="checkbox" name="tampilkan_video" id="tampilkan_video" @if ($campaign->tampilkan_video == 1) checked @endif>
                                                                    <span class="slider"></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <input type="file" name="video" id="video" class="file-upload-default @error('video') is-invalid @enderror" accept="video/*">
                                                        
                                                        <div class="input-group col-xs-12">
                                                            <input type="text" class="form-control file-upload-info @error('video') is-invalid @enderror" disabled placeholder="Upload Video">
                                                            <span class="input-group-append">
                                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                            </span>
                                                        </div>
                                                        @error('video')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">ID Campaign</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="campaign_id" id="campaign_id" value="{{ $campaign->campaign_id }}" class="form-control @error('campaign_id') is-invalid @enderror" required/>
                                                            @error('campaign_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Nama Campaign</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="nama" id="nama" value="{{ $campaign->nama }}" class="form-control @error('nama') is-invalid @enderror" required/>
                                                            @error('nama')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Info</label>
                                                        <div class="col-sm-9">
                                                            <textarea name="info" id="info" class="textarea-control @error('info') is-invalid @enderror" cols="50" rows="5" placeholder="Info Tentang Campaign" required>{{ $campaign->info }}</textarea>
                                                            @error('info')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Client Key</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="client_key" id="client_key" value="{{ $campaign->client_key }}" class="form-control @error('client_key') is-invalid @enderror" placeholder="Client Key Midtrans" required>
                                                            @error('client_key')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Server Key</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="server_key" id="server_key" value="{{ $campaign->server_key }}" class="form-control @error('server_key') is-invalid @enderror" placeholder="Server Key Midtrans" required/>
                                                            @error('server_key')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
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
                                                                    <input type="text" name="target" id="target" value="{{ $campaign->target }}" class="form-control @error('target') is-invalid @enderror" aria-label="Rupiah" required>
                                                                    @error('target')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
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
            .create(document.querySelector('#info2'), {
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

        ClassicEditor
                .create(document.querySelector('#info'), {
                    ckfinder: {
                        uploadUrl: '{{ route('ckeditorimageupload') }}?_token={{ csrf_token() }}'
                    }
                })
                .then(editor => {
                    console.log(`Editor initialized for #info`);
                    let previousData = editor.getData();

                    editor.model.document.on('change:data', () => {
                        const currentData = editor.getData();
                        detectImageDeletion(previousData, currentData);
                        previousData = currentData;
                    });
                })
                .catch(error => {
                    console.error(error);
                });

            function detectImageDeletion(previousData, currentData) {
                const previousImages = extractImageSources(previousData);
                const currentImages = extractImageSources(currentData);

                previousImages.forEach(imageSrc => {
                    if (!currentImages.includes(imageSrc)) {
                        const filename = getFilenameFromUrl(imageSrc);
                        console.log(`Image deleted: ${filename}`);
                        fetch('{{ route('ckeditorimagedelete') }}?_token={{ csrf_token() }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    filename: filename
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log(`Image ${filename} deleted successfully`);
                                } else {
                                    console.error(`Failed to delete image ${filename}:`, data.message);
                                }
                            })
                            .catch(error => {
                                console.error(`Error while deleting image ${filename}`, error);
                            });
                    }
                });
            }

            function getFilenameFromUrl(url) {
                const parts = url.split('/');
                return parts.pop();
            }



            function extractImageSources(data) {
                const imgTags = data.match(/<img[^>]+src="([^">]+)"/g) || [];
                const sources = imgTags.map(tag => {
                    const match = tag.match(/src="([^">]+)"/);
                    return match ? match[1] : null;
                }).filter(src => src);

                return sources;
            }

    </script>
</div>
@include('template.footer')
