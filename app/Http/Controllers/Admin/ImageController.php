<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk ditampilkan di tombol filter
        $categories = Kategori::all();

        // 2. Mulai query gambar
        $query = Image::with('kategori');

        // 3. Cek apakah ada filter 'category' di URL
        if ($request->has('category') && $request->category != '') {
            $query->where('kategori_id', $request->category);
        }

        // 4. Urutkan yang terbaru dan gunakan pagination
        // appends() memastikan filter kategori tidak hilang saat pindah halaman (pagination)
        $images = $query->latest()->paginate(1)->appends($request->query());

        return view('admin.images.index', compact('images', 'categories'));
    }

    public function create()
    {
        $categories = Kategori::all();

        return view('admin.images.create', compact('categories'));
    }

    public function edit(Image $image)
    {
        $categories = Kategori::all();

        return view('admin.images.edit', compact('image', 'categories'));
    }

    public function update(Request $request, Image $image)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // nullable karena foto tidak wajib ganti
        ]);

        $data = [
            'title' => $request->title,
            'kategori_id' => $request->kategori_id,
            'description' => $request->description,
        ];

        // Jika ada file gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Hapus foto lama
            if ($image->file_path) {
                \Storage::disk('public')->delete($image->file_path);
            }
            // Simpan foto baru
            $data['file_path'] = $request->file('image')->store('images', 'public');
        }

        $image->update($data);

        return redirect()->route('admin.images.index')->with('success', 'Node Data Updated Successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $path = $request->file('image')->store('images', 'public');

        Image::create([
            'title' => $request->title,
            'kategori_id' => $request->kategori_id,
            'description' => $request->description,
            'file_path' => $path,
        ]);

        return redirect()->route('admin.images.index')->with('success', 'Data Cluster Berhasil Diperbarui!');
    }

    public function destroy(Image $image)
    {
        // Hapus file fisik dari storage agar tidak memenuhi server
        if ($image->file_path) {
            Storage::disk('public')->delete($image->file_path);
        }

        $image->delete();

        return back()->with('success', 'Node Data Telah Dihapus!');
    }
}
