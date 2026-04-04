<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GuideController extends Controller
{
    public function admin(): View
    {
        return view('guides.index', $this->buildData('admin'));
    }

    public function adminDetail(string $slug): View
    {
        return view('guides.show', $this->buildDetailData('admin', $slug));
    }

    public function petugas(): View
    {
        return view('guides.index', $this->buildData('petugas'));
    }

    public function petugasDetail(string $slug): View
    {
        return view('guides.show', $this->buildDetailData('petugas', $slug));
    }

    public function peminjam(): View
    {
        return view('guides.index', $this->buildData('peminjam'));
    }

    public function peminjamDetail(string $slug): View
    {
        return view('guides.show', $this->buildDetailData('peminjam', $slug));
    }

    private function buildData(string $role): array
    {
        $base = [
            'lastUpdated' => '17 Maret 2026',
            'heroTitle' => 'Panduan Pengguna',
            'heroSubtitle' => 'Panduan ringkas untuk membantu Anda menggunakan fitur Lantera dengan cepat dan tepat.',
        ];

        if ($role === 'admin') {
            return array_merge($base, [
                'layout' => 'layouts.admin',
                'pageTitle' => 'Panduan Pengguna',
                'activeRoute' => 'admin.guides.index',
                'detailRouteName' => 'admin.guides.show',
                'sections' => [
                    [
                        'slug' => 'dashboard-admin',
                        'title' => 'Dashboard Admin',
                        'subtitle' => 'Memantau ringkasan data sistem',
                        'points' => [
                            'Lihat statistik peminjaman aktif dan pengembalian.',
                            'Pantau total denda serta status pelunasan.',
                            'Akses cepat ke menu manajemen utama.',
                        ],
                        'detail' => [
                            'description' => 'Dashboard admin adalah pusat kontrol untuk memantau performa sistem perpustakaan secara menyeluruh.',
                            'blocks' => [
                                [
                                    'heading' => '1. Statistik Ringkas',
                                    'description' => 'Panel statistik menampilkan indikator utama secara real-time.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '1.1 Membaca Kartu Statistik',
                                            'items' => [
                                                'Perhatikan total peminjaman aktif dan riwayat pengembalian.',
                                                'Gunakan tren angka untuk menilai beban operasional harian.',
                                                'Amati perubahan denda agar cepat menindaklanjuti pembayaran.',
                                            ],
                                        ],
                                        [
                                            'heading' => '1.2 Tindakan Lanjutan',
                                            'items' => [
                                                'Jika pending naik tajam, cek proses persetujuan petugas.',
                                                'Jika denda menumpuk, review alur pengingat pelunasan.',
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'heading' => '2. Akses Cepat Menu',
                                    'description' => 'Gunakan shortcut untuk menuju halaman kerja prioritas.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '2.1 Prioritas Harian',
                                            'items' => [
                                                'Mulai dari peminjaman untuk memantau alur transaksi.',
                                                'Lanjut ke denda untuk melihat status pelunasan.',
                                                'Akhiri dengan buku tamu untuk evaluasi kunjungan.',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'slug' => 'manajemen-data',
                        'title' => 'Manajemen Data',
                        'subtitle' => 'Kelola user, kategori, dan buku',
                        'points' => [
                            'Tambah, ubah, dan hapus data user.',
                            'Kelola kategori buku aktif/nonaktif.',
                            'Kelola buku beserta item kode buku fisik.',
                        ],
                        'detail' => [
                            'description' => 'Menu manajemen data memastikan data master rapi dan konsisten untuk seluruh fitur operasional.',
                            'blocks' => [
                                [
                                    'heading' => '1. Manajemen User',
                                    'description' => 'Kelola akun admin, petugas, dan peminjam.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '1.1 Validasi Data User',
                                            'items' => [
                                                'Pastikan nomor identitas unik.',
                                                'Tentukan role sesuai kebutuhan akses.',
                                                'Gunakan fitur edit untuk koreksi data.',
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'heading' => '2. Manajemen Buku',
                                    'description' => 'Kelola katalog buku dan item fisik berkode.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '2.1 Item Buku Fisik',
                                            'items' => [
                                                'Tambahkan kode buku per eksemplar.',
                                                'Status item harus sesuai kondisi aktual.',
                                                'Jaga konsistensi kategori untuk memudahkan filter.',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'slug' => 'monitoring-peminjaman',
                        'title' => 'Monitoring Peminjaman',
                        'subtitle' => 'Memantau alur pinjam dan kembali',
                        'points' => [
                            'Lihat daftar peminjaman dan filter status.',
                            'Lihat riwayat pengembalian beserta kondisi buku.',
                            'Unduh invoice denda untuk arsip.',
                        ],
                        'detail' => [
                            'description' => 'Monitoring peminjaman membantu admin melihat kualitas layanan dari pengajuan hingga pelunasan.',
                            'blocks' => [
                                [
                                    'heading' => '1. Daftar Peminjaman',
                                    'description' => 'Pantau status transaksi dari satu layar.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '1.1 Filter dan Pencarian',
                                            'items' => [
                                                'Filter berdasarkan status pending/disetujui/ditolak/dikembalikan.',
                                                'Cari berdasarkan nama peminjam atau kode buku.',
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'heading' => '2. Riwayat Pengembalian',
                                    'description' => 'Review kondisi buku dan nominal denda.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '2.1 Audit Denda',
                                            'items' => [
                                                'Bandingkan kondisi buku dengan nominal denda.',
                                                'Unduh invoice saat membutuhkan bukti transaksi.',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'slug' => 'buku-tamu',
                        'title' => 'Buku Tamu',
                        'subtitle' => 'Kelola data pengunjung perpustakaan',
                        'points' => [
                            'Cari data berdasarkan nama atau keperluan.',
                            'Lihat waktu kunjungan secara detail.',
                            'Export laporan buku tamu ke Excel.',
                        ],
                        'detail' => [
                            'description' => 'Buku tamu dipakai untuk memantau aktivitas kunjungan dan kebutuhan layanan pengunjung.',
                            'blocks' => [
                                [
                                    'heading' => '1. Monitoring Kunjungan',
                                    'description' => 'Pantau siapa datang, kapan datang, dan untuk keperluan apa.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '1.1 Pencarian Data',
                                            'items' => [
                                                'Cari cepat berdasarkan nama atau keperluan.',
                                                'Gunakan filter tanggal untuk periode tertentu.',
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'heading' => '2. Export Laporan',
                                    'description' => 'Gunakan export untuk pelaporan ke pihak sekolah/manajemen.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '2.1 Standar Arsip',
                                            'items' => [
                                                'Pastikan rentang tanggal sesuai kebutuhan laporan.',
                                                'Simpan file export sebagai arsip periodik.',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
        }

        if ($role === 'petugas') {
            return array_merge($base, [
                'layout' => 'layouts.petugas',
                'pageTitle' => 'Panduan Pengguna',
                'activeRoute' => 'petugas.guides.index',
                'detailRouteName' => 'petugas.guides.show',
                'sections' => [
                    [
                        'slug' => 'daftar-peminjaman',
                        'title' => 'Daftar Peminjaman',
                        'subtitle' => 'Memproses pengajuan peminjam',
                        'points' => [
                            'Cari data berdasarkan nama, judul, atau kode buku.',
                            'Setujui pengajuan yang memenuhi syarat.',
                            'Tolak pengajuan dengan alasan yang jelas.',
                        ],
                        'detail' => [
                            'description' => 'Halaman ini dipakai petugas untuk memproses seluruh pengajuan peminjaman buku.',
                            'blocks' => [
                                [
                                    'heading' => '1. Review Pengajuan',
                                    'description' => 'Lakukan validasi sebelum approve atau reject.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '1.1 Validasi Dasar',
                                            'items' => [
                                                'Pastikan data peminjam sesuai identitas.',
                                                'Periksa kode buku dan status ketersediaan.',
                                                'Utamakan pengajuan dengan status pending.',
                                            ],
                                        ],
                                        [
                                            'heading' => '1.2 Proses Keputusan',
                                            'items' => [
                                                'Klik setujui jika syarat terpenuhi.',
                                                'Klik tolak dan isi alasan bila tidak memenuhi syarat.',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'slug' => 'pengembalian-buku',
                        'title' => 'Pengembalian Buku',
                        'subtitle' => 'Memproses return dan kondisi buku',
                        'points' => [
                            'Cari peminjaman aktif sebelum input pengembalian.',
                            'Pilih kondisi buku: baik, rusak, atau hilang.',
                            'Sistem menghitung denda keterlambatan otomatis.',
                        ],
                        'detail' => [
                            'description' => 'Alur ini memastikan pengembalian tercatat dengan kondisi buku yang benar.',
                            'blocks' => [
                                [
                                    'heading' => '1. Input Pengembalian',
                                    'description' => 'Cari transaksi pinjam yang masih aktif.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '1.1 Penilaian Kondisi',
                                            'items' => [
                                                'Pilih kondisi buku secara akurat (baik/rusak/hilang).',
                                                'Kondisi dan keterlambatan memengaruhi nominal denda.',
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'heading' => '2. Finalisasi',
                                    'description' => 'Pastikan data pengembalian tersimpan sebelum lanjut.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '2.1 Validasi Hasil',
                                            'items' => [
                                                'Cek status loan berubah menjadi dikembalikan.',
                                                'Pastikan status item buku kembali sesuai kondisi.',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'slug' => 'denda',
                        'title' => 'Denda',
                        'subtitle' => 'Pelunasan dan invoice',
                        'points' => [
                            'Lihat daftar denda pending/lunas.',
                            'Tandai pembayaran denda yang sudah diterima.',
                            'Unduh invoice untuk bukti transaksi.',
                        ],
                        'detail' => [
                            'description' => 'Menu denda digunakan untuk tindak lanjut pembayaran atas keterlambatan atau kerusakan buku.',
                            'blocks' => [
                                [
                                    'heading' => '1. Rekap Denda',
                                    'description' => 'Lihat total, pending, dan lunas secara cepat.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '1.1 Pelunasan',
                                            'items' => [
                                                'Tandai lunas setelah pembayaran diterima.',
                                                'Simpan bukti invoice untuk dokumentasi.',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'slug' => 'tips-operasional',
                        'title' => 'Tips Operasional',
                        'subtitle' => 'Agar alur kerja tetap rapi',
                        'points' => [
                            'Pastikan data peminjam sesuai sebelum approve.',
                            'Cek kondisi fisik buku saat pengembalian.',
                            'Gunakan filter status untuk mempercepat proses.',
                        ],
                        'detail' => [
                            'description' => 'Panduan praktis harian untuk menjaga kualitas layanan petugas.',
                            'blocks' => [
                                [
                                    'heading' => '1. Checklist Harian',
                                    'description' => 'Lakukan pemeriksaan singkat sebelum menutup pekerjaan.',
                                    'subBlocks' => [
                                        [
                                            'heading' => '1.1 Poin Wajib',
                                            'items' => [
                                                'Tidak ada pengajuan pending yang terlewat.',
                                                'Pengembalian hari ini sudah tervalidasi semua.',
                                                'Invoice denda penting sudah diunduh.',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
        }

        return array_merge($base, [
            'layout' => 'layouts.peminjam',
            'pageTitle' => 'Panduan Pengguna',
            'activeRoute' => 'peminjam.guides.index',
            'detailRouteName' => 'peminjam.guides.show',
            'sections' => [
                [
                    'slug' => 'cari-dan-pilih-buku',
                    'title' => 'Cari dan Pilih Buku',
                    'subtitle' => 'Mulai dari katalog buku',
                    'icon' => 'fas fa-search',
                    'points' => [
                        'Jelajahi katalog untuk menemukan buku yang Anda butuhkan.',
                        'Gunakan pencarian dan filter agar hasil lebih relevan.',
                        'Periksa detail buku sebelum memasukkan ke keranjang.',
                    ],
                    'detail' => [
                        'description' => 'Bagian ini membantu Anda menemukan buku secara tepat sebelum mengajukan peminjaman.',
                        'blocks' => [
                            [
                                'heading' => '1. Akses Katalog Buku',
                                'description' => 'Halaman katalog menampilkan daftar buku yang bisa dipinjam oleh peminjam.',
                                'subBlocks' => [
                                    [
                                        'heading' => '1.1 Menjelajahi Daftar Buku',
                                        'items' => [
                                            'Lihat daftar buku dari urutan paling relevan atau terbaru.',
                                            'Perhatikan judul, kategori, dan informasi ringkas pada kartu buku.',
                                            'Gunakan scroll halaman untuk melihat koleksi yang lebih banyak.',
                                        ],
                                    ],
                                    [
                                        'heading' => '1.2 Menggunakan Pencarian dan Filter',
                                        'items' => [
                                            'Ketik kata kunci judul buku di kolom pencarian.',
                                            'Gunakan filter kategori jika tersedia agar daftar lebih spesifik.',
                                            'Jika hasil kosong, coba kata kunci yang lebih umum.',
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'heading' => '2. Buka Detail Buku',
                                'description' => 'Sebelum menambahkan buku ke keranjang, pastikan informasi detailnya sesuai.',
                                'subBlocks' => [
                                    [
                                        'heading' => '2.1 Informasi yang Wajib Dicek',
                                        'items' => [
                                            'Cek ketersediaan stok pada buku tersebut.',
                                            'Periksa deskripsi atau sinopsis untuk memastikan isi buku sesuai kebutuhan.',
                                            'Pastikan kategori dan judul benar agar tidak salah pinjam.',
                                        ],
                                    ],
                                    [
                                        'heading' => '2.2 Keputusan Sebelum Menambah Keranjang',
                                        'items' => [
                                            'Jika stok tersedia, lanjutkan ke proses tambah keranjang.',
                                            'Jika stok terbatas, prioritaskan buku yang paling dibutuhkan.',
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'heading' => '3. Tambahkan Buku ke Keranjang',
                                'description' => 'Tahap ini menyiapkan buku untuk diajukan pada menu keranjang peminjaman.',
                                'subBlocks' => [
                                    [
                                        'heading' => '3.1 Langkah Singkat',
                                        'items' => [
                                            'Klik aksi tambah keranjang pada buku yang dipilih.',
                                            'Pastikan item muncul di keranjang setelah ditambahkan.',
                                            'Ulangi proses untuk buku lain jika diperlukan.',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'slug' => 'keranjang-peminjaman',
                    'title' => 'Keranjang Peminjaman',
                    'subtitle' => 'Kelola buku sebelum diajukan',
                    'icon' => 'fas fa-shopping-cart',
                    'points' => [
                        'Atur daftar buku yang akan diajukan.',
                        'Periksa ulang item sebelum proses pengajuan.',
                        'Kirim pengajuan setelah data benar dan lengkap.',
                    ],
                    'detail' => [
                        'description' => 'Keranjang peminjaman adalah tahap final untuk menyiapkan dan mengirim pengajuan buku.',
                        'blocks' => [
                            [
                                'heading' => '1. Review Item Keranjang',
                                'description' => 'Pastikan semua buku yang ada di keranjang memang akan dipinjam.',
                                'subBlocks' => [
                                    [
                                        'heading' => '1.1 Cek Daftar Buku',
                                        'items' => [
                                            'Periksa judul buku satu per satu.',
                                            'Pastikan tidak ada item duplikat yang tidak diperlukan.',
                                            'Hapus item yang batal dipinjam.',
                                        ],
                                    ],
                                    [
                                        'heading' => '1.2 Atur Jumlah Buku',
                                        'items' => [
                                            'Sesuaikan jumlah setiap item dengan kebutuhan Anda.',
                                            'Hindari jumlah berlebihan agar peluang disetujui lebih baik.',
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'heading' => '2. Ajukan Peminjaman',
                                'description' => 'Setelah item valid, kirim pengajuan ke petugas.',
                                'subBlocks' => [
                                    [
                                        'heading' => '2.1 Checklist Sebelum Submit',
                                        'items' => [
                                            'Semua item di keranjang sudah sesuai.',
                                            'Tidak ada judul yang salah pilih.',
                                            'Anda siap menunggu proses verifikasi petugas.',
                                        ],
                                    ],
                                    [
                                        'heading' => '2.2 Setelah Klik Ajukan',
                                        'items' => [
                                            'Sistem akan membuat pengajuan untuk buku yang tersedia.',
                                            'Status awal pengajuan adalah pending.',
                                            'Lanjutkan pengecekan di menu riwayat/status peminjaman.',
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'heading' => '3. Kendala yang Sering Terjadi',
                                'description' => 'Beberapa kondisi bisa membuat pengajuan tidak langsung berhasil.',
                                'subBlocks' => [
                                    [
                                        'heading' => '3.1 Contoh Kendala',
                                        'items' => [
                                            'Stok buku tidak cukup untuk jumlah yang diajukan.',
                                            'Ada item yang sudah tidak tersedia saat submit.',
                                            'Perbaiki isi keranjang lalu ajukan ulang bila diperlukan.',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'slug' => 'status-peminjaman',
                    'title' => 'Status Peminjaman',
                    'subtitle' => 'Memahami progres pengajuan',
                    'icon' => 'fas fa-info-circle',
                    'points' => [
                        'Pantau progres pengajuan melalui status transaksi.',
                        'Pahami arti setiap status agar tidak salah langkah.',
                        'Lakukan tindak lanjut sesuai status terbaru.',
                    ],
                    'detail' => [
                        'description' => 'Status peminjaman menunjukkan tahapan proses pengajuan Anda dari awal sampai selesai.',
                        'blocks' => [
                            [
                                'heading' => '1. Status Utama dan Artinya',
                                'description' => 'Setiap status memiliki makna dan tindakan lanjutan yang berbeda.',
                                'subBlocks' => [
                                    [
                                        'heading' => '1.1 Pending',
                                        'items' => [
                                            'Pengajuan sudah masuk sistem dan menunggu verifikasi petugas.',
                                            'Anda belum bisa mengambil keputusan lain sampai status berubah.',
                                        ],
                                    ],
                                    [
                                        'heading' => '1.2 Disetujui',
                                        'items' => [
                                            'Pengajuan diterima dan buku diproses sebagai pinjaman aktif.',
                                            'Perhatikan tanggal pinjam dan tanggal jatuh tempo pengembalian.',
                                        ],
                                    ],
                                    [
                                        'heading' => '1.3 Ditolak',
                                        'items' => [
                                            'Pengajuan tidak dapat diproses oleh petugas.',
                                            'Baca alasan penolakan jika tersedia lalu perbaiki pengajuan berikutnya.',
                                        ],
                                    ],
                                    [
                                        'heading' => '1.4 Dikembalikan',
                                        'items' => [
                                            'Transaksi telah ditutup karena buku sudah dikembalikan.',
                                            'Jika ada denda, cek status pembayarannya pada menu terkait.',
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'heading' => '2. Cara Menindaklanjuti Status',
                                'description' => 'Gunakan status sebagai panduan tindakan berikutnya.',
                                'subBlocks' => [
                                    [
                                        'heading' => '2.1 Praktik yang Disarankan',
                                        'items' => [
                                            'Jika pending terlalu lama, cek berkala di riwayat peminjaman.',
                                            'Jika disetujui, catat tanggal kembali agar tidak terlambat.',
                                            'Jika ditolak, ajukan ulang dengan pilihan buku yang lebih sesuai.',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'slug' => 'riwayat-peminjaman',
                    'title' => 'Riwayat Peminjaman',
                    'subtitle' => 'Lihat histori transaksi Anda',
                    'icon' => 'fa fa-history',
                    'points' => [
                        'Tinjau seluruh transaksi peminjaman yang pernah diajukan.',
                        'Gunakan riwayat untuk memantau kedisiplinan pengembalian.',
                        'Jadikan riwayat sebagai evaluasi sebelum pengajuan baru.',
                    ],
                    'detail' => [
                        'description' => 'Riwayat peminjaman adalah catatan lengkap pengajuan Anda, termasuk status akhir tiap transaksi.',
                        'blocks' => [
                            [
                                'heading' => '1. Membaca Informasi Riwayat',
                                'description' => 'Pahami elemen data pada setiap baris riwayat agar tidak salah membaca transaksi.',
                                'subBlocks' => [
                                    [
                                        'heading' => '1.1 Kolom Utama yang Perlu Diperhatikan',
                                        'items' => [
                                            'Judul buku dan kode buku untuk memastikan item yang dipinjam.',
                                            'Tanggal pinjam dan tanggal kembali untuk melihat durasi pinjaman.',
                                            'Status transaksi untuk mengetahui progres atau hasil akhir.',
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'heading' => '2. Evaluasi dari Riwayat',
                                'description' => 'Gunakan riwayat sebagai alat evaluasi agar pengajuan berikutnya lebih tertib.',
                                'subBlocks' => [
                                    [
                                        'heading' => '2.1 Pola yang Bisa Dievaluasi',
                                        'items' => [
                                            'Seberapa sering pengajuan Anda disetujui atau ditolak.',
                                            'Kebiasaan pengembalian tepat waktu atau terlambat.',
                                            'Jenis buku yang paling sering dipinjam untuk kebutuhan belajar.',
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'heading' => '3. Jika Menemukan Data yang Tidak Sesuai',
                                'description' => 'Segera tindak lanjuti bila ada informasi transaksi yang dirasa tidak tepat.',
                                'subBlocks' => [
                                    [
                                        'heading' => '3.1 Langkah Tindak Lanjut',
                                        'items' => [
                                            'Catat detail transaksi yang bermasalah (judul, tanggal, status).',
                                            'Hubungi petugas perpustakaan untuk klarifikasi data.',
                                            'Simpan bukti terkait agar proses verifikasi lebih cepat.',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    private function buildDetailData(string $role, string $slug): array
    {
        $data = $this->buildData($role);
        $section = collect($data['sections'])->firstWhere('slug', $slug);

        if (!$section) {
            throw new NotFoundHttpException('Panduan tidak ditemukan.');
        }

        return [
            'layout' => $data['layout'],
            'pageTitle' => 'Detail Panduan',
            'heroTitle' => $data['heroTitle'],
            'heroSubtitle' => $data['heroSubtitle'],
            'lastUpdated' => $data['lastUpdated'],
            'backRoute' => $data['activeRoute'],
            'guideTitle' => 'Panduan Pengguna - ' . $section['title'],
            'guideIcon' => $section['icon'] ,
            'guideDescription' => $section['detail']['description'],
            'guideBlocks' => $section['detail']['blocks'],
        ];
    }
}
