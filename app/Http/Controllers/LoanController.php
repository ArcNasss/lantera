<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Cart;
use App\Models\BookItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanController extends Controller
{
    // Method untuk Petugas
    public function petugasIndex()
    {
        $loans = Loan::with(['user', 'bookItem.book.category', 'petugas'])
            ->whereIn('status', ['pending', 'disetujui', 'ditolak','dikembalikan'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->get();

        return view('petugas.peminjaman.index', compact('loans'));
    }

    // Method untuk Admin (View Only)
    public function adminIndex()
    {
        $loans = Loan::with(['user', 'bookItem.book.category', 'petugas'])
            ->latest()
            ->get();

        return view('admin.peminjaman.index', compact('loans'));
    }

    // Method untuk Peminjam
    public function index()
    {
        $user = Auth::user();
        $loans = Loan::with(['bookItem.book.category', 'petugas'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peminjam.loans.index', compact('loans'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('book.bookItems')->get();

        if($carts->isEmpty()){
            return redirect()->route('cart.index')->with('error', 'Keranjang peminjaman anda kosong');
        }

        try {
            DB::beginTransaction();

            $createdLoans = 0;
            $errors = [];

            foreach($carts as $cart){
                $book = $cart->book;
                $requestedQuantity  = $cart->quantity;

                $availableItems = $book->bookItems()->where('status', 'available')->limit($requestedQuantity)->get();

                if($availableItems->count() < $requestedQuantity){
                    $errors[] = "Buku '{$book->judul}' tidak memiliki stok yang cukup.";
                    continue;
                }

                foreach($availableItems as $item){
                    Loan::create([
                        'user_id' => $user->id,
                        'book_item_id' => $item->id,
                        'tanggal_pinjam' => now(),
                        'tanggal_kembali' => now()->addDays(7),
                        'status' => 'pending',
                    ]);

                    $item->update(['status' => 'borrowed']);
                    $createdLoans++;
                }
            }

            if($createdLoans > 0){
                Cart::where('user_id', $user->id)->delete();
                DB::commit();
                return redirect()->route('cart.index')->with('success', "Berhasil mengajukan peminjaman {$createdLoans} buku. Silakan tunggu persetujuan petugas.");
            } else {
                DB::rollback();
                return redirect()->route('cart.index')->with('error', 'Gagal mengajukan peminjaman. ' . implode(' ', $errors));
            }

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('cart.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function approve($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pengajuan dengan status pending yang dapat disetujui');
        }

        $loan->update([
            'status' => 'disetujui',
            'petugas_id' => Auth::id(),
        ]);

        return redirect()->back()->with([
            'success' => 'Pengajuan peminjaman berhasil disetujui',
            'loan_id' => $loan->id
        ]);
    }

    public function downloadKartu($id)
    {
        $loan = Loan::with(['user', 'bookItem.book.category', 'petugas'])
            ->findOrFail($id);

        // Ambil semua peminjaman aktif user ini (untuk ditampilkan di kartu)
        $activeLoans = Loan::with(['bookItem.book.category'])
            ->where('user_id', $loan->user_id)
            ->whereIn('status', ['disetujui'])
            ->latest()
            ->get();

        $data = [
            'loan' => $loan,
            'activeLoans' => $activeLoans,
            'user' => $loan->user,
            'petugas' => $loan->petugas,
        ];

        $pdf = Pdf::loadView('petugas.pdf.kartu-peminjaman', $data);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Kartu-Peminjaman-' . $loan->user->name . '-' . now()->format('Ymd') . '.pdf');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string|max:255',
        ]);

        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pengajuan dengan status pending yang dapat ditolak');
        }

        $loan->update([
            'status' => 'ditolak',
            'petugas_id' => Auth::id(),
            'alasan_ditolak' => $request->alasan_ditolak,
        ]);

        // Update status book item kembali ke available
        $loan->bookItem->update(['status' => 'available']);

        return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil ditolak');
    }

    // Export Peminjaman to Excel
    public function exportPeminjaman(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status', 'all');

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PeminjamanExport($startDate, $endDate, $status),
            'Laporan_Peminjaman_' . date('Y-m-d_His') . '.xlsx'
        );
    }
}
