@extends('layouts.main')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center text-center px-4 mt-8 md:mt-0">
    <div class="fade-up w-full max-w-4xl">
        <h1 class="text-5xl sm:text-6xl md:text-8xl font-black mb-6 tracking-tighter leading-tight">
            <span class="text-cyan-400">Everlasting</span><br class="md:hidden" />
            <span class="text-pink-600">Story</span>
        </h1>
        <p class="text-gray-400 text-base md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed px-2">
            Menyimpan memori di dalam aliran data futuristik. Website ini dibuat khusus untuk kenangan kita.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="#gallery" class="w-full sm:w-auto bg-cyan-500 text-black font-bold px-8 py-4 rounded-full hover:bg-cyan-400 transition shadow-[0_0_20px_rgba(6,182,212,0.5)]">
                Mulai Perjalanan
            </a>
            <a href="{{ route('categories.index') }}" class="w-full sm:w-auto border border-pink-500 text-pink-500 font-bold px-8 py-4 rounded-full hover:bg-pink-500/10 transition">
                Lihat Kategori
            </a>
        </div>
    </div>
</section>

<section id="gallery" class="container mx-auto px-4 sm:px-6 py-16 md:py-20">
    <div class="flex items-center space-x-4 mb-10 md:mb-12">
        <div class="h-1 w-8 md:w-12 bg-cyan-500"></div>
        <h2 class="text-2xl md:text-3xl font-bold tracking-tight">LATEST <span class="text-cyan-500">RECAP</span></h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">
        @foreach($categories as $cat)
        <div class="group relative bg-gray-900/50 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-sm">
            <div class="h-56 md:h-64 overflow-hidden">
                @if($cat->cover_image)
                    {{-- Langsung gunakan $cat->cover_image karena sudah URL Cloudinary --}}
                    <img src="{{ $cat->cover_image }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-700 scale-110 group-hover:scale-100">
                @endif
            </div>
            <div class="p-5 md:p-6">
                <h3 class="text-lg md:text-xl font-bold text-cyan-400 mb-1">{{ $cat->nama_kategori }}</h3>
                <p class="text-gray-500 text-xs md:text-sm mb-4">{{ $cat->images_count }} Data Captured</p>
                <a href="{{ route('categories.show', $cat->id) }}" class="inline-flex items-center text-pink-500 font-bold text-xs md:text-sm hover:translate-x-2 transition">
                    OPEN FOLDER <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="absolute inset-0 border-2 border-transparent group-hover:border-cyan-500/50 rounded-2xl pointer-events-none transition"></div>
        </div>
        @endforeach
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fadeElements = document.querySelectorAll('.fade-up');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });
        fadeElements.forEach(el => observer.observe(el));
    });
</script>
@endsection
