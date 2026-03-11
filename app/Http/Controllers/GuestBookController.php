<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;
use Illuminate\Http\Request;

class GuestBookController extends Controller
{
    // Public form (tanpa login)
    public function create()
    {
        return view('guest-book.form');
    }

    // Store guest book entry (tanpa login)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keperluan' => 'required|string',
        ]);

        GuestBook::create([
            'nama' => $request->nama,
            'keperluan' => $request->keperluan,
        ]);

        return redirect()->route('guest-book.create')->with('success', 'Terima kasih telah mengisi buku tamu!');
    }

    // Admin list
    public function adminIndex(Request $request)
    {
        $query = GuestBook::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('keperluan', 'like', '%' . $search . '%');
            });
        }

        $guestBooks = $query->latest()->get();
        return view('admin.guest-book.index', compact('guestBooks'));
    }

    // Admin delete
    public function destroy($id)
    {
        $guestBook = GuestBook::findOrFail($id);
        $guestBook->delete();

        return redirect()->route('admin.guest-book.index')->with('success', 'Data buku tamu berhasil dihapus');
    }
}
