# 📚 Dokumentasi Template Blade - Perpustakaan SMPN 1 Balen

## 👥 Kelompok 7

---

## 📋 Struktur Folder

```
resources/views/
├── layouts/
│   └── app.blade.php          # Layout utama aplikasi
├── components/
│   ├── sidebar.blade.php      # Komponen sidebar
│   ├── navbar.blade.php       # Komponen navbar
│   ├── footer.blade.php       # Komponen footer
│   └── logout-modal.blade.php # Modal logout
├── admin/
│   ├── dashboard.blade.php    # Dashboard admin
│   └── books/
│       └── index.blade.php    # Halaman data buku
├── petugas/
│   └── (akan dibuat oleh kelompok)
├── peminjam/
│   └── (akan dibuat oleh kelompok)
└── auth/
    └── (akan dibuat oleh kelompok)
```

---

## 🎯 Cara Menggunakan Template

### 1. **Membuat Halaman Baru**

Untuk membuat halaman baru, gunakan struktur ini:

```blade
@extends('layouts.app')

@section('title', 'Judul Halaman')

@section('content')
    <!-- Konten halaman Anda di sini -->
    <h1>Hello World!</h1>
@endsection
```

### 2. **Menambahkan CSS Khusus**

Jika halaman Anda butuh CSS tambahan:

```blade
@push('styles')
<style>
    .custom-class {
        color: red;
    }
</style>
@endpush
```

### 3. **Menambahkan JavaScript Khusus**

Jika halaman Anda butuh JavaScript tambahan:

```blade
@push('scripts')
<script>
    console.log('Halaman saya loaded!');
    
    // Fungsi JavaScript Anda
    function myFunction() {
        alert('Hello!');
    }
</script>
@endpush
```

---

## 🔧 Komponen yang Tersedia

### **Sidebar** (`components/sidebar.blade.php`)
- Otomatis menyesuaikan menu berdasarkan role user (admin/petugas/peminjam)
- Menandai menu yang aktif secara otomatis

### **Navbar** (`components/navbar.blade.php`)
- Search bar untuk cari buku
- Notifikasi (untuk admin dan petugas)
- User dropdown dengan profile dan logout

### **Footer** (`components/footer.blade.php`)
- Footer sederhana dengan copyright

---

## 🎨 Komponen Bootstrap yang Sering Dipakai

### **1. Cards**
```blade
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Judul Card</h6>
    </div>
    <div class="card-body">
        Konten card di sini
    </div>
</div>
```

### **2. Buttons**
```blade
<!-- Primary Button -->
<button class="btn btn-primary">Primary</button>

<!-- Success Button -->
<button class="btn btn-success">Success</button>

<!-- Danger Button -->
<button class="btn btn-danger">Danger</button>

<!-- Button dengan Icon -->
<button class="btn btn-primary btn-icon-split">
    <span class="icon text-white-50">
        <i class="fas fa-check"></i>
    </span>
    <span class="text">Save</span>
</button>
```

### **3. Tables**
```blade
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>
                    <button class="btn btn-sm btn-info">Detail</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

### **4. Forms**
```blade
<form action="{{ route('admin.books.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="judul">Judul Buku</label>
        <input type="text" class="form-control" id="judul" name="judul" required>
    </div>
    
    <div class="form-group">
        <label for="kategori">Kategori</label>
        <select class="form-control" id="kategori" name="kategori_id">
            <option value="">Pilih Kategori</option>
            <option value="1">Matematika</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
```

### **5. Badges**
```blade
<span class="badge badge-success">Tersedia</span>
<span class="badge badge-danger">Habis</span>
<span class="badge badge-warning">Pending</span>
<span class="badge badge-info">Info</span>
```

### **6. Alerts**
```blade
<div class="alert alert-success" role="alert">
    Data berhasil disimpan!
</div>

<div class="alert alert-danger" role="alert">
    Terjadi kesalahan!
</div>
```

---

## 📊 Contoh Halaman Dashboard

Lihat file `admin/dashboard.blade.php` untuk contoh lengkap dashboard dengan:
- Cards statistik (4 cards dengan data)
- Tabel peminjaman terbaru
- Quick actions
- Informasi denda

---

## 📝 Contoh Halaman Data (CRUD)

Lihat file `admin/books/index.blade.php` untuk contoh:
- Tabel data dengan aksi (view, edit, delete)
- Search dan filter
- Pagination
- Button tambah data

---

## 🎯 Tugas untuk Teman-Teman

### **1. Untuk yang handle ADMIN:**
- [ ] Buat halaman Categories (index, create, edit)
- [ ] Buat halaman Users (index, create, edit)
- [ ] Buat halaman Generate Laporan

### **2. Untuk yang handle PETUGAS:**
- [ ] Buat dashboard petugas
- [ ] Buat halaman verifikasi peminjaman
- [ ] Buat halaman data pengembalian
- [ ] Buat fitur cetak kartu peminjaman (PDF)

### **3. Untuk yang handle SISWA/PEMINJAM:**
- [ ] Buat dashboard siswa
- [ ] Buat halaman daftar buku (dengan search & filter)
- [ ] Buat halaman ajukan peminjaman
- [ ] Buat halaman riwayat peminjaman
- [ ] Buat halaman info denda

### **4. Untuk yang handle AUTH:**
- [ ] Buat halaman login
- [ ] Buat halaman register (untuk siswa)
- [ ] Implementasi middleware untuk role

---

## 💡 Tips:

1. **Selalu extend dari `layouts.app`** untuk konsistensi tampilan
2. **Gunakan route name** bukan hard-code URL: `{{ route('admin.books.index') }}`
3. **Manfaatkan @push untuk CSS/JS** khusus per halaman
4. **Perhatikan role user** saat membuat fitur
5. **Cek dokumentasi SB Admin 2** untuk komponen tambahan

---

## 🔗 Link Berguna

- [SB Admin 2 Documentation](https://startbootstrap.com/theme/sb-admin-2)
- [Laravel Blade Documentation](https://laravel.com/docs/blade)
- [Bootstrap 4 Documentation](https://getbootstrap.com/docs/4.6)
- [Font Awesome Icons](https://fontawesome.com/icons)

---

## 📞 Komunikasi Tim

Jika ada yang bingung atau butuh bantuan:
1. Tanya di grup WhatsApp
2. Koordinasi dengan ketua kelompok
3. Review code teman sebelum merge
4. Jangan lupa commit dengan pesan yang jelas!

---

**Semangat Kelompok 7! 🚀**

*Dibuat: 16 Januari 2026*
