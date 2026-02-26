<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();
        if($request->has('search') && $request->search != '') {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        $categories = $query->latest()->paginate(6);

        return view('admin.categories.index', compact('categories'));

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori',
        ]);

        Category::create([
            'nama_kategori' => $validated['nama_kategori'],
            'is_active' => true,
        ]);

        return redirect()->route('categories.index')->with('success', true);
    }

    public function toggle(Category $category)
    {
        $category->update([
            'is_active' => !$category->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $category->is_active
        ]);
    }

    public function show(Category $category)
    {
        $books = Book::where('category_id', $category->id)->get();
        return view('admin.categories.show', compact('category', 'books'));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', true);
    }

}
