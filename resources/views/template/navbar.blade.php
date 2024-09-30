<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row ">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          @if (Auth::user())
            @if (request()->routeIs('home', 'campaignpayment.daftarcampaign', 'campaignpayment.show', 'campaignpayment.detail', 'donasi.payment', 'payment.success', 'payment.pending', 'payment.error', 'pembayaran.uangkas'))
                
            @else
              <div class="me-3">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                  <span class="icon-menu"></span>
                </button>
              </div>
            @endif
          @endif
          <div>
            @php
                $item = \App\Models\Administrator::where('item_id', 1)->first();
            @endphp

            @if($item->item)
              @if(Storage::exists('public/' . $item->item))
                <a class="navbar-brand brand-logo" href="/login">
                  <img src="{{ asset('storage/' . $item->item) }}" alt="logo" />
                </a>
                <a class="navbar-brand brand-logo-mini ms-2 mb-2" href="/login">
                  <img src="{{ asset('storage/' . $item->item) }}" alt="logo" />
                </a>
              @else
                {{ $item->item }}
              @endif
            @else
                <p>No image available</p>
            @endif
            
            
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              @if (Auth::user())
                @if (request()->routeIs('campaignpayment.daftarcampaign', 'campaignpayment.show', 'campaignpayment.detail', 'donasi.payment', 'payment.success', 'payment.pending', 'payment.error', 'pembayaran.uangkas'))
                  <a href="/admin" class="btn btn-sm btn-inverse-info me-3">Dashboard</a>
                  <a href="/" class="btn btn-sm btn-inverse-info">Home</a>
                @elseif (request()->routeIs('home'))
                  <a href="/admin" class="btn btn-sm btn-inverse-info me-3">Dashboard</a>
                  <a href="/daftarcampaign" class="btn btn-sm btn-inverse-info">Daftar Campaign</a>
                @else
                  <a href="/" class="btn btn-sm btn-inverse-info me-3">Home</a>
                  <a href="/daftarcampaign" class="btn btn-sm btn-inverse-info">Daftar Campaign</a>
                @endif
              @endif
            </li>
              <li class="nav-item">
                @if (Auth::user())
                  <h5 class="d-none d-md-block d-lg-block mt-2">Welcome Back, <span class="text-black fw-bold">{{ Auth::user()->name }}</span></h5>
                @endif
              </li>
            @if (Auth::user())
              <li class="nav-item dropdown  d-lg-block user-dropdown ps-0">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <img class="img-xs rounded-circle" src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Profile image"> </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                  <div class="dropdown-header text-center">
                    <img class="img-md rounded-circle" src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Profile image">
                    <p class="mb-1 mt-3 fw-semibold">{{ Auth::user()->name }}</p>
                    <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
                  </div>
                  <a class="dropdown-item" href="/profile"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile</a>
                  <a class="dropdown-item" href="/logout"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
                </div>
              </li>
            @else
              <li class="nav-item">
                <a href="/" class="text-black fw-bold me-4">Home</a>
                <a href="{{ route('campaignpayment.daftarcampaign') }}" class="text-black fw-bold">Campaign</a>
              </li>
            @endif
          </ul>
          @if (Auth::user())
            @if (request()->routeIs('home', 'campaignpayment.daftarcampaign', 'campaignpayment.show', 'campaignpayment.detail', 'donasi.payment', 'payment.success', 'payment.pending', 'payment.error', 'pembayaran.uangkas'))

            @else
              <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
              </button>
            @endif
          @endif
        </div>
      </nav>