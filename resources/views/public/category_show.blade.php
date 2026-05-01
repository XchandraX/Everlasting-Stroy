@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-8 md:py-12">
        <div class="mb-8 text-center">
            <h1 class="text-2xl md:text-4xl font-bold text-white tracking-tight">{{ $category->nama_kategori }}</h1>
            <p class="text-gray-400 mt-2 mb-8 text-sm md:text-base italic">// Capture the moment, secure the data.</p>

            {{-- Tombol Filter --}}
            <div id="filter-buttons" class="filter-switch">
                <button id="filter-images" class="filter-btn active" data-filter="image">
                    <i class="bi bi-camera-fill"></i> Images
                </button>
                <button id="filter-videos" class="filter-btn" data-filter="video">
                    <i class="bi bi-film"></i> Videos
                </button>
            </div>
        </div>

        {{-- GRID MODE --}}
        <div id="view-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 md:gap-4">
            @foreach ($images as $image)
                <div class="group flex flex-col bg-slate-900/50 rounded-xl overflow-hidden border border-white/10 hover:border-cyan-500/50 transition-all duration-500 shadow-lg"
                     data-media-type="{{ $image->media_type }}">
                    @if ($image->media_type == 'video')
                        @php
                            // Generate poster URL dari Cloudinary (frame di detik 0.5)
                            $posterUrl = preg_replace('/\/upload\/(v\d+\/)?/', '/upload/so_0.5/', $image->file_path);
                            $posterUrl = preg_replace('/\.(mp4|webm|mov|avi|mkv)$/', '.jpg', $posterUrl);
                        @endphp
                        <a href="{{ $image->file_path }}"
                           class="glightbox block overflow-hidden aspect-[4/6] relative"
                           data-glightbox="type: video; title: {{ $image->title }}; description: {{ $image->description ?? 'Video Asset' }}">
                            <video class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                   muted preload="metadata" poster="{{ $posterUrl }}">
                                <source src="{{ $image->file_path }}" type="video/mp4">
                            </video>
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <div class="w-12 h-12 rounded-full bg-cyan-500/80 flex items-center justify-center backdrop-blur-sm shadow-lg">
                                    <i class="bi bi-play-fill text-black text-2xl ml-0.5"></i>
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ $image->file_path }}"
                           class="glightbox block overflow-hidden aspect-[4/6]"
                           data-glightbox="title: {{ $image->title }}; description: {{ $image->description ?? 'Image Asset' }}">
                            <img src="{{ $image->file_path }}" alt="{{ $image->title }}" loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </a>
                    @endif
                    <div class="p-3 bg-black/40 border-t border-white/5">
                        <p class="text-[10px] md:text-xs font-bold text-gray-300 group-hover:text-cyan-400 transition-colors uppercase tracking-widest truncate">
                            {{ $image->title }}
                        </p>
                        <p class="text-[8px] text-gray-600 mt-1 uppercase font-mono tracking-tighter">
                            {{ $image->media_type == 'video' ? 'Asset_Video' : 'Asset_Rec' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
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

    <style>
        .filter-switch {
            display: inline-flex;
            gap: 0.75rem;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            padding: 0.5rem;
            border-radius: 60px;
            border: 1px solid rgba(14, 165, 233, 0.3);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.1);
            margin-bottom: 2rem;
        }
        .filter-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.6rem;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: transparent;
            border: none;
            border-radius: 40px;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            font-family: 'JetBrains Mono', monospace;
        }
        .filter-btn i {
            font-size: 1.1rem;
            transition: transform 0.2s;
        }
        .filter-btn:hover {
            color: #7dd3fc;
            background: rgba(14, 165, 233, 0.1);
            transform: translateY(-2px);
        }
        .filter-btn.active {
            background: linear-gradient(135deg, #0ea5e9, #a855f7);
            color: #0f172a;
            box-shadow: 0 0 15px rgba(14, 165, 233, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .filter-btn.active i {
            transform: scale(1.1);
            filter: drop-shadow(0 0 4px white);
        }
        .glightbox-clean .gslide-title {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.2rem;
            font-weight: bold;
            color: #0ea5e9;
            text-shadow: 0 0 10px #0ea5e9;
        }
        .glightbox-clean .gslide-desc {
            font-family: monospace;
            font-size: 0.85rem;
            color: #cbd5e1;
        }
        .glightbox-clean .gclose,
        .glightbox-clean .gnext,
        .glightbox-clean .gprev {
            filter: drop-shadow(0 0 5px #0ea5e9);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: false,
                autoplayVideos: true,
                zoomable: true,
                draggable: true,
                closeOnOutsideClick: true,
                moreLength: 0,
                slideEffect: 'fade',
                plyr: {
                    controls: ['play', 'pause', 'progress', 'current-time', 'duration', 'mute', 'volume', 'fullscreen'],
                    settings: ['captions', 'quality', 'speed'],
                },
                cssEfects: {
                    fade: { in: 'fadeIn', out: 'fadeOut' }
                }
            });

            const viewGrid = document.getElementById('view-grid');
            const btnImages = document.getElementById('filter-images');
            const btnVideos = document.getElementById('filter-videos');
            const urlParams = new URLSearchParams(window.location.search);
            let currentFilter = urlParams.get('filter') || 'image';

            function updateFilterUI() {
                if (currentFilter === 'image') {
                    btnImages.classList.add('active');
                    btnVideos.classList.remove('active');
                } else {
                    btnVideos.classList.add('active');
                    btnImages.classList.remove('active');
                }
            }

            function filterGrid() {
                const items = viewGrid.querySelectorAll('[data-media-type]');
                items.forEach(item => {
                    const type = item.getAttribute('data-media-type');
                    if (currentFilter === 'all' || type === currentFilter) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
                lightbox.reload();
            }

            function setFilter(filter, updateUrl = false) {
                currentFilter = filter;
                updateFilterUI();
                filterGrid();
                if (updateUrl) {
                    urlParams.set('filter', filter);
                    window.history.replaceState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
                }
                document.querySelectorAll('.pagination-wrapper a').forEach(link => {
                    let url = new URL(link.href);
                    url.searchParams.set('filter', filter);
                    link.href = url.toString();
                });
            }

            if (urlParams.has('filter')) {
                currentFilter = urlParams.get('filter');
                setFilter(currentFilter);
            } else {
                setFilter('image');
            }

            btnImages.addEventListener('click', () => setFilter('image', true));
            btnVideos.addEventListener('click', () => setFilter('video', true));
        });
    </script>
@endsection
