<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
              <a class="nav-link" href="/admin">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item nav-category">Admin</li>
            <li class="nav-item {{ request()->routeIs('administrator') ? 'active' : '' }}">
              <a class="nav-link" href="/settings">
                <i class="menu-icon mdi mdi-application-cog-outline"></i>
                <span class="menu-title">Administrator</span>
              </a>
            </li>
            <li class="divider"></li>

            {{-- !! --}}
            <li class="nav-item nav-category">Pendataan Alumni</li>
            <li class="nav-item {{ request()->routeIs('angkatan') ? 'active' : '' }}">
              <a class="nav-link" href="/angkatan">
                <i class="menu-icon mdi mdi-numeric"></i>
                <span class="menu-title">Angkatan</span>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('status') ? 'active' : '' }}">
              <a class="nav-link" href="/status">
                <i class="menu-icon mdi mdi-list-status"></i>
                <span class="menu-title">Status</span>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('alumni', 'alumni.create', 'alumni.editalumni') ? 'active' : '' }}">
              <a class="nav-link" href="/alumni">
                <i class="menu-icon mdi mdi-account-school-outline"></i>
                <span class="menu-title">Alumni</span>
              </a>
            </li>
            {{-- !! --}}
            


            {{-- !! --}}
            <li class="nav-item nav-category">Pendataan Campaign</li>
            <li class="nav-item {{ request()->routeIs('campaign.index', 'campaign.create', 'campaign.editcampaign') ? 'active' : '' }}">
              <a class="nav-link" href="/campaign">
                <i class="menu-icon mdi mdi-bullhorn-variant-outline"></i>
                <span class="menu-title">Daftar Campaign</span>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('campaign.data') ? 'active' : '' }}">
              <a class="nav-link" href="/pembukuan">
                <i class="menu-icon mdi mdi-notebook-edit-outline"></i>
                <span class="menu-title">Pembukuan Campaign</span>
              </a>
            </li>
            {{-- !! --}}
            

            
            {{-- !! --}}
            <li class="nav-item nav-category">Pendataan Uang Kas</li>
            <li class="nav-item {{ request()->routeIs('uangkas.index', 'detail.uangkas') ? 'active' : '' }}">
              <a class="nav-link" href="/uangkas">
                <i class="menu-icon mdi mdi-book-edit-outline"></i>
                <span class="menu-title">Pembukuan Uangkas</span>
              </a>
            </li>
            <li class="nav-item {{ request()->routeIs('pengeluaran.uangkas') ? 'active' : '' }}">
              <a class="nav-link" href="/pengeluaran">
                <i class="menu-icon mdi mdi-notebook-minus"></i>
                <span class="menu-title">Pengeluaran Uangkas</span>
              </a>
            </li>
            {{-- !! --}}



            {{-- <li class="nav-item">
              <a class="nav-link" href="docs/documentation.html">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Documentation</span>
              </a>
            </li> --}}
          </ul>
        </nav>