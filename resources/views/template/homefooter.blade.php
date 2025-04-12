<div class="footer-nav shadow w-100 py-2">
    <div class="d-flex justify-content-center">
        <div class="home-custom-col">
            <div class="d-flex justify-content-between w-100">
                <a href="{{ route('home') }}" class="text-center {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="menu-icon mdi mdi-home"></i>
                    <div>Home</div>
                </a>
                <a href="{{ route('campaignpayment.daftarcampaign') }}" class="text-center {{ request()->routeIs('home') ? '' : 'active' }}">
                    <i class="menu-icon mdi mdi-heart-box"></i>
                    <div>Donasi</div>
                </a>
            </div>
        </div>
    </div>
</div>



