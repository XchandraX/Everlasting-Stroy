<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

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
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kategori = new Kategori;
        $kategori->nama_kategori = $request->nama_kategori;

        if ($request->hasFile('cover_image')) {
            try {
                $file = $request->file('cover_image');
                // Menggunakan uploadApi() yang berhasil di Tinker
                $uploadResult = cloudinary()->uploadApi()->upload($file->getRealPath(), [
                    'folder' => 'category_covers',
                ]);
                $kategori->cover_image = $uploadResult['secure_url'];
            } catch (\Exception $e) {
                \Log::error('Cloudinary Error: '.$e->getMessage());
                $kategori->cover_image = $request->file('cover_image')->store('categories', 'public');
            }
        }

        $kategori->save();
        return redirect()->route('admin.categories.index')->with('success', 'Node created!');
    }

    public function update(Request $request, Kategori $category)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $category->nama_kategori = $request->nama_kategori;

        if ($request->hasFile('cover_image')) {
            // Hapus cover lama
            if ($category->cover_image) {
                $publicId = $this->extractPublicIdFromUrl($category->cover_image);
                if ($publicId) {
                    try {
                        cloudinary()->uploadApi()->destroy($publicId);
                    } catch (\Exception $e) {}
                }
            }

            // Upload cover baru
            $uploadResult = cloudinary()->uploadApi()->upload($request->file('cover_image')->getRealPath(), [
                'folder' => 'category_covers',
            ]);
            $category->cover_image = $uploadResult['secure_url'];
        }

        $category->save();
        return redirect()->route('admin.categories.index')->with('success', 'Node Data Reconfigured!');
    }

    public function edit(Kategori $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function destroy(Kategori $category)
    {
        // Hapus gambar cover dari Cloudinary jika ada
        if ($category->cover_image) {
            $publicId = $this->extractPublicIdFromUrl($category->cover_image);
            if ($publicId) {
                Cloudinary::destroy($publicId);
            }
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus!');
    }

    /**
     * Helper: Extract public_id dari URL Cloudinary
     * Contoh URL: https://res.cloudinary.com/.../upload/v1234567/category_covers/filename.jpg
     * Hasil: category_covers/filename
     */
    private function extractPublicIdFromUrl($url)
    {
        // Hapus bagian sebelum '/upload/'
        if (preg_match('/\/upload\/(?:v\d+\/)?(.+?)(?:\.[a-z]+)?$/', $url, $matches)) {
            // Hapus ekstensi file di akhir (misal .jpg, .png)
            return preg_replace('/\.[a-z]+$/', '', $matches[1]);
        }

        return null;
    }
}
