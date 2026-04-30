@extends('layouts.admin')

@section('admin_content')
    <div class="fade-up">
        <div class="mb-10">
            <h2 class="text-3xl font-black text-white italic tracking-tighter uppercase">Dashboard<span
                    class="text-cyan-400">_Analysis</span></h2>
            <div class="h-1 w-20 bg-pink-600 mt-2"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div
                class="bg-gray-900/40 border border-cyan-500/30 p-8 rounded-2xl relative group overflow-hidden transition-all duration-500 hover:shadow-[0_0_30px_rgba(6,182,212,0.15)] hover:border-cyan-400">
                <div
                    class="absolute -right-4 -top-4 opacity-10 text-8xl transition group-hover:scale-110 group-hover:opacity-20">
                    <i class="bi bi-images text-cyan-400"></i>
                </div>
                <p class="text-xs font-bold text-cyan-500 uppercase tracking-widest mb-2">Total Photo Data</p>
                <h3 class="text-5xl font-black text-white">{{ \App\Models\Image::count() }}</h3>
                <p class="text-[10px] text-gray-400 mt-4 font-mono flex items-center">
                    <span class="w-2 h-2 bg-cyan-500 rounded-full mr-2 animate-pulse"></span> INTEGRITY: SECURED
                </p>
            </div>

            <div
                class="bg-gray-900/40 border border-pink-500/30 p-8 rounded-2xl relative group overflow-hidden transition-all duration-500 hover:shadow-[0_0_30px_rgba(219,39,119,0.15)] hover:border-pink-500">
                <div
                    class="absolute -right-4 -top-4 opacity-10 text-8xl transition group-hover:scale-110 group-hover:opacity-20 text-pink-500">
                    <i class="bi bi-collection"></i>
                </div>
                <p class="text-xs font-bold text-pink-500 uppercase tracking-widest mb-2">Category Nodes</p>
                <h3 class="text-5xl font-black text-white">{{ \App\Models\Kategori::count() }}</h3>
                <p class="text-[10px] text-gray-400 mt-4 font-mono flex items-center">
                    <span class="w-2 h-2 bg-pink-500 rounded-full mr-2 animate-pulse"></span> STATUS: ACTIVE
                </p>
            </div>

            <div
                class="bg-gray-900/40 border border-white/10 p-8 rounded-2xl flex flex-col justify-center backdrop-blur-sm transition-all hover:bg-gray-900/60">
                <p class="text-xs text-gray-400 mb-4 font-mono uppercase tracking-tighter">// Quick Deployment</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.images.create') }}"
                        class="w-full bg-cyan-600 text-black text-center py-3 rounded-lg font-black text-xs hover:bg-cyan-400 transition shadow-[0_4px_15px_rgba(8,145,178,0.3)]">ADD
                        NEW PHOTO</a>
                    <a href="{{ route('admin.categories.create') }}"
                        class="w-full border border-pink-500/50 text-pink-500 text-center py-3 rounded-lg font-black text-xs hover:bg-pink-500 hover:text-white transition">CREATE
                        CATEGORY</a>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-mono text-gray-500 uppercase tracking-[0.3em]">Recent_System_Logs</p>
                <div class="h-[1px] flex-1 bg-white/5 ml-4"></div>
            </div>
            <div
                class="border border-cyan-500/20 bg-black/40 p-5 rounded-xl text-[11px] text-cyan-400/80 font-mono leading-relaxed shadow-inner">
                <div class="space-y-1">
                    <p><span class="text-pink-600">[{{ now()->format('H:i:s') }}]</span> INITIALIZING GALLERY SYSTEM...</p>
                    <p><span class="text-pink-600">[{{ now()->subMinutes(5)->format('H:i:s') }}]</span> ALL MEMORY ASSETS
                        LOADED SUCCESSFULLY.</p>
                    <p><span class="text-pink-600">[{{ now()->subMinutes(12)->format('H:i:s') }}]</span> CONNECTION
                        ENCRYPTED VIA QUANTUM_PROTO_V4.</p>
                    <p class="animate-pulse">_</p>
                </div>
            </div>
        </div>
    </div>
@endsection
