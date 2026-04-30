@extends('layouts.admin')

@section('admin_content')
<div class="fade-up max-w-4xl mx-auto">
    <div class="mb-10">
        <p class="text-[10px] text-cyan-500 font-mono tracking-[0.5em] mb-1">// SYSTEM_RECONFIGURATION</p>
        <h2 class="text-3xl font-black italic text-white uppercase tracking-tighter">Modify<span class="text-pink-600">_Asset</span></h2>
        <div class="h-1 w-20 bg-cyan-500 mt-2 shadow-[0_0_10px_rgba(6,182,212,0.5)]"></div>
    </div>

    <form action="{{ route('admin.images.update', $image->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-4">
                <label class="block text-[10px] font-mono text-gray-500 uppercase tracking-widest">Current_Visual_Data</label>
                <div class="relative group aspect-video rounded-2xl overflow-hidden border border-white/10 bg-black/40 backdrop-blur-md">
                    <img src="{{ asset('storage/' . $image->file_path) }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity">
                        <p class="text-[10px] font-mono text-cyan-400">REPLACE_FILE_DETECTED</p>
                    </div>
                </div>
                <input type="file" name="image" class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-cyan-500/10 file:text-cyan-500 hover:file:bg-cyan-500/20 transition cursor-pointer">
                <p class="text-[9px] text-gray-600 italic">*Leave empty to keep existing data stream</p>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-mono text-gray-500 uppercase tracking-widest mb-2">Asset_Title</label>
                    <input type="text" name="title" value="{{ $image->title }}" required
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/20 transition">
                </div>

                <div>
                    <label class="block text-[10px] font-mono text-gray-500 uppercase tracking-widest mb-2">Cluster_Assignment</label>
                    <select name="kategori_id" required
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-pink-500/50 focus:ring-1 focus:ring-pink-500/20 transition appearance-none">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $image->kategori_id == $cat->id ? 'selected' : '' }}>
                                {{ strtoupper($cat->nama_kategori) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-mono text-gray-500 uppercase tracking-widest mb-2">Data_Description</label>
                    <textarea name="description" rows="3"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-cyan-500/50 transition">{{ $image->description }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex gap-4 pt-8 border-t border-white/5">
            <button type="submit" 
                class="flex-1 bg-cyan-500 text-black font-black py-4 rounded-xl text-xs hover:bg-cyan-400 transition shadow-[0_0_20px_rgba(6,182,212,0.2)] uppercase tracking-[0.2em]">
                Execute_Update
            </button>
            <a href="{{ route('admin.images.index') }}" 
                class="px-8 border border-white/10 text-gray-500 font-black py-4 rounded-xl text-xs hover:bg-white/5 hover:text-white transition uppercase tracking-[0.2em]">
                Abort
            </a>
        </div>
    </form>
</div>
@endsection