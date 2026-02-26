<?php

namespace App\Http\Controllers;

use App\Models\BookItem;
use Illuminate\Http\Request;

class BookItemController extends Controller
{
    /**
     * Store a new book item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'kode_buku' => 'required|string|unique:book_items,kode_buku|max:50',
        ]);

        $validated['status'] = 'available';

        BookItem::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Item buku berhasil ditambahkan'
        ]);
    }

    /**
     * Update book item
     */
    public function update(Request $request, BookItem $bookItem)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|string|max:50|unique:book_items,kode_buku,' . $bookItem->id,
            'status' => 'required|in:available,borrowed,damaged,lost',
        ]);

        $bookItem->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Item buku berhasil diupdate'
        ]);
    }

    /**
     * Delete book item
     */
    public function destroy(BookItem $bookItem)
    {
        // Check if item is currently borrowed
        if ($bookItem->status === 'borrowed') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus item yang sedang dipinjam'
            ], 400);
        }

        $bookItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item buku berhasil dihapus'
        ]);
    }
}
