@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-8 md:py-12">
        <div class="mb-8 text-center">
            <h1 class="text-2xl md:text-4xl font-bold text-white tracking-tight">{{ $category->nama_kategori }}</h1>
            <p class="text-gray-400 mt-2 mb-8 text-sm md:text-base italic">// Capture the moment, secure the data.</p>
            
            {{-- Tombol Switcher --}}
            <div class="inline-flex p-1 bg-slate-900 border border-white/10 rounded-xl mb-10 shadow-inner">
                <button id="btn-grid" class="mode-btn">Grid Mode</button>
                <button id="btn-arc" class="mode-btn">Arc Mode</button>
            </div>
        </div>

        <div id="gallery-container">
            <div id="view-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-4">
                @foreach ($images as $image)
                    <div class="group flex flex-col bg-slate-900/50 rounded-xl overflow-hidden border border-white/10 hover:border-cyan-500/50 transition-all duration-500 shadow-lg">
                        <a href="{{ asset('storage/' . $image->file_path) }}" class="glightbox block overflow-hidden aspect-[4/6]">
                            <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->title }}" loading="lazy"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </a>

                        <div class="p-3 bg-black/40 border-t border-white/5">
                            <p class="text-[10px] md:text-xs font-bold text-gray-300 group-hover:text-cyan-400 transition-colors uppercase tracking-widest truncate">
                                {{ $image->title }}
                            </p>
                            <p class="text-[8px] text-gray-600 mt-1 uppercase font-mono tracking-tighter">Class: Asset_Rec</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="view-arc" class="hidden grid grid-cols-1 lg:grid-cols-2 gap-y-32 md:gap-y-44 pt-16 pb-24 px-4">
                @php
                    $userAgent = request()->header('User-Agent');
                    $isMobile = preg_match('/mobile/i', $userAgent);
                    $chunks = $images->chunk($isMobile ? 3 : 4);
                @endphp

                @foreach ($chunks as $chunk)
                    <div class="wrapper-row flex justify-center items-center min-h-[350px] md:h-[450px]">
                        <div class="wrapper relative">
                            @foreach ($chunk as $image)
                                <div class="card-item !bg-slate-900 border border-white/10 shadow-2xl overflow-hidden group/item">
                                    <div class="w-full h-full relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->file_path) }}" alt="{{ $image->title }}" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover/item:scale-110">
                                        
                                        {{-- Overlay Gelap --}}
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-80"></div>
                                    </div>

                                    <div class="card-title !text-cyan-400 font-black !bg-black/80 backdrop-blur-md border border-cyan-500/30 uppercase tracking-[0.2em] shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                                        {{ $image->title }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-16 mb-12 flex flex-col items-center">
            <div class="pagination-wrapper flex items-center gap-1">
                @if (!$images->onFirstPage())
                    <a href="{{ $images->previousPageUrl() }}" class="btn-nav hover:bg-cyan-500/10 transition-all px-3">
                        <i class="bi bi-chevron-left text-cyan-500"></i>
                    </a>
                @endif

                <div class="hidden md:flex gap-2">
                    @foreach ($images->getUrlRange(max(1, $images->currentPage() - 2), min($images->lastPage(), $images->currentPage() + 2)) as $page => $url)
                        @if ($page == $images->currentPage())
                            <span class="active-page scale-110">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="hover:text-cyan-400 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach
                </div>

                <span class="md:hidden text-xs font-mono font-bold text-cyan-500 border border-cyan-500/30 px-3 py-1 rounded-full bg-cyan-500/5">
                    INDEX_{{ $images->currentPage() }}/{{ $images->lastPage() }}
                </span>

                @if ($images->hasMorePages())
                    <a href="{{ $images->nextPageUrl() }}" class="btn-nav hover:bg-cyan-500/10 transition-all px-3">
                        <i class="bi bi-chevron-right text-cyan-500"></i>
                    </a>
                @endif
            </div>

            <p class="mt-8 text-[12px] text-gray-600 uppercase tracking-[0.4em] text-center font-mono animate-pulse">
                Captured Data Stream: {{ $images->firstItem() }}-{{ $images->lastItem() }} // Total: {{ $images->total() }}
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnGrid = document.getElementById('btn-grid');
            const btnArc = document.getElementById('btn-arc');
            const viewGrid = document.getElementById('view-grid');
            const viewArc = document.getElementById('view-arc');

            const urlParams = new URLSearchParams(window.location.search);
            let currentMode = urlParams.get('mode') || 'grid';

            function setMode(mode, updateUrl = false) {
                if (mode === 'grid') {
                    viewGrid.classList.remove('hidden');
                    viewArc.classList.add('hidden');
                    btnGrid.classList.add('active');
                    btnArc.classList.remove('active');
                } else {
                    viewGrid.classList.add('hidden');
                    viewArc.classList.remove('hidden');
                    btnArc.classList.add('active');
                    btnGrid.classList.remove('active');
                }

                if (updateUrl) {
                    urlParams.set('mode', mode);
                    window.history.replaceState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
                }

                // Update links pagination agar tetap di mode yang sama
                document.querySelectorAll('.pagination-wrapper a').forEach(link => {
                    let url = new URL(link.href);
                    url.searchParams.set('mode', mode);
                    link.href = url.toString();
                });
            }

            setMode(currentMode);
            btnGrid.addEventListener('click', () => setMode('grid', true));
            btnArc.addEventListener('click', () => setMode('arc', true));
        });
    </script>
@endsection