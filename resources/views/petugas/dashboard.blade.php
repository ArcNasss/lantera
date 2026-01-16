@extends('layouts.app')

@section('title', 'Dashboard Petugas - Perpustakaan SMPN 1 Balen')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Petugas</h1>
        <a href="#" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak Laporan
        </a>
    </div>

    <!-- Content Row - Statistics -->
    <div class="row">

        <!-- Pengajuan Pending -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pengajuan Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peminjaman Aktif -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Peminjaman Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">45</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terlambat -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Terlambat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengembalian Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Kembali Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-undo fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Pengajuan Peminjaman Baru -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Pengajuan Peminjaman Baru</h6>
                    <span class="badge badge-warning badge-pill">5 Pending</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Kode Buku</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Ajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>0012345678</td>
                                    <td>Ahmad Fauzi</td>
                                    <td>BK001</td>
                                    <td>Matematika Kelas 7</td>
                                    <td>16/01/2026</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>0012345679</td>
                                    <td>Siti Aisyah</td>
                                    <td>BK005</td>
                                    <td>IPA Terpadu</td>
                                    <td>16/01/2026</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="#" class="btn btn-primary btn-block mt-3">
                        Lihat Semua Pengajuan
                    </a>
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
                    <a href="#" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-tasks"></i> Verifikasi Peminjaman
                    </a>
                    <a href="#" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-undo"></i> Proses Pengembalian
                    </a>
                    <a href="#" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-print"></i> Cetak Kartu Peminjaman
                    </a>
                    <a href="#" class="btn btn-danger btn-block">
                        <i class="fas fa-file-pdf"></i> Generate Laporan
                    </a>
                </div>
            </div>

            <!-- Alert Terlambat -->
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3 bg-danger">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-exclamation-triangle"></i> Perlu Perhatian
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>8 Siswa</strong> terlambat mengembalikan buku</p>
                    <a href="#" class="btn btn-sm btn-danger btn-block">Lihat Detail</a>
                </div>
            </div>

            <!-- Statistik Hari Ini -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Hari Ini</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Peminjaman Disetujui:</span>
                            <strong>7</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Peminjaman Ditolak:</span>
                            <strong>2</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Pengembalian:</span>
                            <strong>12</strong>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between">
                            <span>Denda Terkumpul:</span>
                            <strong>Rp 24.000</strong>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Buku yang Harus Dikembalikan Hari Ini -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buku yang Harus Dikembalikan Hari Ini (16 Jan 2026)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Kode Buku</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>0012345680</td>
                                    <td>Budi Santoso</td>
                                    <td>BK010</td>
                                    <td>Bahasa Indonesia</td>
                                    <td>09/01/2026</td>
                                    <td><span class="badge badge-warning">Belum Dikembalikan</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Proses Pengembalian
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>0012345681</td>
                                    <td>Rina Wati</td>
                                    <td>BK012</td>
                                    <td>IPS Kelas 7</td>
                                    <td>09/01/2026</td>
                                    <td><span class="badge badge-warning">Belum Dikembalikan</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Proses Pengembalian
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Script khusus untuk dashboard petugas
    console.log('Dashboard Petugas loaded');
</script>
@endpush
