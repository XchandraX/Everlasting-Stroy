<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Kategori::withCount('images')->latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi agar tidak kosong
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'cover_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Simpan data
        $kategori = new Kategori;
        $kategori->nama_kategori = $request->nama_kategori; // Pastikan baris ini ada!

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('categories', 'public');
            $kategori->cover_image = $path;
        }

        $kategori->save();

        return redirect()->route('admin.categories.index')->with('success', 'Node created!');
    }

    public function edit(Kategori $category)
    {
        // Variabel dikirim dengan nama $category agar sesuai dengan route model binding
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Kategori $category)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $category->nama_kategori = $request->nama_kategori;

        if ($request->hasFile('cover_image')) {
            // Hapus foto cover lama jika ada file baru
            if ($category->cover_image) {
                Storage::disk('public')->delete($category->cover_image);
            }

            $path = $request->file('cover_image')->store('categories', 'public');
            $category->cover_image = $path;
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Node Data Reconfigured!');
    }

    // (Opsional: Tambahkan method edit() dan update() sesuai kebutuhan)

    public function destroy(Kategori $category)
    {
        // Hapus gambar cover jika ada
        if ($category->cover_image) {
            Storage::disk('public')->delete($category->cover_image);
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus!');
    }
}
