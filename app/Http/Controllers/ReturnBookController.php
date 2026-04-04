<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\ReturnBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReturnBookController extends Controller
{
    // Riwayat pengembalian untuk Petugas
    public function index(Request $request)
    {
        $query = ReturnBook::with(['loan.user', 'loan.bookItem.book.category', 'loan.petugas']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('loan.user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('nomor_identitas', 'like', '%' . $search . '%');
                })
                ->orWhereHas('loan.bookItem.book', function($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%');
                })
                ->orWhereHas('loan.bookItem', function($q) use ($search) {
                    $q->where('kode_buku', 'like', '%' . $search . '%');
                });
            });
        }

        // Kondisi filter
        if ($request->has('kondisi') && $request->kondisi) {
            $query->where('kondisi', $request->kondisi);
        }

        $returns = $query->latest()->paginate(10)->withQueryString();

        $totalPengembalian = ReturnBook::count();
        $totalBermasalah   = ReturnBook::whereIn('kondisi', ['rusak', 'hilang'])->count();
        $totalDendaSum     = ReturnBook::where('denda', '>', 0)->sum('denda');

        return view('petugas.peminjaman.riwayat', compact('returns', 'totalPengembalian', 'totalBermasalah', 'totalDendaSum'));
    }

    // Riwayat pengembalian untuk Admin (View Only)
    public function adminIndex(Request $request)
    {
        $query = ReturnBook::with(['loan.user', 'loan.bookItem.book.category', 'loan.petugas']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('loan.user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('nomor_identitas', 'like', '%' . $search . '%');
                })
                ->orWhereHas('loan.bookItem.book', function($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%');
                })
                ->orWhereHas('loan.bookItem', function($q) use ($search) {
                    $q->where('kode_buku', 'like', '%' . $search . '%');
                });
            });
        }

        // Kondisi filter
        if ($request->has('kondisi') && $request->kondisi) {
            $query->where('kondisi', $request->kondisi);
        }

        $returns = $query->latest()->paginate(10)->withQueryString();

        $totalPengembalian = ReturnBook::count();
        $totalBermasalah   = ReturnBook::whereIn('kondisi', ['rusak', 'hilang'])->count();
        $totalDendaSum     = ReturnBook::where('denda', '>', 0)->sum('denda');

        return view('admin.peminjaman.riwayat', compact('returns', 'totalPengembalian', 'totalBermasalah', 'totalDendaSum'));
    }

    public function create()
    {
        return view('petugas.pengembalian.create');
    }

    public function search(Request $request)
    {
        // Direct selection from multi-result list
        if ($request->filled('loan_id')) {
            $loan = Loan::with(['user', 'bookItem.book.category'])
                ->where('status', 'disetujui')
                ->findOrFail($request->loan_id);
            return view('petugas.pengembalian.create', compact('loan'));
        }

        $request->validate([
            'search' => 'required|string|min:2',
        ]);

        $search = $request->search;
        $loans = Loan::with(['user', 'bookItem.book.category'])
            ->where('status', 'disetujui')
            ->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('nomor_identitas', 'like', '%' . $search . '%');
                })
                ->orWhereHas('bookItem.book', function ($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%');
                })
                ->orWhereHas('bookItem', function ($q) use ($search) {
                    $q->where('kode_buku', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();

        if ($loans->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada peminjaman aktif yang sesuai dengan pencarian');
        }

        if ($loans->count() === 1) {
            $loan = $loans->first();
            return view('petugas.pengembalian.create', compact('loan'));
        }

        return view('petugas.pengembalian.create', compact('loans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'kondisi' => 'required|in:baik,rusak,hilang',
            'denda' => 'nullable|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $loan = Loan::findOrFail($request->loan_id);

            // Calculate denda otomatis
            $dendaKeterlambatan = 0;
            $tanggalKembali = \Carbon\Carbon::parse($loan->tanggal_kembali)->startOfDay();
            $sekarang = \Carbon\Carbon::now()->startOfDay();

            if ($sekarang->greaterThan($tanggalKembali)) {
                $daysLate = (int) $tanggalKembali->diffInDays($sekarang);
                $dendaKeterlambatan = $daysLate * 2000;
            }

            // Denda kondisi buku
            $dendaKondisi = 0;
            if ($request->kondisi === 'rusak' || $request->kondisi === 'hilang') {
                $dendaKondisi = 100000;
            }

            $totalDenda = $dendaKeterlambatan + $dendaKondisi;

            // Create return book record
            ReturnBook::create([
                'loan_id' => $loan->id,
                'tanggal_pengembalian' => now(),
                'kondisi' => $request->kondisi,
                'denda' => $totalDenda,
            ]);

            // Update loan status and tanggal_kembali
            $loan->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now(),
            ]);

            // Update book item status
            // Jika hilang, status tetap borrowed
            // Jika baik/rusak, status kembali available
            if ($request->kondisi !== 'hilang') {
                $loan->bookItem->update(['status' => 'available']);
            }

            DB::commit();

            $message = 'Buku berhasil dikembalikan';
            if ($totalDenda > 0) {
                $message .= ' dengan denda Rp ' . number_format($totalDenda, 0, ',', '.');
            }

            return redirect()->route('peminjaman.riwayat')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function downloadInvoice($id)
    {
        $return = ReturnBook::with(['loan.user', 'loan.bookItem.book.category', 'loan.petugas'])
            ->findOrFail($id);

        // Hitung detail denda
        $tanggalKembali = \Carbon\Carbon::parse($return->loan->tanggal_kembali)->startOfDay();
        $tanggalPengembalian = \Carbon\Carbon::parse($return->tanggal_pengembalian)->startOfDay();
        $daysLate = 0;
        $dendaKeterlambatan = 0;

        if ($tanggalPengembalian->greaterThan($tanggalKembali)) {
            $daysLate = (int) $tanggalKembali->diffInDays($tanggalPengembalian);
            $dendaKeterlambatan = $daysLate * 2000;
        }

        // Denda kondisi
        $dendaKondisi = 0;
        $kondisiLabel = 'Baik';

        if ($return->kondisi === 'rusak') {
            $dendaKondisi = 100000;
            $kondisiLabel = 'Rusak';
        } elseif ($return->kondisi === 'hilang') {
            $dendaKondisi = 100000;
            $kondisiLabel = 'Hilang';
        }

        $items = [];

        if ($dendaKeterlambatan > 0) {
            $items[] = [
                'label' => 'Denda keterlambatan',
                'description' => $daysLate . ' hari x Rp 2.000',
                'nominal' => $dendaKeterlambatan,
            ];
        }

        if ($dendaKondisi > 0) {
            $items[] = [
                'label' => $return->kondisi === 'hilang' ? 'Penggantian buku hilang' : 'Denda kondisi buku',
                'description' => 'Kondisi buku: ' . $kondisiLabel,
                'nominal' => $dendaKondisi,
            ];
        }

        if (empty($items)) {
            $items[] = [
                'label' => 'Administrasi pengembalian',
                'description' => 'Tidak ada denda tambahan',
                'nominal' => $return->denda,
            ];
        }

        $data = [
            'return' => $return,
            'user' => $return->loan->user,
            'invoiceNumber' => str_pad($return->id, 5, '0', STR_PAD_LEFT),
            'items' => $items,
            'dendaKeterlambatan' => $dendaKeterlambatan,
            'dendaKondisi' => $dendaKondisi,
            'daysLate' => $daysLate,
            'kondisiLabel' => $kondisiLabel,
            'total' => $return->denda,
        ];

        $pdf = Pdf::loadView('petugas.pdf.invoice', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('Nota-Pembayaran-' . $return->loan->user->name . '-' . now()->format('Ymd') . '.pdf');
    }

    public function dendaIndex(Request $request)
    {
        $query = ReturnBook::with(['loan.user', 'loan.bookItem.book.category', 'loan.petugas'])
            ->where('denda', '>', 0);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('loan.user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('nomor_identitas', 'like', '%' . $search . '%');
                })
                ->orWhereHas('loan.bookItem.book', function($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%');
                })
                ->orWhereHas('loan.bookItem', function($q) use ($search) {
                    $q->where('kode_buku', 'like', '%' . $search . '%');
                });
            });
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $denda = $query->latest()->paginate(10)->withQueryString();

        // Hitung statistik
        $totalDenda = ReturnBook::where('denda', '>', 0)->sum('denda');
        $totalPending = ReturnBook::where('denda', '>', 0)->where('status', 'pending')->sum('denda');
        $totalPaid = ReturnBook::where('denda', '>', 0)->where('status', 'paid')->sum('denda');

        return view('petugas.denda.index', compact('denda', 'totalDenda', 'totalPending', 'totalPaid'));
    }

    public function markAsPaid($id)
    {
        $return = ReturnBook::findOrFail($id);

        if ($return->status === 'paid') {
            return redirect()->back()->with('error', 'Denda sudah lunas');
        }

        $return->update(['status' => 'paid']);

        return redirect()->back()->with('success', 'Denda berhasil ditandai sebagai lunas');
    }

    // Admin Denda View (Read Only)
    public function adminDendaIndex(Request $request)
    {
        $query = ReturnBook::with(['loan.user', 'loan.bookItem.book.category', 'loan.petugas'])
            ->where('denda', '>', 0);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('loan.user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('nomor_identitas', 'like', '%' . $search . '%');
                })
                ->orWhereHas('loan.bookItem.book', function($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%');
                })
                ->orWhereHas('loan.bookItem', function($q) use ($search) {
                    $q->where('kode_buku', 'like', '%' . $search . '%');
                });
            });
        }

        // Status filter
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $denda = $query->latest()->paginate(10)->withQueryString();

        $totalDenda = ReturnBook::where('denda', '>', 0)->sum('denda');
        $totalPending = ReturnBook::where('denda', '>', 0)->where('status', 'pending')->sum('denda');
        $totalPaid = ReturnBook::where('denda', '>', 0)->where('status', 'paid')->sum('denda');

        return view('admin.denda.index', compact('denda', 'totalDenda', 'totalPending', 'totalPaid'));
    }

    // Export Denda to Excel
    public function exportDenda(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status', 'all');

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\DendaExport($startDate, $endDate, $status),
            'Laporan_Denda_' . date('Y-m-d_His') . '.xlsx'
        );
    }
}

