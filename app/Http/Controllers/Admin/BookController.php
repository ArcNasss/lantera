<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display all books
     */
    public function index()
    {
        $books = Book::with('category')->paginate(15);
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store book
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'kode_buku' => 'required|string|unique:books',
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:1',
        ]);

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Show edit form
     */
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update book
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'kode_buku' => 'required|string|unique:books,kode_buku,' . $book->id,
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:1',
        ]);

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui');
    }

    /**
     * Delete book
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus');
    }
}
