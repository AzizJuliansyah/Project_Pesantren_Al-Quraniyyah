@include('template.header')

@include('template.navbar')
@include('komponen.pesan')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        @include('template.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <a href="{{ route('alumni.index') }}"><i class="fa fa-arrow-left me-2"></i> Kembali</a>
                <div class="row mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('alumni.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group">
                                            <h4 class="card-title float-start">Tambah Data Alumni</h4>
                                            <div class="float-end">
                                                <button type="submit" name="action" value="save_add" class="btn btn-md btn-inverse-warning btn-fw me-2">
                                                    Simpan, dan Tambah Lagi <i class="fa fa-plus ms-2"></i>
                                                </button>

                                                <button type="submit" name="action" value="save" class="btn btn-md btn-inverse-success btn-fw">
                                                    Simpan <i class="fa fa-plus ms-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 grid-margin">
                                            <p class="card-description"> Personal info </p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Nama Lengkap</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" />
                                                            @error('nama')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">No Telepon</label>
                                                        <div class="col-sm-9">
                                                            <input type="number" min="0" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" class="form-control @error('no_telepon') is-invalid @enderror" />
                                                            @error('no_telepon')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Tempat Lahir</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control @error('tempat_lahir') is-invalid @enderror" />
                                                            @error('tempat_lahir')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Tanggal Lahir</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control @error('tanggal_lahir') is-invalid @enderror">
                                                            @error('tanggal_lahir')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Alamat</label>
                                                        <div class="col-sm-9">
                                                            <textarea name="alamat" id="alamat" class="textarea-control @error('alamat') is-invalid @enderror" cols="50" rows="5" >{{ old('alamat') }}</textarea>
                                                            @error('alamat')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Pendidikan Terakhir</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" class="form-control @error('pendidikan_terakhir') is-invalid @enderror" />
                                                            @error('pendidikan_terakhir')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Angkatan Ke-</label>
                                                        <div class="col-sm-9">
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single w-100 @error('angkatan') is-invalid @enderror" name="angkatan" id="angkatan" >
                                                                    <option disabled selected>Pilih Angkatan</option>
                                                                    @foreach ($angkatan as $index => $item)
                                                                        <option value="{{ $item->id }}">{{ $item->angkatan }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('angkatan')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="card-description mt-3"> Melanjutkan </p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Status</label>
                                                        <div class="col-sm-9">
                                                            <div class="form-group">
                                                                <select class="js-example-basic-single w-100" name="status" id="status" >
                                                                    <option disabled selected>Pilih Status</option>
                                                                    @foreach ($status as $index => $item)
                                                                        <option value="{{ $item->id }}">{{ $item->status }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('status')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 ">Nama Tempat</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="usaha" id="usaha" value="{{ old('usaha') }}" class="form-control @error('usaha') is-invalid @enderror" placeholder="Nama Tempat Lembaga/Usaha" />
                                                            @error('usaha')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
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
      $('#datepicker-popup').datepicker();
    </script>
</div>
@include('template.footer')
