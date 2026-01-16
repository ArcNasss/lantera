<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Register Perpustakaan SMPN 1 Balen">
    <meta name="author" content="Kelompok 7">

    <title>Daftar Akun - Perpustakaan SMPN 1 Balen</title>

    <!-- Custom fonts -->
    <link href="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-1">Daftar Akun Siswa</h1>
                                <p class="mb-4">Perpustakaan SMPN 1 Balen</p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="user" method="POST" action="{{ route('register.store') }}">
                                @csrf

                                <div class="form-group">
                                    <input type="text"
                                           class="form-control form-control-user @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           placeholder="Nama Lengkap"
                                           value="{{ old('name') }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="text"
                                           class="form-control form-control-user @error('nisn') is-invalid @enderror"
                                           id="nisn"
                                           name="nisn"
                                           placeholder="NISN (10 Digit)"
                                           value="{{ old('nisn') }}"
                                           maxlength="10"
                                           required>
                                    @error('nisn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted ml-3">
                                        <i class="fas fa-info-circle"></i> Gunakan NISN untuk login nanti
                                    </small>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password"
                                               class="form-control form-control-user @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               placeholder="Password"
                                               required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password"
                                               class="form-control form-control-user"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               placeholder="Ulangi Password"
                                               required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-user-plus"></i> Daftar Akun
                                </button>
                            </form>

                            <hr>

                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Pendaftaran hanya untuk Siswa. Admin dan Petugas didaftarkan oleh Admin sistem.
                                </small>
                            </div>

                            <div class="text-center mt-2">
                                <a class="small" href="{{ route('login') }}">Sudah punya akun? Login di sini!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js') }}"></script>

</body>
</html>
