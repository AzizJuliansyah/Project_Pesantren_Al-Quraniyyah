@include('template.header')
@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        @if (Auth::user())
            @include('template.sidebar')
        @endif
        <div class="d-flex justify-content-center">
            <div class="content-wrapper w-100">
                <div class="row mt-2 justify-content-center">
                    <div class="card">
                        <div class="card-header bg-transparent p-0 mb-2 mt-2">
                            @if($campaign->foto)
                                <img src="{{ asset('storage/' . $campaign->foto) }}" alt="{{ $campaign->nama }}" class="img-fluid" width="500">
                            @endif
                        </div>
                        <div class="card-body p-0 mt-2 mb-2">
                            <div class="form-group">
                                <div class="card-title">
                                    <h2 class="font-weight-bold"><strong>{{ $campaign->nama }}</strong></h2>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="text-description">Target Donasi:</p>
                                <h3 class="text-primary"><strong>Rp{{ number_format($campaign->target, 0) }}</strong></h3>
                            </div>
                            <div class="form-group">
                                <p class="text-description">Donasi Terkumpul:</p>
                                <h3 class="text-primary"><strong>Rp{{ number_format(2500000, 0) }}</strong></h3>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! $campaign->info !!}
                            </div>
                            <div class="form-group">
                                        <a href="{{ route('campaignpayment.show', $campaign->slug) }}" class="btn btn-primary">View Details</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- main-panel ends -->
    </div>
    @include('template.copyright')
    <!-- page-body-wrapper ends -->
</div>
@include('template.footer')