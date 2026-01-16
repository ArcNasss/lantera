@extends('layouts.app')

@section('title', 'Data Buku - Perpustakaan SMPN 1 Balen')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Buku</h1>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Buku Baru</span>
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Buku Perpustakaan</h6>
        </div>
        <div class="card-body">
            {{-- Form Pencarian --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('admin.books.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari judul buku atau pengarang..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <select class="form-control" style="width: 200px; display: inline-block;" onchange="window.location.href='?category=' + this.value">
                        <option value="">Semua Kategori</option>
                        <option value="1">Matematika</option>
                        <option value="2">Bahasa Indonesia</option>
                        <option value="3">IPA</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Contoh data dummy --}}
                        <tr>
                            <td>1</td>
                            <td>BK001</td>
                            <td>Matematika Kelas 7</td>
                            <td>Prof. Dr. Ahmad</td>
                            <td><span class="badge badge-primary">Matematika</span></td>
                            <td>15</td>
                            <td><span class="badge badge-success">Tersedia</span></td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>BK002</td>
                            <td>Bahasa Indonesia Kelas 7</td>
                            <td>Dr. Siti Nurhaliza</td>
                            <td><span class="badge badge-info">Bahasa</span></td>
                            <td>20</td>
                            <td><span class="badge badge-success">Tersedia</span></td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>BK003</td>
                            <td>IPA Terpadu Kelas 7</td>
                            <td>Budi Prasetyo, S.Pd</td>
                            <td><span class="badge badge-success">IPA</span></td>
                            <td>0</td>
                            <td><span class="badge badge-danger">Habis</span></td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

@endsection

@push('styles')
{{-- Tambahkan CSS khusus untuk halaman ini jika diperlukan --}}
@endpush

@push('scripts')
<script>
    // Contoh JavaScript untuk halaman ini
    console.log('Halaman data buku loaded');
</script>
@endpush
