@extends('layouts.app')

@section('title', 'Dashboard Admin - Perpustakaan SMPN 1 Balen')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan
        </a>
    </div>

    <!-- Content Row - Cards untuk Statistik -->
    <div class="row">

        <!-- Total Buku Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Buku</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">250</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buku Dipinjam Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Buku Dipinjam</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">45</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Siswa Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Siswa
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">150</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Denda Belum Dibayar Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Denda Belum Dibayar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 50.000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Tabel dan Grafik -->
    <div class="row">

        <!-- Tabel Peminjaman Terbaru -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Peminjaman Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>001234567</td>
                                    <td>Ahmad Fauzi</td>
                                    <td>Matematika Kelas 7</td>
                                    <td>15/01/2026</td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>001234568</td>
                                    <td>Siti Aisyah</td>
                                    <td>Bahasa Indonesia</td>
                                    <td>15/01/2026</td>
                                    <td><span class="badge badge-success">Disetujui</span></td>
                                </tr>
                                <tr>
                                    <td>001234569</td>
                                    <td>Budi Santoso</td>
                                    <td>IPA Terpadu</td>
                                    <td>14/01/2026</td>
                                    <td><span class="badge badge-success">Disetujui</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('admin.books.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-plus-circle text-primary"></i> Tambah Buku Baru
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-tags text-success"></i> Tambah Kategori
                        </a>
                        <a href="{{ route('admin.users.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-plus text-info"></i> Tambah User
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-pdf text-danger"></i> Download Laporan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informasi Sistem -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Denda</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Keterlambatan:</strong> Rp 2.000/hari</p>
                    <p class="mb-0"><strong>Rusak/Hilang:</strong> Rp 100.000</p>
                </div>
            </div>
        </div>

    </div>

@endsection

{{-- Contoh penggunaan stack untuk JavaScript khusus halaman ini --}}
@push('scripts')
<script>
    console.log('Dashboard Admin loaded');
    // Tambahkan JavaScript khusus untuk dashboard admin di sini
</script>
@endpush
