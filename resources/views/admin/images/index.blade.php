@extends('layouts.admin')

@section('admin_content')
    <div class="fade-up">
        <div class="flex justify-between items-end mb-6">
            <div>
                <p class="text-[10px] text-pink-600 font-mono tracking-[0.5em] mb-1">// ASSET_DATABASE</p>
                <h2 class="text-3xl font-black italic text-white uppercase tracking-tighter">Asset<span
                        class="text-cyan-400">_Stream</span></h2>
                <div class="h-1 w-20 bg-pink-600 mt-2 shadow-[0_0_10px_rgba(219,39,119,0.5)]"></div>
            </div>
            <a href="{{ route('admin.images.create') }}"
                class="bg-cyan-500 text-black font-black px-6 py-2 rounded-lg text-[10px] hover:bg-cyan-400 transition shadow-[0_0_20px_rgba(6,182,212,0.3)] border border-cyan-300/50 tracking-widest uppercase">
                [+] Upload_New_Data
            </a>
        </div>

        <div class="mb-10 p-4 bg-black/40 border border-white/5 rounded-2xl backdrop-blur-sm">
            <div class="flex items-center gap-4 overflow-x-auto pb-2 no-scrollbar">
                <span class="text-[10px] font-mono text-gray-500 uppercase tracking-widest whitespace-nowrap">
                    <i class="bi bi-filter-left text-cyan-400"></i> Sort_By_Cluster:
                </span>

                <a href="{{ route('admin.images.index') }}"
                    class="px-4 py-1.5 rounded-full text-[10px] font-bold transition-all border {{ !request('category') ? 'bg-cyan-500 text-black border-cyan-400' : 'text-gray-400 border-white/10 hover:border-cyan-500/50' }}">
                    ALL_ASSETS
                </a>

                @foreach ($categories as $cat)
                    <a href="{{ route('admin.images.index', ['category' => $cat->id]) }}"
                        class="px-4 py-1.5 rounded-full text-[10px] font-bold transition-all border {{ request('category') == $cat->id ? 'bg-pink-600 text-white border-pink-400' : 'text-gray-400 border-white/10 hover:border-pink-500/50' }}">
                        {{ strtoupper($cat->nama_kategori) }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-6">
            @forelse($images as $image)
                <div
                    class="group bg-black/40 border border-white/5 p-4 rounded-2xl hover:border-cyan-500/50 transition-all duration-500 hover:shadow-[0_0_25px_rgba(6,182,212,0.1)] backdrop-blur-sm relative overflow-hidden">
                    <div class="relative h-48 overflow-hidden rounded-xl mb-4 bg-slate-900">
                        @if ($image->media_type == 'video')
                            @php
                                $thumbUrl = preg_replace('/\/upload\/(v\d+\/)?/', '/upload/so_0.5/', $image->file_path);
                                $thumbUrl = preg_replace('/\.(mp4|webm|mov|avi|mkv)$/', '.jpg', $thumbUrl);
                                // Cek apakah file_path adalah URL valid (Cloudinary) atau path lokal
                                $videoSrc = filter_var($image->file_path, FILTER_VALIDATE_URL)
                                    ? $image->file_path
                                    : asset('storage/' . $image->file_path);
                                $posterSrc = filter_var($thumbUrl, FILTER_VALIDATE_URL)
                                    ? $thumbUrl
                                    : asset('storage/' . $thumbUrl);
                            @endphp
                            <video src="{{ $videoSrc }}"
                                class="w-full h-full object-cover opacity-70 group-hover:opacity-100 group-hover:scale-110 transition duration-700"
                                muted preload="metadata" poster="{{ $posterSrc }}"></video>
                            <div class="absolute top-3 right-3 bg-pink-600 text-[8px] px-1 py-0.5 rounded">VIDEO</div>
                        @else
                            @php
                                // Cek apakah file_path adalah URL valid (Cloudinary) atau path lokal
                                $imgSrc = filter_var($image->file_path, FILTER_VALIDATE_URL)
                                    ? $image->file_path
                                    : asset('storage/' . $image->file_path);
                            @endphp
                            <img src="{{ $imgSrc }}"
                                class="w-full h-full object-cover opacity-70 group-hover:opacity-100 group-hover:scale-110 transition duration-700">
                        @endif
                        <div class="absolute top-3 left-3">
                            <span
                                class="bg-black/80 text-[9px] text-cyan-400 px-2 py-1 border border-cyan-500/30 rounded font-mono">
                                #{{ str_pad($image->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>
                    <h3 class="font-black text-xs text-white uppercase truncate">{{ $image->title ?? 'UNTITLED' }}</h3>
                    <p class="text-[10px] text-pink-500 font-mono mt-1 tracking-tighter italic">
                        <i class="bi bi-tag-fill mr-1"></i> {{ $image->kategori->nama_kategori }}
                    </p>

                    <div class="flex gap-2 mt-4 pt-4 border-t border-white/5">
                        <a href="{{ route('admin.images.edit', $image->id) }}"
                            class="flex-1 text-center py-2 bg-white/5 hover:bg-cyan-500/20 rounded-lg text-[9px] font-bold text-gray-400 hover:text-cyan-400 transition-all border border-transparent hover:border-cyan-500/30 uppercase tracking-widest">
                            Modify
                        </a>

                        <form action="{{ route('admin.images.destroy', $image->id) }}" method="POST"
                            class="delete-form flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="delete-btn w-full py-2 bg-pink-500/5 hover:bg-pink-600 hover:text-white rounded-lg text-[9px] font-black text-pink-600 transition-all border border-pink-500/20 uppercase tracking-widest">
                                Erase
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center border border-dashed border-white/10 rounded-3xl">
                    <i class="bi bi-folder2-open text-5xl text-gray-700 mb-4 block"></i>
                    <p class="text-gray-500 font-mono text-sm uppercase">No data found in this category cluster.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION DENGAN JUMP TO PAGE (DENGAN FILTER) --}}
        <div class="pagination-wrapper flex items-center gap-2">
            @if ($images->currentPage() > 3)
                <a href="{{ $images->url(1) . '&category=' . request('category', '') }}" class="btn-nav-terminal"
                    title="First Page">
                    <i class="bi bi-chevron-double-left"></i>
                </a>
            @endif

            <div class="hidden md:flex items-center gap-2">
                @foreach ($images->getUrlRange(max(1, $images->currentPage() - 2), min($images->lastPage(), $images->currentPage() + 2)) as $page => $url)
                    @if ($page == $images->currentPage())
                        <div class="relative">
                            <span class="btn-nav-terminal border-cyan-500 text-pink-500 bg-cyan-500/10 font-bold">
                                {{ str_pad($page, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div class="absolute -bottom-1 left-0 w-full h-0.5 bg-pink-500"></div>
                        </div>
                    @else
                        <a href="{{ $url . '&category=' . request('category', '') }}"
                            class="btn-nav-terminal hover:text-cyan-400">
                            {{ str_pad($page, 2, '0', STR_PAD_LEFT) }}
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- JUMP TO PAGE (CSS NATIVE) --}}
            <div class="jump-control">
                <span class="jump-label">GO TO</span>
                <input type="number" id="page-jump-input" min="1" max="{{ $images->lastPage() }}"
                    value="{{ $images->currentPage() }}" class="jump-input">
                <button id="page-jump-btn" class="jump-btn">JUMP</button>
            </div>

            @if ($images->currentPage() < $images->lastPage() - 2)
                <span class="text-gray-700 px-1 font-black">...</span>
                <a href="{{ $images->url($images->lastPage()) . '&category=' . request('category', '') }}"
                    class="btn-nav-terminal" title="Last Page">
                    <i class="bi bi-chevron-double-right"></i>
                </a>
            @endif
        </div>

        <p class="mt-8 text-[9px] text-gray-600 uppercase tracking-[0.4em] text-center font-mono">
            <span class="text-cyan-500 animate-pulse">●</span>
            NODE_POS: {{ $images->currentPage() }} / {{ $images->lastPage() }}
            <span class="mx-2">||</span>
            TOTAL_STREAM: {{ $images->total() }}
        </p>

        {{-- CSS NATIVE SAMA SEPERTI SEBELUMNYA --}}
        <style>
            .jump-control {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background: rgba(0, 0, 0, 0.4);
                padding: 0.25rem 0.75rem;
                border-radius: 40px;
                border: 1px solid rgba(6, 182, 212, 0.3);
            }

            .jump-label {
                font-size: 10px;
                font-weight: bold;
                color: #6b7280;
                letter-spacing: 1px;
                font-family: monospace;
            }

            .jump-input {
                width: 60px;
                padding: 6px 8px;
                text-align: center;
                font-size: 12px;
                background: #0f172a;
                border: 1px solid #06b6d4;
                border-radius: 8px;
                color: #06b6d4;
                font-family: monospace;
                font-weight: bold;
            }

            .jump-input:focus {
                outline: none;
                background: #1e293b;
                box-shadow: 0 0 8px #06b6d4;
            }

            .jump-btn {
                padding: 6px 14px;
                background: linear-gradient(135deg, #06b6d4, #3b82f6);
                border: none;
                border-radius: 30px;
                color: white;
                font-size: 10px;
                font-weight: bold;
                cursor: pointer;
                transition: 0.2s;
            }

            .jump-btn:hover {
                transform: scale(1.02);
                box-shadow: 0 0 12px #06b6d4;
            }

            .jump-input::-webkit-inner-spin-button,
            .jump-input::-webkit-outer-spin-button {
                opacity: 0.5;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const jumpInput = document.getElementById('page-jump-input');
                const jumpBtn = document.getElementById('page-jump-btn');
                const maxPage = {{ $images->lastPage() }};
                const currentFilter = '{{ request('category') }}';

                function goToPage() {
                    let target = parseInt(jumpInput.value);
                    if (isNaN(target)) target = 1;
                    if (target < 1) target = 1;
                    if (target > maxPage) target = maxPage;
                    let url = '{{ $images->url('') }}/' + target;
                    if (currentFilter) {
                        url += '?category=' + currentFilter;
                    }
                    window.location.href = url;
                }

                jumpBtn.addEventListener('click', goToPage);
                jumpInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') goToPage();
                });
            });
        </script>
    @endsection
