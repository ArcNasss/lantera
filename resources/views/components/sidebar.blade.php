<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Perpustakaan <sup>SMPN 1 Balen</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('*/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route(auth()->user()->role . '.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    {{-- Menu untuk ADMIN --}}
    @if(auth()->user()->role === 'admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Manajemen Data
        </div>

        <!-- Nav Item - Kategori -->
        <li class="nav-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-fw fa-tags"></i>
                <span>Kategori Buku</span>
            </a>
        </li>

        <!-- Nav Item - Buku -->
        <li class="nav-item {{ request()->is('admin/books*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.books.index') }}">
                <i class="fas fa-fw fa-book"></i>
                <span>Data Buku</span>
            </a>
        </li>

        <!-- Nav Item - User Management -->
        <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Data User</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Laporan
        </div>

        <!-- Nav Item - Laporan -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
                aria-expanded="true" aria-controls="collapseLaporan">
                <i class="fas fa-fw fa-file-pdf"></i>
                <span>Laporan Peminjaman</span>
            </a>
            <div id="collapseLaporan" class="collapse" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Jenis Laporan:</h6>
                    <a class="collapse-item" href="#">Laporan Mingguan</a>
                    <a class="collapse-item" href="#">Laporan Bulanan</a>
                </div>
            </div>
        </li>
    @endif

    {{-- Menu untuk PETUGAS --}}
    @if(auth()->user()->role === 'petugas')
        <!-- Heading -->
        <div class="sidebar-heading">
            Transaksi
        </div>

        <!-- Nav Item - Peminjaman -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-hand-holding"></i>
                <span>Verifikasi Peminjaman</span>
            </a>
        </li>

        <!-- Nav Item - Pengembalian -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-undo"></i>
                <span>Data Pengembalian</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Laporan
        </div>

        <!-- Nav Item - Cetak Kartu -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-print"></i>
                <span>Cetak Kartu</span>
            </a>
        </li>

        <!-- Nav Item - Laporan -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-file-pdf"></i>
                <span>Generate Laporan</span>
            </a>
        </li>
    @endif

    {{-- Menu untuk SISWA/PEMINJAM --}}
    @if(auth()->user()->role === 'peminjam')
        <!-- Heading -->
        <div class="sidebar-heading">
            Perpustakaan
        </div>

        <!-- Nav Item - Daftar Buku -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-book-open"></i>
                <span>Daftar Buku</span>
            </a>
        </li>

        <!-- Nav Item - Pinjam Buku -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-plus-circle"></i>
                <span>Ajukan Peminjaman</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Riwayat
        </div>

        <!-- Nav Item - Riwayat Peminjaman -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Peminjaman</span>
            </a>
        </li>

        <!-- Nav Item - Denda -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-exclamation-triangle"></i>
                <span>Info Denda</span>
            </a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
