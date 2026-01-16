@extends('layouts.app')

@section('title', 'Dashboard Siswa - Perpustakaan SMPN 1 Balen')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Siswa</h1>
        <div>
            <span class="badge badge-lg badge-primary p-2">
                <i class="fas fa-id-card"></i> NISN: {{ auth()->user()->nisn ?? '0012345678' }}
            </span>
        </div>
    </div>

    <!-- Alert jika ada denda -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-triangle"></i> Perhatian!</strong> 
        Anda memiliki denda keterlambatan sebesar <strong>Rp 4.000</strong>. Segera lakukan pembayaran!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <!-- Content Row - Info Cards -->
    <div class="row">

        <!-- Buku Dipinjam -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Buku Dipinjam</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Peminjaman -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Peminjaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengajuan Pending -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Persetujuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">1</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Denda -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Denda</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 4.000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Buku yang Sedang Dipinjam -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buku yang Sedang Dipinjam</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>BK001</td>
                                    <td>Matematika Kelas 7</td>
                                    <td>10/01/2026</td>
                                    <td>17/01/2026</td>
                                    <td><span class="badge badge-success">Aktif</span></td>
                                </tr>
                                <tr class="table-warning">
                                    <td>BK015</td>
                                    <td>Bahasa Indonesia</td>
                                    <td>08/01/2026</td>
                                    <td>15/01/2026</td>
                                    <td><span class="badge badge-danger">Terlambat 1 hari</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="#" class="btn btn-primary btn-block mt-3">
                        <i class="fas fa-history"></i> Lihat Semua Riwayat
                    </a>
                </div>
            </div>

            <!-- Buku Terpopuler -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buku Terpopuler Bulan Ini</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card border-left-primary">
                                <div class="card-body">
                                    <h6 class="font-weight-bold">Matematika Kelas 7</h6>
                                    <p class="small text-muted mb-1">Kategori: Matematika</p>
                                    <p class="small mb-2">Stok: <span class="badge badge-success">15</span></p>
                                    <a href="#" class="btn btn-sm btn-primary btn-block">Pinjam</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-left-success">
                                <div class="card-body">
                                    <h6 class="font-weight-bold">IPA Terpadu</h6>
                                    <p class="small text-muted mb-1">Kategori: IPA</p>
                                    <p class="small mb-2">Stok: <span class="badge badge-success">8</span></p>
                                    <a href="#" class="btn btn-sm btn-success btn-block">Pinjam</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-left-info">
                                <div class="card-body">
                                    <h6 class="font-weight-bold">Bahasa Inggris</h6>
                                    <p class="small text-muted mb-1">Kategori: Bahasa</p>
                                    <p class="small mb-2">Stok: <span class="badge badge-danger">0</span></p>
                                    <button class="btn btn-sm btn-secondary btn-block" disabled>Habis</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Menu Cepat</h6>
                </div>
                <div class="card-body">
                    <a href="#" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-book"></i> Lihat Semua Buku
                    </a>
                    <a href="#" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-plus-circle"></i> Ajukan Peminjaman
                    </a>
                    <a href="#" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-history"></i> Riwayat Peminjaman
                    </a>
                    <a href="#" class="btn btn-warning btn-block">
                        <i class="fas fa-exclamation-triangle"></i> Info Denda Saya
                    </a>
                </div>
            </div>

            <!-- Informasi Denda -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-danger">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-info-circle"></i> Informasi Denda
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Keterlambatan Pengembalian:</strong>
                        <p class="mb-0">Rp 2.000 <small class="text-muted">per hari</small></p>
                    </div>
                    <hr>
                    <div>
                        <strong>Buku Rusak/Hilang:</strong>
                        <p class="mb-0">Rp 100.000 <small class="text-muted">per buku</small></p>
                    </div>
                </div>
            </div>

            <!-- Pengumuman -->
            <div class="card shadow">
                <div class="card-header py-3 bg-info">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-bullhorn"></i> Pengumuman
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <p><strong>16 Januari 2026</strong></p>
                        <p>Perpustakaan akan tutup pada tanggal 20-22 Januari 2026 untuk inventarisasi buku.</p>
                        <hr>
                        <p><strong>15 Januari 2026</strong></p>
                        <p>Buku baru kategori IPA sudah tersedia di perpustakaan!</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Script khusus untuk dashboard siswa
    console.log('Dashboard Siswa loaded');
</script>
@endpush
