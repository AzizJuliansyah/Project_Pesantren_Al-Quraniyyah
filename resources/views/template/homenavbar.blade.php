<div class="d-flex justify-content-center">
        <div class="card card-fixed p-0 shadow" style="background-color: #0056b3 ;border-radius: 1px;">
          <div class="d-flex justify-content-center">
            <div class="home-custom-col m-3">
              <div class="d-flex justify-content-between w-100">
                <div class="">
                  @php
                      $item = \App\Models\Administrator::where('item_id', 1)->first();
                  @endphp

                  @if($item->item)
                    @if(file_exists($item->item))
                      <a class="" href="/login">
                        <img src="{{ asset($item->item) }}" class="img-fluid rounded-circle border border-light border-1" style="max-width: 40px; height: auto;" width="20" alt="logo" />
                      </a>
                    @else
                      <a href="/login">
                        {{ $item->item }}
                      </a>
                    @endif
                  @else
                    <a href="/login">
                      <p>No image available</p>
                    </a>
                  @endif
                </div>
                <div class="ms-4">
                  <div class="d-flex justify-content-around">
                    @if (Auth::user())
                      <a href="/admin" class="custom-button mt-1 me-4" >Dashboard</a>
                      <h5 class="d-none d-md-block d-lg-block text-light mt-3 me-4">Welcome Back, <span class="text-light fw-bold">{{ Auth::user()->name }}</span></h5>
                    @else
                      <div class="search-container">
                        <input type="text" id="searchInput" class="search-input" value="{{ request('search') }}" placeholder="Cari Program Kebaikan..." onkeypress="handleSearch(event)">
                        <i class="fa fa-search search-icon" onclick="redirectToSearch()"></i>
                      </div>
                    @endif
                    @if (Auth::user())
                      <li class="nav-item dropdown  d-lg-block user-dropdown mt-1 ps-0">
                        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                          <img class="img-xs rounded-circle" src="{{ asset('assets/images/profile.jpeg') }}" alt="Profile image"> </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                          <div class="dropdown-header text-center">
                            <img class="img-sm rounded-circle" src="{{ asset('assets/images/profile.jpeg') }}" alt="Profile image">
                            <p class="mb-1 mt-3 fw-semibold">{{ Auth::user()->name }}</p>
                            <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
                          </div>
                          <a class="dropdown-item" href="/profile"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile</a>
                          <a class="dropdown-item" href="/logout"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
                        </div>
                      </li>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>