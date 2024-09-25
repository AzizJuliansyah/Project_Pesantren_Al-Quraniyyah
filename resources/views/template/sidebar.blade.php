<nav class="sidebar sidebar-offcanvas shadow" id="sidebar">
          <ul class="nav">
            <li class="nav-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
              <a class="nav-link" href="/admin">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item nav-category">Admin</li>
            
            <li class="nav-item {{ request()->routeIs('alumni', 'alumni.create', 'alumni.editalumni', 'angkatan', 'status') ? 'active' : '' }}">
              <a class="nav-link" data-bs-toggle="collapse" href="#alumni" aria-expanded="false" aria-controls="alumni">
                <i class="menu-icon mdi mdi-account-school-outline"></i>
                <span class="menu-title">Alumni</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="alumni">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item {{ request()->routeIs('angkatan') ? 'active' : '' }}"> <a class="nav-link" href="/angkatan">Data Angkatan</a></li>
                  <li class="nav-item {{ request()->routeIs('status') ? 'active' : '' }}"> <a class="nav-link" href="/status">Data Status</a></li>
                  <li class="nav-item {{ request()->routeIs('alumni') ? 'active' : '' }}"> <a class="nav-link" href="/alumni">Data Alumni</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item {{ request()->routeIs('campaign', 'campaign.create','campaign.editcampaign') ? 'active' : '' }}">
              <a class="nav-link" data-bs-toggle="collapse" href="#campaign" aria-expanded="false" aria-controls="campaign">
                <i class="menu-icon mdi mdi-monitor-dashboard"></i>
                <span class="menu-title">Campaign</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="campaign">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item {{ request()->routeIs('campaign.index', 'campaign.create', 'campaign.editcampaign') ? 'active' : '' }}"> <a class="nav-link {{ request()->routeIs('campaign.index', 'campaign.create', 'campaign.editcampaign') ? 'active' : '' }}" href="/campaign">Daftar Campaign</a></li>
                  <li class="nav-item {{ request()->routeIs('campaign.show') ? 'active' : '' }}"> <a class="nav-link" href="/campaign/data">Data Campaign</a></li>
                </ul>
              </div>
            </li>


            <li class="nav-item {{ request()->routeIs('uangkas') ? 'active' : '' }}">
              <a class="nav-link" data-bs-toggle="collapse" href="#uangkas" aria-expanded="false" aria-controls="uangkas">
                <i class="menu-icon mdi mdi-cash-multiple"></i>
                <span class="menu-title">Uang Kas</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="uangkas">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item {{ request()->routeIs('dashboard.uangkas') ? 'active' : '' }}"> <a class="nav-link" href="{{ route('dashboard.uangkas') }}">Dashboard Uangkas</a></li>
                  <li class="nav-item {{ request()->routeIs('uangkas.index', 'detail.uangkas') ? 'active' : '' }}"> <a class="nav-link" href="/uangkas">Data Uangkas</a></li>
                  <li class="nav-item {{ request()->routeIs('pengeluaran.uangkas') ? 'active' : '' }}"> <a class="nav-link" href="/pengeluaran/uangkas">Pengeluaran Uangkas</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="docs/documentation.html">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Documentation</span>
              </a>
            </li>
          </ul>
        </nav>