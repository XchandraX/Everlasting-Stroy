@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8 md:py-12">
    <div class="text-center mb-12 md:mb-16">
        <h1 class="text-3xl md:text-4xl font-bold mb-3 md:mb-4">Jelajahi Kategori</h1>
        <p class="text-gray-400 text-sm md:text-base">Pilih tema kenangan yang ingin kamu lihat kembali.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
        @foreach($categories as $cat)
        <a href="{{ route('categories.show', $cat->id) }}" class="group block">
            <div class="relative h-56 md:h-64 w-full overflow-hidden rounded-2xl bg-gray-800/50 border border-white/5 mb-4">
                @if($cat->cover_image)
                    <img src="{{ asset('storage/' . $cat->cover_image) }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                @endif
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition"></div>
            </div>
            <h3 class="text-lg md:text-xl font-bold text-white group-hover:text-cyan-400 transition">{{ $cat->nama_kategori }}</h3>
            <p class="text-gray-500 text-xs md:text-sm mt-1">{{ $cat->images_count }} Koleksi Foto</p>
        </a>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $categories->links() }}
    </div>
</div>
@endsection