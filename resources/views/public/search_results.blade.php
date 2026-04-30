@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 sm:px-6 py-12 md:py-20">
    <div class="mb-10 md:mb-12 border-l-4 border-pink-600 pl-4 md:pl-6">
        <p class="text-cyan-500 font-mono text-xs md:text-sm uppercase tracking-widest mb-2">// Search_Results</p>
        <h1 class="text-2xl md:text-4xl font-bold italic truncate">Query: "{{ $keyword }}"</h1>
    </div>

    @if($images->isEmpty())
        <div class="text-center py-16 md:py-20 bg-gray-900/30 rounded-3xl border border-dashed border-white/10 mx-2">
            <i class="bi bi-exclamation-triangle text-4xl md:text-5xl text-pink-500 mb-4 inline-block"></i>
            <p class="text-base md:text-xl text-gray-400">Data tidak ditemukan dalam database.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($images as $image)
            <a href="{{ asset('storage/' . $image->file_path) }}" class="glightbox block relative group overflow-hidden rounded-xl border border-white/5">
                <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->title }}" class="w-full h-56 md:h-64 object-cover opacity-80 group-hover:opacity-100 transition duration-500">
                <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/90 to-transparent transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    <p class="text-xs md:text-sm font-bold text-cyan-400 truncate">{{ $image->title }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-10 md:mt-12 flex justify-center">
            {{ $images->links() }}
        </div>
    @endif
</div>
@endsection