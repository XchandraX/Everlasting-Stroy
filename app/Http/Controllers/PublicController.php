<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Menampilkan Halaman Utama (Misal: Menampilkan Kategori)
    public function index()
    {
        // Menampilkan 6 kategori terbaru beserta jumlah fotonya
        $categories = Kategori::withCount('images')->latest()->take(6)->get();
        // Menampilkan beberapa foto terbaru untuk highlight
        $latestImages = Image::latest()->take(8)->get();

        return view('public.home', compact('categories', 'latestImages'));
    }

    // Menampilkan semua kategori
    public function categories()
    {
        $categories = Kategori::withCount('images')->latest()->paginate(12);

        return view('public.categories', compact('categories'));
    }

    // Menampilkan foto-foto di dalam satu kategori
    public function showCategory(Request $request, $id)
    {
        $category = Kategori::findOrFail($id);
        $filter = $request->get('filter', 'image'); // default image

        $images = Image::where('kategori_id', $id);
        if ($filter === 'image') {
            $images->where('media_type', 'image');
        } elseif ($filter === 'video') {
            $images->where('media_type', 'video');
        }
        $images = $images->latest()->paginate(12)->withQueryString();

        return view('public.category_show', compact('category', 'images', 'filter'));
    }

    // Fitur Pencarian Foto
    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $images = Image::where('title', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->latest()
            ->paginate(15);

        return view('public.search_results', compact('images', 'keyword'));
    }
}
