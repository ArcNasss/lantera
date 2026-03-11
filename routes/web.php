<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReturnBookController;
use App\Http\Controllers\GuestBookController;

// Public Routes
Route::get('/', [BookController::class, 'list'])->name('home');
Route::get('list-buku', [BookController::class, 'list'])->name('peminjam.list-buku');

// Guest Book Routes (Public - No Login Required)
Route::get('/buku-tamu', [GuestBookController::class, 'create'])->name('guest-book.create');
Route::post('/buku-tamu', [GuestBookController::class, 'store'])->name('guest-book.store');

// Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
// });

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::patch('/categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    Route::post('/book-items', [BookItemController::class, 'store'])->name('book-items.store');
    Route::put('/book-items/{bookItem}', [BookItemController::class, 'update'])->name('book-items.update');
    Route::delete('/book-items/{bookItem}', [BookItemController::class, 'destroy'])->name('book-items.destroy');

    // Admin Peminjaman Routes (View Only)
    Route::get('/peminjaman', [LoanController::class, 'adminIndex'])->name('admin.peminjaman.index');
    Route::get('/peminjaman/export', [LoanController::class, 'exportPeminjaman'])->name('admin.peminjaman.export');
    Route::get('/peminjaman/riwayat', [ReturnBookController::class, 'adminIndex'])->name('admin.peminjaman.riwayat');
    Route::get('/peminjaman/riwayat/{id}/invoice', [ReturnBookController::class, 'downloadInvoice'])->name('admin.pengembalian.invoice');

    // Admin Denda Routes (View Only)
    Route::get('/denda', [ReturnBookController::class, 'adminDendaIndex'])->name('admin.denda.index');
    Route::get('/denda/export', [ReturnBookController::class, 'exportDenda'])->name('admin.denda.export');

    // Admin Guest Book Routes
    Route::get('/guest-book', [GuestBookController::class, 'adminIndex'])->name('admin.guest-book.index');
    Route::delete('/guest-book/{id}', [GuestBookController::class, 'destroy'])->name('admin.guest-book.destroy');
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/peminjaman', [LoanController::class, 'petugasIndex'])->name('peminjaman.index');
    Route::post('/peminjaman/{id}/approve', [LoanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [LoanController::class, 'reject'])->name('peminjaman.reject');
    Route::get('/peminjaman/riwayat', [ReturnBookController::class, 'index'])->name('peminjaman.riwayat');
    Route::get('/peminjaman/{id}/kartu-pdf', [LoanController::class, 'downloadKartu'])->name('peminjaman.download-kartu');

    Route::get('/pengembalian', [returnBookController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create', [ReturnBookController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian/search', [ReturnBookController::class, 'search'])->name('pengembalian.search');
    Route::post('/pengembalian', [ReturnBookController::class, 'store'])->name('pengembalian.store');
    Route::get('/pengembalian/{id}/invoice', [ReturnBookController::class, 'downloadInvoice'])->name('pengembalian.invoice');

    Route::get('/denda', [ReturnBookController::class, 'dendaIndex'])->name('denda.index');
    Route::post('/denda/{id}/paid', [ReturnBookController::class, 'markAsPaid'])->name('denda.paid');
});

Route::middleware(['auth', 'role:peminjam,admin'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/loans', [LoanController::class, 'index'])->name('peminjam.loan.index');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');

});

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'petugasDashboard'])->name('petugas.dashboard');
});

Route::middleware(['auth', 'role:admin,peminjam,petugas'])->group(function () {

});




Route::get('/test', function() {
    return view('petugas.pdf.invoice');
});
