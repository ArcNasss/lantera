<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use App\Models\ReturnBook;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard Admin
        $totalBooks = Book::count();
        $totalLoans = Loan::whereIn('status', ['pending', 'disetujui'])->count();
        $totalReturns = Loan::where('status', 'dikembalikan')->count();
        $totalMembers = User::where('role', 'peminjam')->count();

        // Data untuk Chart - Statistik peminjaman per bulan (12 bulan terakhir)
        $chartData = [];
        $chartLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartLabels[] = $month->format('M Y');
            $chartData[] = Loan::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Aktivitas Terbaru - 5 aktivitas terakhir (loans + returns)
        $recentLoans = Loan::with(['user', 'bookItem.book'])
            ->whereIn('status', ['pending', 'disetujui', 'dikembalikan'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($loan) {
                return [
                    'user_name' => $loan->user->name,
                    'book_title' => $loan->bookItem->book->judul,
                    'type' => $loan->status === 'dikembalikan' ? 'Pengembalian' : 'Peminjaman',
                    'status' => $loan->status,
                    'date' => $loan->updated_at->format('d/m/Y'),
                ];
            });

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalLoans',
            'totalReturns',
            'totalMembers',
            'chartLabels',
            'chartData',
            'recentLoans'
        ));
    }

    public function petugasDashboard()
    {
        // Dashboard Petugas
        $totalPending = Loan::where('status', 'pending')->count();
        $totalApproved = Loan::whereIn('status', ['disetujui', 'dikembalikan'])->count();
        $totalRejected = Loan::where('status', 'ditolak')->count();
        $totalDamaged = ReturnBook::whereIn('kondisi', ['rusak', 'hilang'])->count();        $pendingCount = $totalPending; // Untuk info banner
        // Data untuk Chart - Statistik peminjaman per bulan (12 bulan terakhir)
        $chartData = [];
        $chartLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartLabels[] = $month->format('M Y');
            $chartData[] = Loan::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Aktivitas Terbaru - 5 aktivitas terakhir
        $recentLoans = Loan::with(['user', 'bookItem.book'])
            ->whereIn('status', ['pending', 'disetujui', 'dikembalikan'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($loan) {
                return [
                    'user_name' => $loan->user->name,
                    'book_title' => $loan->bookItem->book->judul,
                    'type' => $loan->status === 'dikembalikan' ? 'Pengembalian' : 'Peminjaman',
                    'status' => $loan->status,
                    'date' => $loan->updated_at->format('d/m/Y'),
                ];
            });

        return view('petugas.dashboard', compact(
            'totalPending',
            'totalApproved',
            'totalRejected',
            'totalDamaged',            'pendingCount',            'chartLabels',
            'chartData',
            'recentLoans'
        ));
    }
}
