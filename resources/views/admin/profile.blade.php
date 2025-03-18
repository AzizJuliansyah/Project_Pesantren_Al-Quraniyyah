@include('template.header')

@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        @include('template.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <a href="{{ route('admin.index') }}"><i class="fa fa-arrow-left me-2"></i> Kembali</a>
                <div class="row mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group">
                                        <h4 class="card-title float-start">Tambah Data Alumni</h4>
                                    </div>
                                </div>
                                <div class="card-description">
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <p>Dibuat : {{ Auth::user()->created_at->format('H:i, d-F-Y') }}</p>
                                            </div>
                                            <div class="col-lg-5 col-md-12 col-sm-12">
                                                <p>Terakhir diupdate : {{ Auth::user()->updated_at->format('H:i, d-F-Y') }}</p>
                                            </div>
                                            <div class="col-lg-3 col-md-12 col-sm-12">
                                                <p>Role : {{ Auth::user()->role }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('admin.updateprofile', Auth::user()->id) }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="">
                                            <p class="card-description"> Personal info </p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Nama Lengkap</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="form-control @error('name') is-invalid @enderror"/>
                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Email</label>
                                                        <div class="col-sm-9">
                                                            <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="form-control @error('email') is-invalid @enderror"/>
                                                            @error('email')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-md btn-inverse-success btn-fw">Simpan <i class="fa fa-edit ms-2"></i></button>
                                </form>
                                <form action="{{ route('admin.updatepassword', Auth::user()->id) }}" method="post">
                                    @csrf
                                    <p class="card-description mt-3"> Password </p>
                                    <div class="row">
                                        <div class="col-md-6">      
                                            <div class="form-group row">
                                                <label class="col-sm-3 ">Password Lama</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="old_password" id="old_password" class="form-control @error('old_password') is-invalid @enderror"/>
                                                    @error('old_password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 ">Password Baru</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror"/>
                                                    @error('new_password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 ">Ulangi Password</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="repeat_password" id="repeat_password" class="form-control @error('repeat_password') is-invalid @enderror"/>
                                                    @error('repeat_password')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-md btn-inverse-success btn-fw">Ubah Password <i class="fa fa-edit ms-2"></i></button>
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
</div>
@include('template.footer')
