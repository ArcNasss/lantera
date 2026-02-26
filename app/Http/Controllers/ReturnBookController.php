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
    public function index()
    {
        $returns = ReturnBook::with(['loan.user', 'loan.bookItem.book.category', 'loan.petugas'])
            ->latest()
            ->get();

        return view('petugas.peminjaman.riwayat', compact('returns'));
    }

    // Riwayat pengembalian untuk Admin (View Only)
    public function adminIndex()
    {
        $returns = ReturnBook::with(['loan.user', 'loan.bookItem.book.category', 'loan.petugas'])
            ->latest()
            ->get();

        return view('admin.peminjaman.riwayat', compact('returns'));
    }

    public function create()
    {
        return view('petugas.pengembalian.create');
    }

    public function search(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|integer',
        ]);

        $loan = Loan::with(['user', 'bookItem.book.category'])
            ->where('id', $request->loan_id)
            ->where('status', 'disetujui')
            ->first();

        if (!$loan) {
            return redirect()->back()->with('error', 'ID Peminjaman tidak ditemukan atau sudah dikembalikan');
        }

        return view('petugas.pengembalian.create', compact('loan'));
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
            $tanggalKembali = \Carbon\Carbon::parse($loan->tanggal_kembali);
            $sekarang = \Carbon\Carbon::now();

            if ($sekarang->greaterThan($tanggalKembali)) {
                $daysLate = abs($sekarang->diffInDays($tanggalKembali, false));
                $dendaKeterlambatan = $daysLate * 2000; // Rp 2.000 per hari
            }

            // Denda kondisi buku
            $dendaKondisi = 0;
            if ($request->kondisi === 'rusak' || $request->kondisi === 'hilang') {
                $dendaKondisi = 100000; // Rp 100.000 untuk rusak/hilang
            }

            $totalDenda = abs($dendaKeterlambatan + $dendaKondisi);

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
        $tanggalKembali = \Carbon\Carbon::parse($return->loan->tanggal_kembali);
        $tanggalPengembalian = \Carbon\Carbon::parse($return->tanggal_pengembalian);
        $daysLate = 0;
        $dendaKeterlambatan = 0;

        if ($tanggalPengembalian->greaterThan($tanggalKembali)) {
            $daysLate = abs($tanggalPengembalian->diffInDays($tanggalKembali, false));
            $dendaKeterlambatan = $daysLate * 2000;
        }

        // Denda kondisi
        $dendaKondisi = 0;
        $jenisKondisi = '-';

        if ($return->kondisi === 'rusak') {
            $dendaKondisi = 100000;
            $jenisKondisi = 'Buku Rusak';
        } elseif ($return->kondisi === 'hilang') {
            $dendaKondisi = 100000;
            $jenisKondisi = 'Buku Hilang';
        } elseif ($return->kondisi === 'baik' && $daysLate > 0) {
            $jenisKondisi = 'Keterlambatan';
        }

        $data = [
            'return' => $return,
            'user' => $return->loan->user,
            'invoiceNumber' => str_pad($return->id, 5, '0', STR_PAD_LEFT),
            'items' => [
                [
                    'judul' => $return->loan->bookItem->book->judul,
                    'jenis' => $jenisKondisi,
                    'hari' => $daysLate,
                    'nominal' => $return->denda,
                ]
            ],
            'dendaKeterlambatan' => $dendaKeterlambatan,
            'dendaKondisi' => $dendaKondisi,
            'daysLate' => $daysLate,
            'total' => $return->denda,
        ];

        $pdf = Pdf::loadView('petugas.pdf.invoice', $data);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Invoice-Denda-' . $return->loan->user->name . '-' . now()->format('Ymd') . '.pdf');
    }

    public function dendaIndex(Request $request)
    {
        $query = ReturnBook::with(['loan.user', 'loan.bookItem.book.category', 'loan.petugas'])
            ->where('denda', '>', 0);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $denda = $query->latest()->get();

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

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $denda = $query->latest()->get();

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

