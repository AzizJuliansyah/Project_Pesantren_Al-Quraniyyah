<div class="footer-nav w-100 d-flex justify-content-around py-2">
    <a href="{{ route('home') }}" class="text-center {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="menu-icon mdi mdi-home"></i>
        <div>Home</div>
    </a>
    <a href="{{ route('campaignpayment.daftarcampaign') }}" class="text-center {{ request()->routeIs('home') ? '' : 'active' }}">
        <i class="menu-icon mdi mdi-heart-box"></i>
        <div>Donasi</div>
    </a>
</div>

<style>
    .footer-nav {
        position: fixed;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        z-index: 999;
    }
    .footer-nav a {
        text-decoration: none;
        color: gray;
        font-size: 14px;
        flex: 1;
    }
    .footer-nav a.active {
        color: #0099ff;
        font-weight: bold;
    }
    .footer-nav a i {
        font-size: 20px;
        margin-bottom: 5px;
    }
</style>
