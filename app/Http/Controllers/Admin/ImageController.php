<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Kategori;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $categories = Kategori::all();
        $query = Image::with('kategori');
        if ($request->has('category') && $request->category != '') {
            $query->where('kategori_id', $request->category);
        }
        $images = $query->latest()->paginate(5)->appends($request->query());

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
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,mkv,webm|max:20480',
        ]);

        $data = [
            'title' => $request->title,
            'kategori_id' => $request->kategori_id,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($image->file_path) {
                $publicId = $this->extractPublicIdFromUrl($image->file_path);
                if ($publicId) {
                    try {
                        cloudinary()->uploadApi()->destroy($publicId);
                    } catch (\Exception $e) {
                    }
                }
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $type = in_array($ext, ['mp4', 'avi', 'mov', 'mkv', 'webm']) ? 'video' : 'image';

            $result = cloudinary()->uploadApi()->upload($file->getRealPath(), [
                'folder' => ($type === 'video' ? 'videos' : 'images'),
                'resource_type' => $type,
            ]);

            $image->file_path = $result['secure_url'];
            $image->media_type = $type;
        }

        $image->title = $request->title;
        $image->kategori_id = $request->kategori_id;
        $image->description = $request->description;
        $image->save();

        return redirect()->route('admin.images.index')->with('success', 'Node Data Updated!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,mkv,webm|max:20480',
        ]);

        $successCount = 0;
        $processedHashes = [];

        // Pastikan ada loop foreach di sini agar $file terdefinisi
        foreach ($request->file('files') as $file) {
            // Cek duplikasi file menggunakan MD5 hash
            $hash = md5_file($file->getRealPath());
            if (in_array($hash, $processedHashes)) {
                continue;
            }
            $processedHashes[] = $hash;

            try {
                $ext = $file->getClientOriginalExtension();
                $type = in_array($ext, ['mp4', 'avi', 'mov', 'mkv', 'webm']) ? 'video' : 'image';

                // Menggunakan uploadApi() yang sudah berhasil di tes
                $result = cloudinary()->uploadApi()->upload($file->getRealPath(), [
                    'folder' => ($type === 'video' ? 'videos' : 'images'),
                    'resource_type' => $type,
                ]);

                Image::create([
                    'title' => $request->title,
                    'kategori_id' => $request->kategori_id,
                    'description' => $request->description,
                    'file_path' => $result['secure_url'], // Mengambil URL dari array hasil
                    'media_type' => $type,
                ]);

                $successCount++; // Naikkan angka sukses
            } catch (\Exception $e) {
                \Log::error('Cloudinary Error: '.$e->getMessage());
                // Jika ingin fallback ke lokal saat Cloudinary gagal:
                // $path = $file->store($type === 'video' ? 'videos' : 'images', 'public');
            }
        }

        return redirect()->route('admin.images.index')
            ->with('success', $successCount.' Data Cluster Berhasil Ditambahkan!');
    }

    public function destroy(Image $image)
    {
        if ($image->file_path) {
            $publicId = $this->extractPublicIdFromUrl($image->file_path);
            if ($publicId) {
                Cloudinary::destroy($publicId);
            }
        }
        $image->delete();

        return back()->with('success', 'Node Data Telah Dihapus!');
    }

    // Helper untuk mengambil public_id dari URL Cloudinary
    private function extractPublicIdFromUrl($url)
    {
        // Contoh URL: https://res.cloudinary.com/.../upload/v1234567890/folder/filename.jpg
        $pattern = '/\/upload\/(?:v\d+\/)?(.+?)(?:\.[a-z]+)?$/';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
