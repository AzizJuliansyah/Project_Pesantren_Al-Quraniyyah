@include('template.header')
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo text-center">
                  <img src="{{ asset('assets/images/logo-alquraniyyah.png') }}" alt="logo" style="width: 100px;">
                </div>
                <h4 class="text-center">Hello! Selamat Datang!!</h4>
                <h6 class="fw-light text-center">Log In Untuk Melanjutkan.</h6>
                @include('komponen.pesan')
                <form class="pt-3" method="POST" action="{{ route('login.submit') }}">
                  @csrf
                  <div class="form-group">
                    <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}"  autofocus>
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" >
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg btn-block auth-form-btn">SIGN IN</button>
                  </div>
                </form>
                <p class="text-description text-center">Hanya Untuk Admin, </p>
                <p class="text-description text-center"><a href="/">Kembali Ke Halaman Landing Page</a></p>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>